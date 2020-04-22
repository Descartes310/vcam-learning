<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_group', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('userId')->index();
            $table->unsignedInteger('groupeId')->index();
            $table->boolean('isActive');
            $table->boolean('isAdmin');
            $table->boolean('isCreator');
            $table->date('createdAt');
            $table->date('deletedAt');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_group');
    }
}
