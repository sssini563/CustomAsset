<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            if (!Schema::hasColumn('documents', 'requestor')) {
                $table->string('requestor')->nullable()->after('location');
            }
        });
        // Backfill from existing checkout_user_name if present
        try {
            DB::table('documents')->whereNull('requestor')->whereNotNull('checkout_user_name')->update([
                'requestor' => DB::raw('checkout_user_name')
            ]);
        } catch (\Throwable $e) {
            // ignore if table not ready or permission issues
        }
    }

    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            if (Schema::hasColumn('documents', 'requestor')) {
                $table->dropColumn('requestor');
            }
        });
    }
};
