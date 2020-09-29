<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medias', function(Blueprint $table){
            $table->id();
            $table->string('uuid')->unique()->nullable(false);
            $table->string('name')->unique()->nullable(false);
            $table->string('media_path')->nullable(false);
            $table->enum('type', ['media', 'proof'])->default('media');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medias');
    }
}
