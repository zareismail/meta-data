<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetadataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metadata', function (Blueprint $table) {
            $table->id('id');  
            $table->string('name');
            $table->json('options')->default('[]'); 
            $table->json('resource')->default('[]');
            $table->string('help')->nullable(); 
            $table->unsignedInteger('order')->default(time());
            $table->string("icon")->default('home'); 
            $table->string('field')->default("Laravel\\Nova\\Fields\\Boolean");
            $table->timestamps();
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('metadata');
    }
}
