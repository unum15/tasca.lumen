<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBackflowTestStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backflow_assembly_test_statuses', function (Blueprint $table) {
            $table->increments('backflow_assembly_test_status_index');
            $table->string('backflow_assembly_test_status');
            $table->timestamps();            
        });
        
        $sql="
            INSERT INTO backflow_assembly_test_statuses (backflow_assembly_test_status) VALUES ('Closed Tight');
            INSERT INTO backflow_assembly_test_statuses (backflow_assembly_test_status) VALUES ('Leaked');            
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
        Schema::dropIfExists('backflow_assembly_test_statuses');
    }
}
