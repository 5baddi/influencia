<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Trackers
        Schema::create('trackers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('campaign_id');
            $table->string('uuid')->unique()->nullable(false);
            $table->enum('type', ['url', 'post', 'story'])->default('url');
            $table->string('name')->unique()->nullable(false);
            $table->enum('platform', ['instagram', 'youtube', 'snapchat', null])->nullable();
            $table->longText('url')->nullable();
            $table->boolean('status')->default(true);
            $table->enum('queued', ['pending', 'progress', 'finished', 'failed'])->default('pending');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('campaign_id')->references('id')->on('campaigns')->cascadeOnDelete();
        });

        // Tracker influencers
        Schema::create('tracker_influencers', function (Blueprint $table) {
            $table->unsignedBigInteger('tracker_id');
            $table->unsignedBigInteger('influencer_id');

            $table->foreign('tracker_id')->references('id')->on('trackers')->onDelete('cascade');
            $table->foreign('influencer_id')->references('id')->on('influencers')->onDelete('cascade');

            $table->unique(['tracker_id', 'influencer_id']);
        });

        // Tracker media
        Schema::create('tracker_influencer_media', function (Blueprint $table) {
            $table->unsignedBigInteger('tracker_id');
            $table->unsignedBigInteger('influencer_post_id');

            $table->foreign('tracker_id')->references('id')->on('trackers')->onDelete('cascade');
            $table->foreign('influencer_post_id')->references('id')->on('influencer_posts')->onDelete('cascade');
        });

        // Tracker analytics
        Schema::create('tracker_analytics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tracker_id');
            $table->integer('communities')->default(0);
            $table->integer('organic_posts')->default(0);
            $table->integer('engagements')->default(0);
            $table->integer('organic_engagements')->default(0);
            $table->integer('impressions')->default(0);
            $table->integer('organic_impressions')->default(0);
            $table->integer('video_views')->default(0);
            $table->integer('organic_video_views')->default(0);
            $table->double('engagement_rate')->default(0);
            $table->integer('comments_count')->default(0);
            $table->integer('posts_count')->default(0);
            $table->integer('stories_count')->default(0);
            $table->integer('links_count')->default(0);
             // TODO: separte total emoji and top emoji
            $table->json('top_emojis')->nullable();
            $table->double('sentiments_positive')->default(0);
            $table->double('sentiments_neutral')->default(0);
            $table->double('sentiments_negative')->default(0);
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
        Schema::dropIfExists('tracker_influencer_media');
        Schema::dropIfExists('tracker_influencers');
        Schema::dropIfExists('tracker_medias');
        Schema::dropIfExists('trackers');
    }
}
