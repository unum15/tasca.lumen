<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AssignedLaborTypes extends Migration
{
    public function up()
    {
        $db = DB::connection();
        Schema::table('labor_types', function (Blueprint $table) {
            $table->boolean('assigned')->default('false');
        });
        $db->update("UPDATE labor_types SET assigned=true WHERE name='Overhead';");
        Schema::table('labor_assignment_labor_type', function (Blueprint $table) {
            $table->integer('order_id')->nullable();
        });
        $db->update("UPDATE labor_assignment_labor_type SET order_id = la.order_id FROM (SELECT id,order_id FROM labor_assignments) AS la WHERE labor_assignment_id=la.id;");
        Schema::table('labor_assignments', function (Blueprint $table) {
            $table->dropColumn('order_id');
        });
    }

    public function down()
    {
        Schema::table('labor_assignments', function (Blueprint $table) {
            $table->integer('order_id')->nullable();
        });
        $db = DB::connection();
        $db->update("UPDATE labor_assignments SET order_id = lalt.order_id FROM (SELECT labor_assignment_id,order_id FROM labor_assignment_labor_type) AS lalt WHERE id=lalt.labor_assignment_id;");
        Schema::table('labor_types', function (Blueprint $table) {
            $table->dropColumn('assigned');
        });
        Schema::table('labor_assignment_labor_type', function (Blueprint $table) {
            $table->dropColumn('order_id');
        });
    }
}
