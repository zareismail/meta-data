<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetadatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metadatas', function (Blueprint $table) {
            $table->id('id');     
            $table->foreignId('metadata_id')->constrained();  
            $table->morphs('has_metadata'); 
            $table->string("value")->nullable(); 
            $table->unsignedInteger("order")->default(0);  

            $table->index(['has_metadata_id', 'metadata_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('metadatas');
    }
}
