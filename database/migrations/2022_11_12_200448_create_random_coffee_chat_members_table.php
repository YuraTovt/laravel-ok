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
        Schema::create('random_coffee_chat_members', function (Blueprint $table) {
            $table->id();
            $table->string('ext_id');
            $table->unsignedBigInteger('random_coffee_chat_id');
            $table->string('name');
            $table->timestamps();

            $table->foreign('random_coffee_chat_id')
                ->references('id')
                ->on('random_coffee_chats')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_members');
    }
};
