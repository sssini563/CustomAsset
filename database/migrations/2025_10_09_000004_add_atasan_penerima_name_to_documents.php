<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            if (!Schema::hasColumn('documents','atasan_penerima_name')) {
                $table->string('atasan_penerima_name')->nullable()->after('nama_penerima');
            }
        });
    }
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            if (Schema::hasColumn('documents','atasan_penerima_name')) {
                $table->dropColumn('atasan_penerima_name');
            }
        });
    }
};
