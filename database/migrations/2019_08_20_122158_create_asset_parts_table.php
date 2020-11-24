<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetPartsTable extends Migration
{

    public function up()
    {
        Schema::create('asset_parts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('on_hand')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('asset_parts');
    }
}
