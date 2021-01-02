<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddYoutubeToInfluencerPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('influencer_posts', function(Blueprint $table){
            $table->longText('description')->nullable();
            $table->integer('dislikes')->nullable();
            $table->integer('favorites')->nullable();
            $table->integer('category_id')->nullable();
            $table->string('category')->nullable();
            $table->string('language')->nullable();
            $table->string('audio_language')->nullable();
            $table->json('tags')->nullable();
            $table->boolean('is_livebroadcast')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('influencer_posts', function(Blueprint $table){
            $table->dropColumn('description');
            $table->dropColumn('dislikes');
            $table->dropColumn('favorites');
            $table->dropColumn('category_id');
            $table->dropColumn('category');
            $table->dropColumn('language');
            $table->dropColumn('audio_language');
            $table->dropColumn('tags');
            $table->dropColumn('is_livebroadcast');
        });
    }
}
