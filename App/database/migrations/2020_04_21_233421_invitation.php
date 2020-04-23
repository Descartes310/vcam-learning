<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Invitation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invitation', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('senderId')->index();
            $table->unsignedInteger('receiverId')->index();
            $table->boolean('isActive');
            $table->enum('status',['waitting','accepted','denied']);
            $table->date('createdAt');
            $table->date('answeredAt');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invitation');
    }
}
