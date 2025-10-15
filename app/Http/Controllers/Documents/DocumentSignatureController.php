<?php
namespace App\Http\Controllers\Documents;

use App\Http\Controllers\Controller;
use App\Models\{Document, DocumentSignature};
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DocumentSignatureController extends Controller
{
    public function sign(Request $request, Document $document, string $role): JsonResponse
    {
        $signature = $document->getSignature($role);
        if (!$signature) { return response()->json(['message'=>'Role not found'],404); }
        if (!auth()->user()->can('sign', [$document,$role])) {
            return response()->json(['message'=>'Unauthorized or not your turn'],403);
        }
        $signature->sign($request->get('note'));
        // Log action
        \App\Models\Actionlog::create([
            'item_type' => Document::class,
            'item_id' => $document->id,
            'action_type' => 'document_signature_signed',
            'note' => 'Signature '.$role.' signed by user '.auth()->id(),
            'created_by' => auth()->id(),
        ]);
        return response()->json(['message'=>'Signed','overall_status'=>$document->overall_status]);
    }

    public function reject(Request $request, Document $document, string $role): JsonResponse
    {
        $signature = $document->getSignature($role);
        if (!$signature) { return response()->json(['message'=>'Role not found'],404); }
        if (!auth()->user()->can('reject', [$document,$role])) {
            return response()->json(['message'=>'Unauthorized or not your turn'],403);
        }
        $signature->reject($request->get('note'));
        \App\Models\Actionlog::create([
            'item_type' => Document::class,
            'item_id' => $document->id,
            'action_type' => 'document_signature_rejected',
            'note' => 'Signature '.$role.' rejected by user '.auth()->id(),
            'created_by' => auth()->id(),
        ]);
        return response()->json(['message'=>'Rejected','overall_status'=>$document->overall_status]);
    }
}
