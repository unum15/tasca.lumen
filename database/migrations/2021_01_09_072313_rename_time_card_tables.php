<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTimeCardTables extends Migration
{

    public function up()
    {
        Schema::rename('task_dates', 'appointments');
        Schema::rename('task_types', 'labor_types');
        Schema::rename('task_action_task_type', 'labor_type_task_action');
        Schema::rename('task_status_task_type', 'labor_type_task_status');
        Schema::rename('overhead_categories', 'labor_activities');
        Schema::rename('overhead_assignments', 'labor_assignments');
        Schema::rename('overhead_assignment_overhead_category', 'labor_activity_labor_assignment');
        Schema::table('labor_type_task_action', function (Blueprint $table) {
            $table->renameColumn('task_type_id','labor_type_id');
        });
        Schema::table('labor_type_task_status', function (Blueprint $table) {
            $table->renameColumn('task_type_id','labor_type_id');
        });
        Schema::table('labor_activity_labor_assignment', function (Blueprint $table) {
            $table->renameColumn('overhead_assignment_id','labor_assignment_id');
            $table->renameColumn('overhead_category_id','labor_activity_id');
        });
        Schema::table('tasks', function (Blueprint $table) {
            $table->integer('labor_assignment_id')->nullable();
            $table->renameColumn('task_type_id','labor_type_id');
            $table->foreign('labor_assignment_id')
                ->references('id')->on('labor_assignments')
                ->onDelete('cascade');
            $table->foreign('labor_type_id')
                ->references('id')->on('labor_types')
                ->onDelete('cascade');
            $table->foreign('task_action_id')
                ->references('id')->on('task_actions')
                ->onDelete('cascade');
            $table->foreign('task_status_id')
                ->references('id')->on('task_statuses')
                ->onDelete('cascade');
        });
        Schema::table('logs.tasks', function (Blueprint $table) {
            $table->integer('labor_assignment_id')->nullable();
            $table->renameColumn('task_type_id','labor_type_id');
        });
        Schema::table('clock_ins', function (Blueprint $table) {
            $table->renameColumn('task_date_id','appointment_id');
            $table->dropColumn('overhead_assignment_id');
            $table->renameColumn('overhead_category_id','labor_activity_id');
            $table->foreign('appointment_id')
                ->references('id')->on('appointments')
                ->onDelete('cascade');
        });
        
        Schema::table('orders', function (Blueprint $table) {
            $table->renameColumn('completion_date','close_date');
            $table->foreign('project_id')
                ->references('id')->on('projects')
                ->onDelete('cascade');
            $table->foreign('order_status_type_id')
                ->references('id')->on('order_status_types')
                ->onDelete('cascade');
            $table->foreign('contact_id')
                ->references('id')->on('contacts')
                ->onDelete('cascade');
            $table->foreign('approver_id')
                ->references('id')->on('contacts')
                ->onDelete('cascade');
            $table->foreign('order_category_id')
                ->references('id')->on('order_categories')
                ->onDelete('cascade');
            $table->foreign('order_priority_id')
                ->references('id')->on('order_priorities')
                ->onDelete('cascade');
            $table->foreign('order_type_id')
                ->references('id')->on('order_types')
                ->onDelete('cascade');
            $table->foreign('order_status_id')
                ->references('id')->on('order_statuses')
                ->onDelete('cascade');
            $table->foreign('order_action_id')
                ->references('id')->on('order_actions')
                ->onDelete('cascade');
        });
        
        Schema::table('labor_assignments', function (Blueprint $table) {
            $table->integer('order_id')->nullable();
            $table->foreign('order_id')
                ->references('id')->on('orders')
                ->onDelete('cascade');
        });
        
        
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
        $sql="
                INSERT INTO labor_types
                (name,sort_order)
                VALUES
                ('Overhead','3');
            ";
        $db->insert($sql);
        $overhead_id = DB::getPdo()->lastInsertId();
        
        $db->query("SELECT id,? INTO labor_type_labor_assignment FROM labor_assignments;",[$overhead_id]);
        
        $sql="
            SELECT
                *
            FROM
                task_categories
                LEFT JOIN task_category_task_type ON (task_categories.id = task_category_task_type.task_category_id)
        ";
        
        $categories = $db->select($sql);
        foreach($categories as $category){
            $sql="
                INSERT INTO labor_assignments
                (name,notes,sort_order)
                VALUES
                (?,?,?);
            ";
            $db->insert($sql,[$category->name,$category->notes,$category->sort_order]);
            $assignment_id = DB::getPdo()->lastInsertId();
            $db->insert('INSERT INTO labor_assignment_labor_type (labor_assignment_id,labor_type_id) VALUES (?,?);',[$assignment_id,$category->task_type_id]);
            $db->update('UPDATE tasks SET labor_assignment_id=?,task_category_id=null WHERE task_category_id=?;',[$assignment_id,$category->id]);
        }
        Schema::dropIfExists('task_category_task_type');
        Schema::dropIfExists('task_categories');
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('task_category_id');
        });
        Schema::table('logs.tasks', function (Blueprint $table) {
            $table->dropColumn('task_category_id');
        });
        Schema::table('appointments', function (Blueprint $table){
            $table->foreign('task_id')
                ->references('id')->on('tasks')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('appointments', function (Blueprint $table){
            $table->dropForeign(['task_id']);
        });
        Schema::table('labor_assignments', function (Blueprint $table) {
            $table->dropColumn('order_id');
        });
        Schema::table('tasks', function (Blueprint $table) {
            $table->integer('task_category_id')->nullable();
        });
        Schema::table('logs.tasks', function (Blueprint $table) {
            $table->integer('task_category_id')->nullable();
        });
        Schema::rename('labor_types', 'task_types' );
        Schema::create('task_categories', function (Blueprint $table) {
            $table->increments('id');            
            $table->string('name');
            $table->text('notes')->nullable();
            $table->integer('sort_order')->nullable();
            $table->integer('task_type')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
        
        Schema::create('task_category_task_type', function (Blueprint $table) {
            $table->integer('task_type_id');
            $table->integer('task_category_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();                        
            $table->unique(['task_type_id', 'task_category_id']);
            $table->foreign('task_type_id')
                ->references('id')->on('task_types')
                ->onDelete('cascade');
            $table->foreign('task_category_id')
                ->references('id')->on('task_categories')
                ->onDelete('cascade');
        });
        
        $db = DB::connection();
        $overhead = $db->select("SELECT id FROM task_types WHERE name='Overhead'");
        $overhead_id = $overhead[0]->id;
        $sql="
            SELECT
                *
            FROM
                labor_assignments a
                LEFT JOIN labor_assignment_labor_type p ON (a.id = p.labor_assignment_id)
            WHERE
                labor_type_id!=?
        ";
        
        $categories = $db->select($sql,[$overhead_id]);
        foreach($categories as $category){
            $sql="
                INSERT INTO task_categories
                (name,notes,sort_order)
                VALUES
                (?,?,?);
            ";
            $db->insert($sql,[$category->name,$category->notes,$category->sort_order]);
            $category_id = DB::getPdo()->lastInsertId();
            $db->insert('INSERT INTO task_category_task_type (task_category_id,task_type_id) VALUES (?,?);',[$category_id,$category->labor_type_id]);
            $db->update('UPDATE tasks SET task_category_id=?,labor_assignment_id=null WHERE labor_assignment_id=?;',[$category_id,$category->id]);
            $db->delete("DELETE FROM labor_assignments WHERE id=?",[$category->id]);
        }
        $db->delete("DELETE FROM task_types WHERE name='Overhead'");
        Schema::table('labor_activity_labor_assignment', function (Blueprint $table) {
            $table->renameColumn('labor_assignment_id','overhead_assignment_id');
            $table->renameColumn('labor_activity_id','overhead_category_id');
        });
        Schema::rename('appointments', 'task_dates', );
        Schema::rename('labor_activities', 'overhead_categories');
        Schema::rename('labor_assignments', 'overhead_assignments');
        Schema::rename('labor_activity_labor_assignment', 'overhead_assignment_overhead_category');
        Schema::table('labor_type_task_action', function (Blueprint $table) {
            $table->renameColumn('labor_type_id','task_type_id');
        });
        Schema::table('labor_type_task_status', function (Blueprint $table) {
            $table->renameColumn('labor_type_id','task_type_id');
        });
        Schema::rename('labor_type_task_action','task_action_task_type');
        Schema::rename('labor_type_task_status','task_status_task_type');
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('labor_assignment_id');
            $table->renameColumn('labor_type_id','task_type_id');
            $table->dropForeign(['labor_type_id']);
            $table->dropForeign(['task_action_id']);
            $table->dropForeign(['task_status_id']);
        });
        
        Schema::table('logs.tasks', function (Blueprint $table) {
            $table->dropColumn('labor_assignment_id');
            $table->renameColumn('labor_type_id','task_type_id');
        });
        
        Schema::table('clock_ins', function (Blueprint $table) {
            $table->renameColumn('appointment_id','task_date_id');
            $table->integer('overhead_assignment_id')->nullable();
            $table->renameColumn('labor_activity_id','overhead_category_id');
            $table->dropForeign(['appointment_id']);
        });
        
        Schema::dropIfExists('labor_assignment_labor_type');    
        
        Schema::table('orders', function (Blueprint $table) {
            $table->renameColumn('close_date','completion_date');
            $table->dropForeign(['project_id']);
            $table->dropForeign(['order_status_type_id']);
            $table->dropForeign(['contact_id']);
            $table->dropForeign(['approver_id']);
            $table->dropForeign(['order_category_id']);
            $table->dropForeign(['order_priority_id']);
            $table->dropForeign(['order_type_id']);
            $table->dropForeign(['order_status_id']);
            $table->dropForeign(['order_action_id']);
        });
    }
}
