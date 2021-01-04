<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfluencersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Influencers
        Schema::create('influencers', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique()->nullable(false);
            $table->enum('platform', ['instagram', 'snapchat', 'youtube'])->default('instagram');
            $table->string('account_id')->nullable(false);
            $table->string('username')->nullable(false);
            $table->string('name')->nullable();
            $table->longText('biography')->nullable();
            $table->string('website')->nullable();
            $table->text('pic_url')->nullable();
            $table->float('engagement_rate')->nullable();
            $table->integer('followers')->nullable();
            $table->integer('follows')->nullable();
            $table->integer('medias')->nullable();
            $table->integer('highlight_reel')->nullable();
            $table->string('business_category')->nullable();
            $table->string('business_email')->nullable();
            $table->string('business_phone')->nullable();
            $table->json('business_address')->nullable();
            $table->boolean('is_business')->nullable();
            $table->boolean('is_private')->nullable();
            $table->boolean('is_verified')->nullable();
            $table->boolean('banned')->default(false);
            $table->integer('video_views')->nullable();
            $table->string('country_code')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->boolean('in_process')->default(false);
            $table->timestamps();
        });

        // Influencer posts
        Schema::create('influencer_posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('influencer_id');
            $table->string('uuid')->unique()->nullable(false);
            $table->unsignedBigInteger('post_id')->nullable();
            $table->string('next_cursor')->nullable()->default(null);
            $table->string('short_code')->nullable();
            $table->string('link')->unique()->nullable();
            $table->text('thumbnail_url')->nullable();
            $table->enum('type', ['image', 'video', 'sidecar', 'carousel'])->default('image');
            $table->text('caption')->nullable();
            $table->json('caption_hashtags')->nullable();
            $table->integer('likes')->nullable();
            $table->integer('comments')->nullable();
            $table->float('engagement_rate')->default(1);
            $table->integer('emojis')->nullable();
            $table->double('comments_positive')->nullable();
            $table->double('comments_neutral')->nullable();
            $table->double('comments_negative')->nullable();
            $table->json('comments_emojis')->nullable();
            $table->json('comments_hashtags')->nullable();
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
            $table->longText('description')->nullable();
            $table->integer('dislikes')->nullable();
            $table->integer('favorites')->nullable();
            $table->integer('category_id')->nullable();
            $table->string('category')->nullable();
            $table->string('language')->nullable();
            $table->string('audio_language')->nullable();
            $table->json('tags')->nullable();
            $table->boolean('is_livebroadcast')->nullable();
            $table->timestamps();

            $table->foreign('influencer_id')->references('id')->on('influencers')->cascadeOnDelete();

            $table->unique(['post_id', 'short_code']);
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
        Schema::dropIfExists('influencers');
    }
}
