<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddYoutubeToInfluencers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('influencers', function(Blueprint $table){
            $table->integer('video_views')->nullable();
            $table->string('country_code')->nullable();
            $table->timestamp('published_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('influencers', function(Blueprint $table){
            $table->dropColumn('video_views');
            $table->dropColumn('country_code');
            $table->dropColumn('published_at');
        });
    }
}
