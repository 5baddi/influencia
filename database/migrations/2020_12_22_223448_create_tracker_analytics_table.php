<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackersAnalyticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracker_analytics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tracker_id')->unique();
            $table->bigInteger('communities')->nullable();
            $table->bigInteger('organic_communities')->nullable();
            $table->bigInteger('engagements')->nullable();
            $table->bigInteger('organic_engagements')->nullable();
            $table->bigInteger('video_views')->nullable();
            $table->bigInteger('organic_video_views')->nullable();
            $table->bigInteger('impressions')->nullable();
            $table->bigInteger('organic_impressions')->nullable();
            $table->integer('comments')->nullable();
            $table->json('top_emojis')->nullable();
            $table->double('sentiments_positive')->nullable();
            $table->double('sentiments_neutral')->nullable();
            $table->double('sentiments_negative')->nullable();
            $table->integer('posts')->nullable();
            $table->integer('organic_posts')->nullable();
            $table->timestamps();

            $table->foreign('tracker_id')->references('id')->on('trackers')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tracker_analytics');
    }
}
