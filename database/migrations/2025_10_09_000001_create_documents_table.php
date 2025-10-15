<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Guard against re-creating if a partial/previous run created the table
        if (! Schema::hasTable('documents')) {
            Schema::create('documents', function (Blueprint $table) {
                // Ensure InnoDB so foreign keys can be created on MySQL/MariaDB
                $table->engine = 'InnoDB';
                $table->bigIncrements('id');
            $table->string('type')->index(); // asset|component|license|accessory|other
            // Related tables in core Snipe-IT use standard unsigned integer increments IDs, not bigint
            $table->unsignedInteger('asset_id')->nullable();
            $table->unsignedInteger('component_id')->nullable();
            $table->unsignedInteger('license_id')->nullable();
            $table->unsignedInteger('accessory_id')->nullable();
            $table->unsignedInteger('asset_log_id')->nullable(); // action_logs id referencing checkout
            $table->string('document_number')->unique();
            $table->string('organization_structure')->nullable();
            $table->string('position')->nullable();
            $table->string('location')->nullable();
            $table->date('document_date')->nullable();
            $table->unsignedInteger('requestor_user_id')->nullable();
            $table->string('checkout_user_name')->nullable();
            $table->string('nama_penerima')->nullable();
            $table->string('alasan_penerima')->nullable();
            $table->string('asset_number')->nullable();
            $table->string('gr_number')->nullable();
            $table->boolean('asset_type_notebook')->default(false);
            $table->boolean('asset_type_pc')->default(false);
            $table->string('asset_type_others')->nullable();
            $table->string('device_name')->nullable();
            $table->string('serial_number_device')->nullable();
            $table->string('merk')->nullable();
            $table->string('battery')->nullable();
            $table->string('type_device')->nullable();
            $table->string('serial_number_battery')->nullable();
            $table->string('processor')->nullable();
            $table->string('tas')->nullable();
            $table->string('memory')->nullable();
            $table->string('adaptor')->nullable();
            $table->string('hardisk')->nullable();
            $table->string('serial_number_adaptor')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('foto_device')->nullable();
            $table->string('windows')->nullable();
            $table->string('browser')->nullable();
            $table->string('office')->nullable();
            $table->string('other_application_1')->nullable();
            $table->string('other_application_2')->nullable();
            $table->string('other_application_3')->nullable();
            $table->string('other_application_4')->nullable();
            $table->string('antivirus')->nullable();
            $table->string('compress_tools')->nullable();
            $table->string('reader_tool')->nullable();
            $table->string('dokumen_pengembalian_asset')->nullable();
            $table->string('dokumen_surat_pernyataan')->nullable();
            $table->text('catatan')->nullable();
            $table->string('doc_control_no')->nullable();
            $table->date('created_doc')->nullable();
            $table->date('effective_doc')->nullable();
            $table->string('revision_no')->nullable();
            $table->date('revision_date')->nullable();
            $table->string('author_doc')->nullable();
            $table->string('overall_status')->default('pending'); // pending|signed|rejected
            $table->unsignedInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('asset_id')->references('id')->on('assets')->onDelete('set null');
            $table->foreign('asset_log_id')->references('id')->on('action_logs')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
