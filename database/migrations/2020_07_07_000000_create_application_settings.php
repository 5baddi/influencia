<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Application settings
        Schema::create('application_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique()->nullable(false);
            $table->string('name')->unique()->nullable(false);
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Scrap accounts
        Schema::create('scrap_accounts', function (Blueprint $table) {
            $table->id();
            $table->enum('platform', ['instagram', 'snapchat', 'youtube'])->default('instagram');
            $table->string('username')->nullable(false);
            $table->string('password')->nullable(false);
            $table->string('email')->nullable(false);
            $table->string('imap_server')->nullable(false);
            $table->string('imap_port')->default(465);
            $table->string('imap_email')->nullable(false);
            $table->string('imap_password')->nullable(false);
            $table->boolean('enabled')->default(true);
            $table->timestamps();

            $table->unique(['username', 'email', 'imap_email']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('application_settings');
        Schema::dropIfExists('scrap_accounts');
    }
}
