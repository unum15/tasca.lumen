<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBackflowStylesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backflow_styles', function (Blueprint $table) {
            $table->increments('backflow_style_index');
            $table->string('backflow_style',4);
            $table->timestamps();
        });
        $sql="
            INSERT INTO backflow_styles (backflow_style) VALUES ('RP');
            INSERT INTO backflow_styles (backflow_style) VALUES ('DC');
            INSERT INTO backflow_styles (backflow_style) VALUES ('PVB');
            INSERT INTO backflow_styles (backflow_style) VALUES ('SVB');
            INSERT INTO backflow_styles (backflow_style) VALUES ('DCDA');
            INSERT INTO backflow_styles (backflow_style) VALUES ('RPDA');
            INSERT INTO backflow_styles (backflow_style) VALUES ('AVB');
        ";
        DB::connection()->getPdo()->exec($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('backflow_styles');
    }
}
