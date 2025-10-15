<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            // License
            $table->string('license_key')->nullable();
            $table->integer('license_seats')->nullable();
            $table->string('license_vendor')->nullable();
            $table->date('license_expires_at')->nullable();

            // Accessory
            $table->string('accessory_part_number')->nullable();
            $table->string('accessory_serial_number')->nullable();
            $table->string('accessory_condition')->nullable();
            $table->text('accessory_notes')->nullable();

            // Component
            $table->string('component_model')->nullable();
            $table->string('component_part_number')->nullable();
            $table->string('component_serial_number')->nullable();
            $table->text('component_spec')->nullable();

            // Consumable
            $table->string('consumable_batch')->nullable();
            $table->integer('consumable_qty')->nullable();
            $table->string('consumable_unit')->nullable();
            $table->text('consumable_notes')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn([
                'license_key','license_seats','license_vendor','license_expires_at',
                'accessory_part_number','accessory_serial_number','accessory_condition','accessory_notes',
                'component_model','component_part_number','component_serial_number','component_spec',
                'consumable_batch','consumable_qty','consumable_unit','consumable_notes'
            ]);
        });
    }
};
