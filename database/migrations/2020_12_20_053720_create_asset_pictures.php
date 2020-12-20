<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetPictures extends Migration
{

    public function up()
    {
        Schema::create('asset_pictures', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('asset_id');
            $table->string('filename');
            $table->string('original_filename')->nullable();
            $table->string('notes')->nullable();
            $table->timestamps();
            $table->foreign('asset_id')
                ->references('id')
                ->on('assets')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('asset_pictures');
    }
}
