<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            // For Asset: split metadata for Form Serah Terima (form_*) and Surat Pernyataan (sp_*)
            if (!Schema::hasColumn('documents', 'form_jenis_dokumen')) {
                $table->string('form_jenis_dokumen')->nullable()->after('author_doc');
            }
            if (!Schema::hasColumn('documents', 'form_sp_hal')) {
                $table->string('form_sp_hal')->nullable()->after('form_jenis_dokumen');
            }
            if (!Schema::hasColumn('documents', 'form_pemilik_proses')) {
                $table->string('form_pemilik_proses')->nullable()->after('form_sp_hal');
            }
            if (!Schema::hasColumn('documents', 'form_proses_bisnis')) {
                $table->string('form_proses_bisnis')->nullable()->after('form_pemilik_proses');
            }
            if (!Schema::hasColumn('documents', 'form_doc_control_no')) {
                $table->string('form_doc_control_no')->nullable()->after('form_proses_bisnis');
            }
            if (!Schema::hasColumn('documents', 'form_effective_doc')) {
                $table->date('form_effective_doc')->nullable()->after('form_doc_control_no');
            }
            if (!Schema::hasColumn('documents', 'form_revision_date')) {
                $table->date('form_revision_date')->nullable()->after('form_effective_doc');
            }
            if (!Schema::hasColumn('documents', 'form_author_doc')) {
                $table->string('form_author_doc')->nullable()->after('form_revision_date');
            }

            if (!Schema::hasColumn('documents', 'sp_jenis_dokumen')) {
                $table->string('sp_jenis_dokumen')->nullable()->after('form_author_doc');
            }
            if (!Schema::hasColumn('documents', 'sp_sp_hal')) {
                $table->string('sp_sp_hal')->nullable()->after('sp_jenis_dokumen');
            }
            if (!Schema::hasColumn('documents', 'sp_pemilik_proses')) {
                $table->string('sp_pemilik_proses')->nullable()->after('sp_sp_hal');
            }
            if (!Schema::hasColumn('documents', 'sp_proses_bisnis')) {
                $table->string('sp_proses_bisnis')->nullable()->after('sp_pemilik_proses');
            }
            if (!Schema::hasColumn('documents', 'sp_doc_control_no')) {
                $table->string('sp_doc_control_no')->nullable()->after('sp_proses_bisnis');
            }
            if (!Schema::hasColumn('documents', 'sp_effective_doc')) {
                $table->date('sp_effective_doc')->nullable()->after('sp_doc_control_no');
            }
            if (!Schema::hasColumn('documents', 'sp_revision_date')) {
                $table->date('sp_revision_date')->nullable()->after('sp_effective_doc');
            }
            if (!Schema::hasColumn('documents', 'sp_author_doc')) {
                $table->string('sp_author_doc')->nullable()->after('sp_revision_date');
            }
        });
    }

    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            foreach ([
                'form_jenis_dokumen','form_sp_hal','form_pemilik_proses','form_proses_bisnis','form_doc_control_no','form_effective_doc','form_revision_date','form_author_doc',
                'sp_jenis_dokumen','sp_sp_hal','sp_pemilik_proses','sp_proses_bisnis','sp_doc_control_no','sp_effective_doc','sp_revision_date','sp_author_doc',
            ] as $col) {
                if (Schema::hasColumn('documents', $col)) { $table->dropColumn($col); }
            }
        });
    }
};
