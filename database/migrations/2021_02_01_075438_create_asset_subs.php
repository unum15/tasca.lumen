<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetSubs extends Migration
{

    public function up()
    {
        Schema::create('asset_subs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('asset_group_id');
            $table->string('name');
            $table->char('number',1);
            $table->text('notes')->nullable();
            $table->string('sort_order')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->foreign('asset_group_id')
                ->references('id')->on('asset_groups')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('asset_subs');
    }
}
