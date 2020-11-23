<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBackflowPictures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backflow_pictures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('backflow_assembly_id');
            $table->string('filename');
            $table->string('original_filename')->nullable();
            $table->string('notes')->nullable();
            $table->foreign('backflow_assembly_id')
                ->references('id')
                ->on('backflow_assemblies')
                ->onDelete('cascade');
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
        Schema::dropIfExists('backflow_pictures');
    }
}
