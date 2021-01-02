<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScrapAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
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
        Schema::dropIfExists('scrap_accounts');
    }
}
