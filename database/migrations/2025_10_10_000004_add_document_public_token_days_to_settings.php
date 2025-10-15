<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            if (!Schema::hasColumn('settings', 'document_public_token_days')) {
                $table->unsignedInteger('document_public_token_days')->nullable()->after('manager_view_enabled');
            }
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            if (Schema::hasColumn('settings', 'document_public_token_days')) {
                $table->dropColumn('document_public_token_days');
            }
        });
    }
};
