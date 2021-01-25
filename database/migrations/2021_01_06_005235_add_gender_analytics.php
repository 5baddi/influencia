<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGenderAnalytics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Influencer posts
        Schema::table('influencer_posts', function (Blueprint $table) {
            $table->integer('male')->default(0)->after('emojis');
            $table->integer('female')->default(0)->after('male');
        });
        
        // Tracker analytics
        Schema::table('tracker_analytics', function (Blueprint $table) {
            $table->integer('male')->default(0)->after('links_count');
            $table->integer('female')->default(0)->after('male');
        });
        
        // Campaign analytics
        Schema::table('campaign_analytics', function (Blueprint $table) {
            $table->integer('male')->default(0)->after('links_count');
            $table->integer('female')->default(0)->after('male');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('influencer_posts', function (Blueprint $table) {
            $table->dropColumn(['male', 'female']);
        });

        Schema::table('tracker_analytics', function (Blueprint $table) {
            $table->dropColumn(['male', 'female']);
        });
        
        Schema::table('campaign_analytics', function (Blueprint $table) {
            $table->dropColumn(['male', 'female']);
        });
    }
}
