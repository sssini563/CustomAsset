<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            if (!Schema::hasColumn('settings', 'document_defaults_asset_form')) {
                $table->json('document_defaults_asset_form')->nullable();
            }
            if (!Schema::hasColumn('settings', 'document_defaults_asset_sp')) {
                $table->json('document_defaults_asset_sp')->nullable();
            }
        });

        // Optional: backfill from existing per-asset defaults if present
        try {
            $conn = Schema::getConnection();
            $settings = $conn->table('settings')->first();
            if ($settings) {
                $asset = isset($settings->document_defaults_asset) ? $settings->document_defaults_asset : null;
                if (is_string($asset)) {
                    // If stored as JSON string in some environments
                    $decoded = json_decode($asset, true);
                    if (json_last_error() === JSON_ERROR_NONE) { $asset = $decoded; }
                }
                if (is_array($asset)) {
                    $conn->table('settings')->update([
                        'document_defaults_asset_form' => json_encode($asset),
                        'document_defaults_asset_sp' => json_encode($asset),
                    ]);
                }
            }
        } catch (\Throwable $e) {
            // noop, best-effort backfill
        }
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            if (Schema::hasColumn('settings', 'document_defaults_asset_form')) {
                $table->dropColumn('document_defaults_asset_form');
            }
            if (Schema::hasColumn('settings', 'document_defaults_asset_sp')) {
                $table->dropColumn('document_defaults_asset_sp');
            }
        });
    }
};
