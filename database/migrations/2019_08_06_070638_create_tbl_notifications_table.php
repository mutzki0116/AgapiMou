<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('tbl_notifications');
        
        Schema::create('tbl_notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('notif_title');
            $table->string('notif_message');
            $table->integer('isRead');
            $table->string('link');
            $table->unsignedBigInteger('notif_source_user_id');
            $table->unsignedBigInteger('notif_destination_user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_notifications');
    }
}
