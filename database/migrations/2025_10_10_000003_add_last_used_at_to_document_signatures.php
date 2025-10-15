<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('document_signatures', function (Blueprint $table) {
            if (!Schema::hasColumn('document_signatures', 'last_used_at')) {
                $table->timestamp('last_used_at')->nullable()->after('public_token_expires_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('document_signatures', function (Blueprint $table) {
            if (Schema::hasColumn('document_signatures', 'last_used_at')) {
                $table->dropColumn('last_used_at');
            }
        });
    }
};
