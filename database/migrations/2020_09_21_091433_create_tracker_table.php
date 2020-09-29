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
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('campaign_id');
            $table->string('uuid')->unique()->nullable(false);
            $table->enum('type', ['url', 'post', 'story'])->default('url');
            $table->string('name')->unique()->nullable(false);
            $table->enum('platform', ['instagram', 'snapchat', null])->nullable();
            $table->string('username')->nullable();
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
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('campaign_id')->references('id')->on('campaigns');
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
        Schema::dropIfExists('medias');
    }
}
