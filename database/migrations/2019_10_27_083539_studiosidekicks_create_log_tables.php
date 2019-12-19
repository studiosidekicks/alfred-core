<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StudiosidekicksCreateLogTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('log_operations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('language_id');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('email');
            $table->string('action');
            $table->nullableMorphs('item');

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
        });

        Schema::create('log_errors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('code');
            $table->string('url');
            $table->string('referer')->nullable();
            $table->integer('counter')->default(1);
            $table->timestamps();
        });

        Schema::create('log_signings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->boolean('is_successful')->default(1);
            $table->string('message')->nullable();
            $table->timestamps();

        });

        \Illuminate\Support\Facades\DB::statement('ALTER TABLE `log_signings` ADD `ip` VARBINARY(16)');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_signings');
        Schema::dropIfExists('log_errors');
        Schema::dropIfExists('log_operations');
    }
}
