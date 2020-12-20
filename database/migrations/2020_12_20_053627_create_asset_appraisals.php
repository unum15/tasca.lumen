<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetAppraisals extends Migration
{
    public function up()
    {
        Schema::create('asset_appraisals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('asset_id');
            $table->string('date');
            $table->decimal('appraisal');
            $table->timestamps();
        
            $table->foreign('asset_id')
                ->references('id')
                ->on('assets')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('asset_appraisals');
    }
}
