<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TaskLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs.tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->char('operation', 1);
            $table->integer('task_id');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->integer('order_id')->nullable();
            $table->integer('task_type_id')->nullable();
            $table->integer('task_category_id')->nullable();
            $table->integer('task_status_id')->nullable();
            $table->integer('task_action_id')->nullable();
            $table->integer('task_appointment_status_id')->nullable();
            $table->boolean('hide')->default(false);
            $table->date('completion_date')->nullable();
            $table->string('group')->nullable();
            $table->integer('task_hours')->nullable();
            $table->integer('crew_hours')->nullable();
            $table->text('notes')->nullable();
            $table->string('sort_order')->nullable();
            $table->integer('creator_id');
            $table->integer('updater_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->integer('crew_id')->nullable();
            $table->date('closed_date')->nullable();
            $table->date('billed_date')->nullable();
            $table->date('hold_date')->nullable();
        });
        
        
        $sql ="
            CREATE OR REPLACE FUNCTION logs.log_tasks() RETURNS TRIGGER AS \$body\$
            BEGIN
                
                IF (TG_OP = 'UPDATE') THEN
                    INSERT INTO logs.tasks
                    VALUES (default,'U',NEW.*);
                    RETURN NEW;
                ELSIF (TG_OP = 'DELETE') THEN
                    INSERT INTO logs.tasks  
                    VALUES (default,'D',OLD.*);
                    RETURN OLD;
                ELSIF (TG_OP = 'INSERT') THEN
                    INSERT INTO logs.tasks  
                    VALUES (default,'I',NEW.*);
                    RETURN NEW;
                ELSE
                    RAISE WARNING 'Other action occurred: %, at %',TG_OP,now();
                    RETURN NULL;
                END IF;
             
            END;
            \$body\$
            LANGUAGE plpgsql
            SECURITY DEFINER
            SET search_path = pg_catalog, audit;
        ";
        DB::statement($sql);
        $sql ="
            CREATE TRIGGER update_task_trigger
            AFTER UPDATE
            ON public.tasks
            FOR EACH ROW
            EXECUTE PROCEDURE logs.log_tasks();
          
        ";
        DB::statement($sql);
        $sql ="
          CREATE TRIGGER insert_task_trigger
            AFTER INSERT
            ON public.tasks
            FOR EACH ROW
            EXECUTE PROCEDURE logs.log_tasks();
        ";
        DB::statement($sql);
        $sql ="
          CREATE TRIGGER delete_task_trigger
            AFTER DELETE
            ON public.tasks
            FOR EACH ROW
            EXECUTE PROCEDURE logs.log_tasks();
        ";
        DB::statement($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP TABLE logs.tasks CASCADE');
        DB::statement('DROP function logs.log_tasks() CASCADE');
    }
}
