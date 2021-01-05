<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Campaigns
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique()->nullable(false);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('brand_id');
            $table->string('name');
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('brand_id')->references('id')->on('brands')->cascadeOnDelete();
        });

        // Campaign analytics
        Schema::create('campaign_analytics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campaign_id');
            $table->integer('communities')->default(0);
            $table->integer('engagements')->default(0);
            $table->integer('organic_engagements')->default(0);
            $table->integer('impressions')->default(0);
            $table->integer('organic_impressions')->default(0);
            $table->integer('video_views')->default(0);
            $table->integer('organic_video_views')->default(0);
            $table->double('engagement_rate')->default(0);
            $table->integer('comments_count')->default(0);
            $table->integer('posts_count')->default(0);
            $table->integer('organic_posts')->default(0);
            $table->integer('stories_count')->default(0);
            $table->integer('links_count')->default(0);
            // TODO: separte total emoji and top emoji
            $table->json('top_emojis')->nullable();
            $table->double('sentiments_positive')->default(0);
            $table->double('sentiments_neutral')->default(0);
            $table->double('sentiments_negative')->default(0);
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
        Schema::dropIfExists('campaigns');
    }
}
