<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDIDSentMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('did_sent_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("from");
            $table->string("to");
            $table->string("text");
            $table->string("delivery_receipt")->nullable();
            $table->string("delivery_receipt_url")->nullable();
            $table->string("status")->nullable();
            $table->string("code")->nullable();
            $table->string("message")->nullable();
            $table->string("refrence")->nullable();
            $table->string("reference_id")->nullable();
            $table->string("sms_status")->nullable();
            $table->string("sms_id")->nullable();
            $table->json("media_urls")->nullable();
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
        Schema::dropIfExists('did_sent_messages');
    }
}
