<?php
namespace App\Http\Controllers\Documents;

use App\Http\Controllers\Controller;
use App\Models\{Document, DocumentSignature};
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;

class PublicApprovalController extends Controller
{
    // No auth middleware. Token validated per request.
    protected function findByTokenOrAbort(string $token): DocumentSignature
    {
        $signature = DocumentSignature::with(['document.signatures','user'])->where('public_token',$token)->first();
        abort_unless($signature, 404);
        // Expiry check
        if ($signature->public_token_expires_at && now()->greaterThan($signature->public_token_expires_at)) {
            abort(403, 'Token expired');
        }
        return $signature;
    }

    protected function rateLimitOrAbort(Request $request, string $token): void
    {
        $ip = $request->ip() ?: 'unknown';
        $key = 'pub_approv_rl:'.$token.':'.$ip;
        $window = 60; // seconds
        $limit = 5; // max actions per window
        $hits = Cache::get($key, 0);
        if ($hits >= $limit) {
            abort(429, 'Too many requests. Try again later.');
        }
        Cache::put($key, $hits + 1, $window);
    }

    public function show(string $token): View
    {
        $signature = $this->findByTokenOrAbort($token);
        // Audit last used timestamp when the page is viewed
        $signature->last_used_at = now();
        $signature->save();
        $document = $signature->document;
        // Allow acting whenever this signature is pending (no sequential gating for public links)
        $canAct = $signature->status === 'pending';
        return view('documents.public.approval', compact('document','signature','canAct'));
    }

    public function approve(Request $request, string $token)
    {
        $signature = $this->findByTokenOrAbort($token);
        $document = $signature->document;
        // Simple rate limit (5 actions / minute by IP per token)
        $this->rateLimitOrAbort($request, $token);
        // Allow approve whenever this step is pending (no sequential gating via public link)
        $allowed = $signature->status === 'pending';
        if (!$allowed) {
            return back()->withErrors(['not_allowed'=>'Not allowed at this time.']);
        }
        $signature->last_used_at = now();
        $signature->save();
        $signature->sign($request->input('note'));
        \App\Models\Actionlog::create([
            'item_type' => Document::class,
            'item_id' => $document->id,
            'action_type' => 'document_signature_signed_public',
            'note' => 'Public token approval for role '.$signature->role.' from IP '.$request->ip(),
        ]);
        return redirect()->route('public.documents.approval.show', [$token])->with('status','Approved');
    }

    public function reject(Request $request, string $token)
    {
        $signature = $this->findByTokenOrAbort($token);
        $document = $signature->document;
        $this->rateLimitOrAbort($request, $token);
        // Allow reject whenever this step is pending (no sequential gating via public link)
        $allowed = $signature->status === 'pending';
        if (!$allowed) {
            return back()->withErrors(['not_allowed'=>'Not allowed at this time.']);
        }
        $request->validate(['note'=>'required|string|min:3']);
        $signature->last_used_at = now();
        $signature->save();
        $signature->reject($request->input('note'));
        \App\Models\Actionlog::create([
            'item_type' => Document::class,
            'item_id' => $document->id,
            'action_type' => 'document_signature_rejected_public',
            'note' => 'Public token rejection for role '.$signature->role.' from IP '.$request->ip().' - '.$request->input('note'),
        ]);
        return redirect()->route('public.documents.approval.show', [$token])->with('status','Rejected');
    }
}
