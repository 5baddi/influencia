<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackerInfluencerMedia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracker_influencer_media', function (Blueprint $table) {
            $table->unsignedBigInteger('tracker_id');
            $table->unsignedBigInteger('influencer_post_id');

            $table->foreign('tracker_id')->references('id')->on('trackers')->onDelete('cascade');
            $table->foreign('influencer_post_id')->references('id')->on('influencer_posts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tracker_influencer_media');
    }
}
