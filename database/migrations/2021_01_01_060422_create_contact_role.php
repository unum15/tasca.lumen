<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactRole extends Migration
{
    public function up()
    {
        Schema::dropIfExists('role_user');
        Schema::create('contact_role', function (Blueprint $table) {
            $table->bigInteger('contact_id');
            $table->bigInteger('role_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('contact_role');
    }
}
