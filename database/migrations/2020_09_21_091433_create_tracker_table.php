<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trackers', function (Blueprint $table) {
            $table->id();
            $table->foreign('user_id', 'users');
            $table->foreign('campaign_id', 'campaigns');
            $table->string('uuid')->unique()->nullable(false);
            $table->enum('platform', ['instagram', 'snapchat'])->default('instagram');
            $table->enum('type', ['url', 'post', 'story'])->default('url');
            $table->string('username')->nullable(false);
            $table->string('name')->unique()->nullable(false);
            $table->string('url')->nullable();
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
            $table->timestamps();
        });

        Schema::create('tracker_medias', function(Blueprint $table){
            $table->id();
            $table->foreign('tracker_id', 'trackers');
            $table->string('uuid')->unique()->nullable(false);
            $table->string('name')->unique()->nullable(false);
            $table->string('media_path')->nullable(false);
            $table->enum('type', ['media', 'proof'])->default('media');
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
        Schema::dropIfExists('trackers');
        Schema::dropIfExists('tracker_medias');
    }
}
