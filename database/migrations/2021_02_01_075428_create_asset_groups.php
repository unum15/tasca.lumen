<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetGroups extends Migration
{

    public function up()
    {
        Schema::create('asset_groups', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('asset_type_id');
            $table->string('name');
            $table->char('number');
            $table->text('notes')->nullable();
            $table->string('sort_order')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->foreign('asset_type_id')
                ->references('id')->on('asset_types')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('asset_groups');
    }
}
