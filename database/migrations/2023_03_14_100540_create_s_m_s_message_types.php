<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSMSMessageTypes extends Migration
{
    public function up()
    {
        Schema::create('sms_message_types', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->boolean('uses_date')->default('true');
            $table->integer('sort_order')->nullable();
            $table->timestamps();
        });
        $db = DB::connection();
        $db->insert("INSERT INTO settings (name,value) VALUES ('deault_date_sms_message_type',1)");
        $db->insert("INSERT INTO settings (name,value) VALUES ('deault_nondate_sms_message_type',1)");
    }

    public function down()
    {
        Schema::dropIfExists('sms_message_types');
        $db = DB::connection();
        $db->delete("DELETE FROM settings WHERE name='deault_date_sms_message_type'");
        $db->delete("DELETE FROM settings WHERE name='deault_nondate_sms_message_type'");
    }
}
