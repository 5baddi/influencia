<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostMedias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('influencer_post_medias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('media_id');
            $table->unsignedBigInteger('influencer_post_id');
            $table->enum('type', ['image', 'video', 'carousel'])->default('image');

            $table->foreign('media_id')->references('id')->on('medias')->cascadeOnDelete();
            $table->foreign('influencer_post_id')->references('id')->on('influencer_posts')->cascadeOnDelete();
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
        Schema::dropIfExists('influencer_post_medias');
    }
}
