<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetImprovements extends Migration
{
    public function up()
    {
        Schema::create('asset_improvements', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('asset_id');
            $table->string('description');
            $table->string('details')->nullable();
            $table->string('date')->nullable();
            $table->decimal('cost')->nullable();
            $table->timestamps();

            $table->foreign('asset_id')
                ->references('id')
                ->on('assets')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('asset_improvements');
    }
}
