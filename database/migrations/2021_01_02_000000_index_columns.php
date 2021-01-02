<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IndexColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scrap_accounts', function (Blueprint $table){
            $table->index('platform');
            $table->index('username');
        });

        Schema::table('brands', function (Blueprint $table){
            $table->index('uuid');
            $table->index('name');
        });

        Schema::table('campaigns', function (Blueprint $table){
            $table->index('uuid');
            $table->index('name');
            $table->index('user_id');
            $table->index('brand_id');
            $table->index('status');
        });

        Schema::table('trackers', function (Blueprint $table){
            $table->index('uuid');
            $table->index('user_id');
            $table->index('campaign_id');
            $table->index('type');
            $table->index('platform');
            $table->index('queued');
            $table->index('name');
        });

        Schema::table('influencers', function (Blueprint $table){
            $table->index('uuid');
            $table->index('name');
            $table->index('username');
            $table->index('platform');
            $table->index('account_id');
            $table->index('medias');
        });

        Schema::table('influencer_posts', function (Blueprint $table){
            $table->index('uuid');
            $table->index('influencer_id');
            $table->index('post_id');
            $table->index('short_code');
            $table->index('next_cursor');
            $table->index('type');
            $table->index('is_ad');
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
