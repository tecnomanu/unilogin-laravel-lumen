<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Para la tabla de enlaces mágicos
        Schema::create('unilogin_magic_links', function (Blueprint $table) {
            $table->string('token')->unique();
            $table->string('email');
            $table->timestamp('expires_at');
            $table->boolean('used')->default(false);
            $table->timestamps();
        });

        // Para la tabla de registro de eventos
        Schema::create('unilogin_sessions', function (Blueprint $table) {
            $table->string('ip_address')->nullable();
            $table->string('status');
            $table->timestamp('used_at');
        });

        // Para la tabla de registro de eventos
        Schema::create('unilogin_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('magic_link_id')->constrained('unilogin_magic_links');
            $table->string('ip_address')->nullable();
            $table->timestamp('used_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unilogin_magic_links');
        Schema::dropIfExists('unilogin_events');
    }
};
