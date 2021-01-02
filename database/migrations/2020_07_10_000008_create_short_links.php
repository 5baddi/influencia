<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShortLinks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Short links
        Schema::create('short_links', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique()->nullable(false);
            $table->unsignedBigInteger('tracker_id');
            $table->string('code');
            $table->string('link');
            $table->string('title')->nullable();
            $table->longText('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->json('tags')->nullable();
            $table->text('top_image_url')->nullable();
            $table->timestamps();

            $table->foreign('tracker_id')->references('id')->on('trackers')->cascadeOnDelete();
        });

        // Link visits
        Schema::create('link_visits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('short_link_id');
            $table->string('ip', 25)->nullable(false);
            $table->string('country_code')->nullable();
            $table->string('country_name')->nullable();
            $table->string('city_name')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('device')->nullable();
            $table->string('os')->nullable();
            $table->string('os_version')->nullable();
            $table->string('browser')->nullable();
            $table->string('browser_version')->nullable();
            $table->string('referer')->nullable();
            $table->boolean('is_mobile')->default(false);
            $table->integer('views')->default(1);
            $table->timestamp('last_visit')->useCurrent();
            $table->timestamps();

            $table->foreign('short_link_id')->references('id')->on('short_links')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('link_visits');
        Schema::dropIfExists('short_links');
    }
}
