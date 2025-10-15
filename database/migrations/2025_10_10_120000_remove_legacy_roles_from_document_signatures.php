<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Remove legacy roles that are no longer used in UI/workflow
        DB::table('document_signatures')->whereIn('role', ['it_manager','atasan_penerima'])->delete();
    }

    public function down(): void
    {
        // No-op (cannot restore deleted rows reliably)
    }
};
