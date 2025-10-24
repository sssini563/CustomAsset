<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('document_default_jenis_dokumen')->nullable();
            $table->string('document_default_sp_hal')->nullable();
            $table->string('document_default_pemilik_proses')->nullable();
            $table->string('document_default_proses_bisnis')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'document_default_jenis_dokumen',
                'document_default_sp_hal',
                'document_default_pemilik_proses',
                'document_default_proses_bisnis',
            ]);
        });
    }
};
