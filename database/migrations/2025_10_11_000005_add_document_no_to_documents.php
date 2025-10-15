<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('documents') && !Schema::hasColumn('documents','document_no')) {
            Schema::table('documents', function(Blueprint $table){
                $table->string('document_no')->nullable()->after('document_number');
                $table->index('document_no');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('documents') && Schema::hasColumn('documents','document_no')) {
            Schema::table('documents', function(Blueprint $table){
                $table->dropIndex(['document_no']);
                $table->dropColumn('document_no');
            });
        }
    }
};
