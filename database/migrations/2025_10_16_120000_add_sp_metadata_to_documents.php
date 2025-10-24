<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            if (!Schema::hasColumn('documents','jenis_dokumen')) {
                $table->string('jenis_dokumen')->nullable()->after('author_doc');
            }
            if (!Schema::hasColumn('documents','sp_hal')) {
                $table->string('sp_hal')->nullable()->after('jenis_dokumen'); // e.g., "1 dari 1"
            }
            if (!Schema::hasColumn('documents','pemilik_proses')) {
                $table->string('pemilik_proses')->nullable()->after('sp_hal');
            }
            if (!Schema::hasColumn('documents','proses_bisnis')) {
                $table->string('proses_bisnis')->nullable()->after('pemilik_proses');
            }
        });
    }

    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            if (Schema::hasColumn('documents','proses_bisnis')) $table->dropColumn('proses_bisnis');
            if (Schema::hasColumn('documents','pemilik_proses')) $table->dropColumn('pemilik_proses');
            if (Schema::hasColumn('documents','sp_hal')) $table->dropColumn('sp_hal');
            if (Schema::hasColumn('documents','jenis_dokumen')) $table->dropColumn('jenis_dokumen');
        });
    }
};
