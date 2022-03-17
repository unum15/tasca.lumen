<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetAccessories extends Migration
{
    public function up()
    {
        Schema::create('asset_accessories', function (Blueprint $table) {
            $table->id();
            $table->integer('asset_id');
            $table->integer('quantity')->nullable();
            $table->string('name');
            $table->string('notes')->nullable();
            $table->decimal('value')->nullable();
            $table->timestamps();
            $table->foreign('asset_id')
                ->references('id')
                ->on('assets')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('asset_accessories');
    }
}
