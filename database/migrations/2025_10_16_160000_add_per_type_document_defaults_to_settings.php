<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            if (!Schema::hasColumn('settings','document_defaults_asset')) $table->json('document_defaults_asset')->nullable();
            if (!Schema::hasColumn('settings','document_defaults_component')) $table->json('document_defaults_component')->nullable();
            if (!Schema::hasColumn('settings','document_defaults_license')) $table->json('document_defaults_license')->nullable();
            if (!Schema::hasColumn('settings','document_defaults_accessory')) $table->json('document_defaults_accessory')->nullable();
            if (!Schema::hasColumn('settings','document_defaults_consumable')) $table->json('document_defaults_consumable')->nullable();
        });
    }
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            if (Schema::hasColumn('settings','document_defaults_consumable')) $table->dropColumn('document_defaults_consumable');
            if (Schema::hasColumn('settings','document_defaults_accessory')) $table->dropColumn('document_defaults_accessory');
            if (Schema::hasColumn('settings','document_defaults_license')) $table->dropColumn('document_defaults_license');
            if (Schema::hasColumn('settings','document_defaults_component')) $table->dropColumn('document_defaults_component');
            if (Schema::hasColumn('settings','document_defaults_asset')) $table->dropColumn('document_defaults_asset');
        });
    }
};
