<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IndexColumnsV2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tracker_influencers', function (Blueprint $table){
            $table->index('tracker_id');
            $table->index('influencer_id');
        });
        
        Schema::table('tracker_influencer_media', function (Blueprint $table){
            $table->index('tracker_id');
            $table->index('influencer_post_id');
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
