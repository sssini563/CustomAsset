<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            if (!Schema::hasColumn('documents', 'pdf_path')) {
                $table->string('pdf_path')->nullable()->after('overall_status');
            }
            if (!Schema::hasColumn('documents', 'completed_at')) {
                $table->timestamp('completed_at')->nullable()->after('pdf_path');
            }
        });
    }

    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            if (Schema::hasColumn('documents', 'completed_at')) {
                $table->dropColumn('completed_at');
            }
            if (Schema::hasColumn('documents', 'pdf_path')) {
                $table->dropColumn('pdf_path');
            }
        });
    }
};
