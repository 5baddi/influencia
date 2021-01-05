<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndexColumnsV3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('influencer_stories', function (Blueprint $table){
            $table->index('uuid');
            $table->index('influencer_id');
            $table->index('tracker_id');
            $table->index('story_id');
        });
        
        Schema::table('story_analytics', function (Blueprint $table){
            $table->index('story_id');
        });
        
        Schema::table('short_links', function (Blueprint $table){
            $table->index('uuid');
            $table->index('tracker_id');
            $table->index('code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
