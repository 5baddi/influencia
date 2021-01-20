<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreFieldsAnalytics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Campaign analytics
        Schema::table('campaign_analytics', function (Blueprint $table) {
            $table->integer('videos_count')->default(0)->after('posts_count');
            $table->integer('images_count')->default(0)->after('images_count');
        });
        
        // Tracker analytics
        Schema::table('tracker_analytics', function (Blueprint $table) {
            $table->integer('videos_count')->default(0)->after('posts_count');
            $table->integer('images_count')->default(0)->after('images_count');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaign_analytics', function (Blueprint $table) {
            $table->dropColumn(['videos_count', 'images_count']);
        });
        Schema::table('tracker_analytics', function (Blueprint $table) {
            $table->dropColumn(['videos_count', 'images_count']);
        });
    }
}
