<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsAnalyticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_analytics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campaign_id');
            $table->bigInteger('communities')->nullable();
            $table->bigInteger('engagements')->nullable();
            $table->bigInteger('impressions')->nullable();
            $table->bigInteger('video_views')->nullable();
            $table->double('engagement_rate')->nullable();
            $table->integer('comments_count')->nullable();
            $table->integer('posts_count')->default(0);
            $table->integer('stories_count')->default(0);
            $table->integer('links_count')->default(0);
            $table->json('top_emojis')->nullable();
            $table->double('sentiments_positive')->nullable();
            $table->double('sentiments_neutral')->nullable();
            $table->double('sentiments_negative')->nullable();
            $table->timestamps();

            $table->foreign('campaign_id')->references('id')->on('campaigns')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaign_analytics');
    }
}
