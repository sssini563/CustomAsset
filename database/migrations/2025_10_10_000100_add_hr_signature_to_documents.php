<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Backfill HR signatures for existing documents if missing
        \App\Models\Document::with('signatures')->chunkById(200, function($docs){
            foreach ($docs as $doc) {
                $hasHr = $doc->signatures->where('role','hr')->count() > 0;
                if (!$hasHr) {
                    $maxOrder = (int)($doc->signatures->max('ordering') ?? 0);
                    \App\Models\DocumentSignature::create([
                        'document_id' => $doc->id,
                        'role' => 'hr',
                        'user_id' => null,
                        'user_name' => null,
                        'status' => 'pending',
                        'ordering' => $maxOrder + 1,
                    ]);
                }
            }
        });
    }

    public function down(): void
    {
        // Remove HR signatures that are still pending and unassigned to avoid deleting history
        \App\Models\DocumentSignature::where('role','hr')->whereNull('user_id')->whereNull('signed_at')->delete();
    }
};
