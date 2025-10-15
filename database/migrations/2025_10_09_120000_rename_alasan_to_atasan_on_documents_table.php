<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            if (Schema::hasColumn('documents','alasan_penerima') && !Schema::hasColumn('documents','atasan_penerima_name')) {
                $table->renameColumn('alasan_penerima','atasan_penerima_name');
            } elseif (Schema::hasColumn('documents','alasan_penerima') && Schema::hasColumn('documents','atasan_penerima_name')) {
                // If both exist (edge case), copy data where target empty then drop source
                DB::statement("UPDATE documents SET atasan_penerima_name = COALESCE(atasan_penerima_name, alasan_penerima) WHERE (atasan_penerima_name IS NULL OR atasan_penerima_name='') AND alasan_penerima IS NOT NULL");
                $table->dropColumn('alasan_penerima');
            }
        });
    }

    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            if (Schema::hasColumn('documents','atasan_penerima_name') && !Schema::hasColumn('documents','alasan_penerima')) {
                $table->renameColumn('atasan_penerima_name','alasan_penerima');
            }
        });
    }
};
