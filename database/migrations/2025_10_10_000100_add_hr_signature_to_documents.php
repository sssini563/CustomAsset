<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Backfill HR signatures for existing documents if missing (avoid using Eloquent models in migrations)
        DB::table('documents')
            ->orderBy('id')
            ->select(['id'])
            ->chunkById(200, function ($docs) {
                foreach ($docs as $doc) {
                    $docId = $doc->id;

                    // Skip if an HR signature already exists for this document
                    $hasHr = DB::table('document_signatures')
                        ->where('document_id', $docId)
                        ->where('role', 'hr')
                        ->exists();

                    if ($hasHr) {
                        continue;
                    }

                    // Determine next ordering value for this document's signatures
                    $maxOrder = (int) (DB::table('document_signatures')
                        ->where('document_id', $docId)
                        ->max('ordering') ?? 0);

                    // Insert a pending HR signature placeholder
                    DB::table('document_signatures')->insert([
                        'document_id' => $docId,
                        'role' => 'hr',
                        'user_id' => null,
                        'user_name' => null,
                        'status' => 'pending',
                        'ordering' => $maxOrder + 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            });
    }

    public function down(): void
    {
        // Remove pending/unassigned HR signatures to avoid deleting signed history
        DB::table('document_signatures')
            ->where('role', 'hr')
            ->whereNull('user_id')
            ->whereNull('signed_at')
            ->delete();
    }
};
