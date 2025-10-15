<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('document_signatures', function (Blueprint $table) {
            if (!Schema::hasColumn('document_signatures', 'public_token')) {
                $table->uuid('public_token')->nullable()->unique()->after('note');
            }
        });
    }

    public function down(): void
    {
        Schema::table('document_signatures', function (Blueprint $table) {
            if (Schema::hasColumn('document_signatures', 'public_token')) {
                $table->dropUnique(['public_token']);
                $table->dropColumn('public_token');
            }
        });
    }
};