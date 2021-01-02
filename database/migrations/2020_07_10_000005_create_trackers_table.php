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
            // $table->enum('platform', ['instagram', 'youtube', 'snapchat', null])->nullable();
            $table->enum('platform', ['instagram', 'youtube', null])->nullable();
            $table->longText('url')->nullable();
            $table->integer('nbr_squences')->nullable();
            $table->integer('nbr_squences_impressions')->nullable();
            $table->integer('nbr_impressions_first_sequence')->nullable();
            $table->integer('nbr_replies')->nullable();
            $table->integer('nbr_taps_forward')->nullable();
            $table->integer('nbr_taps_backward')->nullable();
            $table->integer('reach_first_sequence')->nullable();
            $table->integer('sticker_taps_mentions')->nullable();
            $table->string('sticker_taps_hashtags')->nullable();
            $table->integer('link_clicks')->nullable();
            $table->date('posted_date')->nullable();
            $table->time('posted_hour')->nullable();
            $table->boolean('status')->default(true);
            $table->enum('queued', ['pending', 'progress', 'finished', 'failed'])->default('pending');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('campaign_id')->references('id')->on('campaigns')->cascadeOnDelete();
        });

        // Tracker medias
        Schema::create('tracker_medias', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('tracker_id')->nullable(false);
            $table->string('uuid')->unique()->nullable(false);
            $table->string('name')->unique()->nullable(false);
            $table->string('media_path')->nullable(false);
            $table->enum('type', ['media', 'proof'])->default('media');
            $table->timestamps();

            $table->foreign('tracker_id')->references('id')->on('trackers')->cascadeOnDelete();
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