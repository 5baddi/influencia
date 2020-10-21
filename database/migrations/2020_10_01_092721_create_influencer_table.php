<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfluencerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('influencers', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique()->nullable(false);
            $table->enum('platform', ['instagram', 'snapchat', 'youtube'])->default('instagram');
            $table->string('account_id')->nullable(false);
            $table->string('username')->nullable(false);
            $table->string('name')->nullable();
            $table->text('biography')->nullable();
            $table->string('website')->nullable();
            $table->text('pic_url')->nullable();
            $table->double('engagement_rate')->default(1);
            $table->integer('followers')->nullable();
            $table->integer('follows')->nullable();
            $table->integer('posts')->nullable();
            $table->integer('highlight_reel')->nullable();
            $table->string('business_category')->nullable();
            $table->string('business_email')->nullable();
            $table->string('business_phone')->nullable();
            $table->longText('business_address')->nullable();
            $table->boolean('is_business')->nullable();
            $table->boolean('is_private')->nullable();
            $table->boolean('is_verified')->nullable();
            $table->boolean('banned')->default(false);
            $table->enum('queued', ['pending', 'progress', 'finished', 'failed'])->default('pending');
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
        Schema::dropIfExists('influencers');
    }
}
