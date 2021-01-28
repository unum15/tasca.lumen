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
        $db->update("UPDATE labor_types SET assigned=true WHERE name='Office';");
        Schema::table('labor_assignments', function (Blueprint $table) {
            $table->integer('labor_type_id')->nullable();
            $table->foreign('labor_type_id')
                ->references('id')->on('labor_types')
                ->onDelete('cascade');
        });
        $db->update("UPDATE labor_assignments SET labor_type_id = lalt.labor_type_id FROM (SELECT labor_assignment_id,labor_type_id FROM labor_assignment_labor_type) AS lalt WHERE lalt.labor_assignment_id=id;");
        Schema::dropIfExists('labor_assignment_labor_type');
        Schema::table('labor_assignments', function (Blueprint $table) {
            $table->integer('labor_type_id')->nullable(false)->change();
        });
    }

    public function down()
    {
        Schema::create('labor_assignment_labor_type', function (Blueprint $table) {
            $table->integer('labor_assignment_id');
            $table->integer('labor_type_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();                        
            $table->unique(['labor_type_id', 'labor_assignment_id']);
            $table->foreign('labor_type_id')
                ->references('id')->on('labor_types')
                ->onDelete('cascade');
            $table->foreign('labor_assignment_id')
                ->references('id')->on('labor_assignments')
                ->onDelete('cascade');
        });
        $db = DB::connection();
        $db->insert("INSERT INTO labor_assignment_labor_type SELECT id,labor_type_id FROM labor_assignments;");
        Schema::table('labor_assignments', function (Blueprint $table) {
            $table->dropColumn('labor_type_id')->nullable();
        });
        Schema::table('labor_types', function (Blueprint $table) {
            $table->dropColumn('assigned');
        });
    }
}
