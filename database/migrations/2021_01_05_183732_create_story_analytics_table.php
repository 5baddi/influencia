<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoryAnalyticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Story analytics
        Schema::create('story_analytics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('story_id');
            $table->integer('reach')->default(0)->comment('Accounts reached with this story');
            $table->integer('impressions')->default(0);
            $table->integer('interactions')->default(0)->comment('Actions taken from this story');
            $table->integer('navigation')->default(0);
            $table->integer('follows')->default(0);
            $table->integer('siwpe_ups')->default(0);
            $table->integer('link_clicks')->default(0);
            $table->integer('profile_visits')->default(0);
            $table->integer('replies')->default(0);
            $table->integer('shares')->default(0);
            $table->integer('back')->default(0);
            $table->integer('forward')->default(0);
            $table->integer('next_story')->default(0);
            $table->integer('exited')->default(0);
            $table->integer('sticker_taps')->default(0);
            $table->json('sticker_taps_details')->default(null);
            $table->timestamps();

            $table->foreign('story_id')->references('id')->on('influencer_stories')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('story_analytics');
    }
}
