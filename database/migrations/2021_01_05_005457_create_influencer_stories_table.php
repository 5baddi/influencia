<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfluencerStoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('influencer_stories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('influencer_id');
            $table->string('uuid')->unique()->nullable(false);
            $table->unsignedBigInteger('story_id')->unique()->nullable();
            $table->enum('type', ['image', 'video'])->default('image');
            $table->text('thumbnail')->nullable();
            $table->text('video')->nullable();
            $table->double('video_duration')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->foreign('influencer_id')->references('id')->on('influencers')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('influencer_stories');
    }
}
