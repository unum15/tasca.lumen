<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetBrands extends Migration
{

    public function up()
    {
        Schema::create('asset_brands', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('asset_category_id');
            $table->string('name');
            $table->char('number',1);
            $table->text('notes')->nullable();
            $table->string('sort_order')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->foreign('asset_category_id')
                ->references('id')->on('asset_categories')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('asset_brands');
    }
}
