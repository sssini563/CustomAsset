<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('action_logs', function (Blueprint $table) {
            if (!Schema::hasColumn('action_logs', 'create_document')) {
                $table->boolean('create_document')->default(false)->after('action_date');
            }
        });
    }

    public function down(): void
    {
        Schema::table('action_logs', function (Blueprint $table) {
            if (Schema::hasColumn('action_logs', 'create_document')) {
                $table->dropColumn('create_document');
            }
        });
    }
};
