<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfluencerPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('influencer_posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('influencer_id');
            $table->string('uuid')->unique()->nullable(false);
            $table->unsignedBigInteger('post_id')->nullable(false);
            $table->unsignedBigInteger('tracker_id')->nullable();
            $table->string('link')->nullable(false);
            $table->string('short_code')->nullable();
            $table->text('thumbnail_url')->nullable();
            $table->enum('type', ['image', 'video', 'sidecar', 'carousel'])->default('image');
            $table->text('caption')->nullable();
            $table->text('alttext')->nullable();
            $table->integer('likes')->nullable();
            $table->integer('comments')->nullable();
            $table->integer('hashtags')->nullable();
            $table->integer('emojis')->nullable();
            $table->integer('sequences')->default(0);
            $table->double('comments_positive')->nullable();
            $table->double('comments_neutral')->nullable();
            $table->double('comments_negative')->nullable();
            $table->json('comments_emojis')->nullable();
            $table->json('caption_hashtags')->nullable();
            $table->integer('video_views')->nullable();
            $table->double('video_duration')->nullable();
            $table->string('location_id')->nullable();
            $table->string('location')->nullable();
            $table->string('location_slug')->nullable();
            $table->json('location_json')->nullable();
            $table->timestamp('published_at')->nullable(false);
            $table->boolean('comments_disabled')->default(false);
            $table->boolean('caption_edited')->default(false);
            $table->boolean('is_ad')->default(false);
            $table->timestamps();

            $table->foreign('influencer_id')->references('id')->on('influencers')->cascadeOnDelete();
            $table->foreign('tracker_id')->references('id')->on('trackers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('influencer_posts');
    }
}
