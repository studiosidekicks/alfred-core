<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StudiosidekicksCreateFileManagerTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('directories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('parent_id')->nullable();
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('directories')->onDelete('set null');
        });

        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('directory_id')->nullable();
            $table->string('filename');
            $table->string('original_filename');
            $table->string('alternate_text')->nullable();
            $table->enum('type', ['image', 'video', 'pdf', 'document', 'other'])->default('image');
            $table->timestamps();

            $table->foreign('directory_id')->references('id')->on('directories')->onDelete('set null');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_using_gravatar')->default(0);
            $table->string('gravatar_email')->nullable();
            $table->unsignedInteger('avatar_id')->nullable();

            $table->foreign('avatar_id')->references('id')->on('files')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['avatar_id']);
            $table->dropColumn(['is_using_gravatar', 'gravatar_email', 'avatar_id']);
        });

        Schema::dropIfExists('files');
        Schema::dropIfExists('directories');
    }
}
