<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Brands
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique()->nullable(false);
            $table->string('name');
            $table->string('logo')->nullable();

            $table->timestamps();
        });

        // Brand users
        Schema::create('brand_users', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('brand_id');

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('brand_id')->references('id')->on('brands')->cascadeOnDelete();
        });

        // Brand influencers
        Schema::create('brand_influencers', function (Blueprint $table) {
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('influencer_id');

            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->foreign('influencer_id')->references('id')->on('influencers')->onDelete('cascade');

            $table->primary(['brand_id', 'influencer_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brand_influencers');
        Schema::dropIfExists('brand_users');
        Schema::dropIfExists('brands');
    }
}
