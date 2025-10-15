<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('document_signatures')) {
            return; // table already exists, skip creating
        }
        Schema::create('document_signatures', function (Blueprint $table) {
            $table->bigIncrements('id'); // documents.id is bigIncrements
            $table->unsignedBigInteger('document_id');
            $table->string('role'); // creator|it_manager|user|atasan_penerima
            $table->unsignedInteger('user_id')->nullable();
            $table->string('user_name')->nullable();
            $table->string('status')->default('pending'); // pending|signed|rejected
            $table->timestamp('signed_at')->nullable();
            $table->text('note')->nullable();
            $table->string('signature_image')->nullable();
            $table->tinyInteger('ordering')->default(1);
            $table->timestamps();

            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
            $table->unique(['document_id','role']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_signatures');
    }
};
