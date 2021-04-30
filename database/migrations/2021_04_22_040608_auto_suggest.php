<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AutoSuggest extends Migration
{
    public function up()
    {
        $db = DB::connection();
        Schema::table('projects', function (Blueprint $table) {
            $table->index('name');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->index('name');
        });
        Schema::table('tasks', function (Blueprint $table) {
            $table->index('name');
        });
        Schema::table('clients', function (Blueprint $table) {
            $table->index('referred_by');
        });
        $db->insert("INSERT INTO settings (name,value) VALUES ('mininium-auto-suggest-count',2)");
    }

    public function down()
    {
        $db = DB::connection();
        Schema::table('projects', function (Blueprint $table) {
            $table->dropIndex('projects_name_index');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex('orders_name_index');
        });
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropIndex('tasks_name_index');
        });
        Schema::table('clients', function (Blueprint $table) {
            $table->dropIndex('clients_referred_by_index');
        });
        $db->delete("DELETE FROM settings WHERE name='mininium-auto-suggest-count'");
    }
}
