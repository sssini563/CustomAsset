<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $cols = [
                // legacy flat metadata
                'jenis_dokumen','sp_hal','pemilik_proses','proses_bisnis',
                'doc_control_no','effective_doc','revision_date','author_doc',
                // split asset form metadata
                'form_jenis_dokumen','form_sp_hal','form_pemilik_proses','form_proses_bisnis','form_doc_control_no','form_effective_doc','form_revision_date','form_author_doc',
                // split asset sp metadata
                'sp_jenis_dokumen','sp_sp_hal','sp_pemilik_proses','sp_proses_bisnis','sp_doc_control_no','sp_effective_doc','sp_revision_date','sp_author_doc',
            ];
            foreach ($cols as $col) {
                if (Schema::hasColumn('documents', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }

    public function down(): void
    {
        // Not restoring columns; if needed, create a separate migration to add them back.
    }
};
