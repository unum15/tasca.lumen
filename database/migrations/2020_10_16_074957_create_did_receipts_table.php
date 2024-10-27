<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDIDReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('did_receipts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('text');
            $table->string('from');
            $table->string('to');
            $table->string('reference_id');
            $table->string('status');
            $table->json('media_urls');
            $table->datetime('sms_created_at');
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
        Schema::dropIfExists('did_receipts');
    }
}
