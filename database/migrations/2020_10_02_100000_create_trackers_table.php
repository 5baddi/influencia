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
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('campaign_id');
            $table->unsignedBigInteger('influencer_id')->nullable();
            $table->string('uuid')->unique()->nullable(false);
            $table->enum('type', ['url', 'post', 'story'])->default('url');
            $table->string('name')->unique()->nullable(false);
            $table->enum('platform', ['instagram', 'snapchat', null])->nullable();
            $table->string('username')->nullable();
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

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('campaign_id')->references('id')->on('campaigns')->cascadeOnDelete();
            $table->foreign('influencer_id')->references('id')->on('influencers')->onDelete('set null');
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tracker_medias');
        Schema::dropIfExists('trackers');
    }
}
