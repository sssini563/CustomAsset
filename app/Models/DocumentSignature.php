<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class DocumentSignature extends Model
{
    use HasFactory;

    protected $fillable = ['document_id','role','user_id','user_name','status','signed_at','note','public_token','signature_image','ordering'];

    protected $casts = [
        'signed_at' => 'datetime',
        'public_token_expires_at' => 'datetime',
        'last_used_at' => 'datetime',
    ];

    public function document(): BelongsTo { return $this->belongsTo(Document::class); }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }

    public function sign(?string $note = null): bool
    {
        if ($this->status === 'signed') { return false; }
        $this->status = 'signed';
        $this->signed_at = now();
        if ($note) { $this->note = $note; }
        $saved = $this->save();
        if ($saved) { $this->document->updateOverallStatus(); }
        return $saved;
    }

    public function reject(?string $note = null): bool
    {
        if ($this->status === 'rejected') { return false; }
        $this->status = 'rejected';
        $this->signed_at = now();
        if ($note) { $this->note = $note; }
        $saved = $this->save();
        if ($saved) { $this->document->updateOverallStatus(); }
        return $saved;
    }

    public function ensurePublicToken(): string
    {
        if (!$this->public_token) {
            $this->public_token = (string) Str::uuid();
            // Prefer settings override if present
            $settings = \App\Models\Setting::getSettings();
            $days = (int) (($settings?->document_public_token_days) ?? config('documents.public_token_days', 14));
            $this->public_token_expires_at = $days > 0 ? now()->addDays($days) : null;
            $this->save();
        }
        return $this->public_token;
    }

    public function regeneratePublicToken(?int $daysValid = 14): void
    {
        $this->public_token = (string) Str::uuid();
        // If explicit days provided, use it; else prefer settings and then config
        if ($daysValid === null) {
            $settings = \App\Models\Setting::getSettings();
            $days = (int) (($settings?->document_public_token_days) ?? config('documents.public_token_days', 14));
        } else {
            $days = (int) $daysValid;
        }
        $this->public_token_expires_at = $days > 0 ? now()->addDays($days) : null;
        $this->save();
    }
}
