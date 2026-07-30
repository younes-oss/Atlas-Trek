<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->text('logement_desc')->nullable();
            $table->string('logement_img')->nullable();
            
            $table->text('transport_desc')->nullable();
            $table->string('transport_img')->nullable();
            
            $table->text('repas_desc')->nullable();
            $table->string('repas_img')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->dropColumn([
                'logement_desc', 'logement_img',
                'transport_desc', 'transport_img',
                'repas_desc', 'repas_img'
            ]);
        });
    }
};
