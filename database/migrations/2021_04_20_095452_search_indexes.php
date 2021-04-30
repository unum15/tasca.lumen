<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SearchIndexes extends Migration
{

    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->index('name');
        });
        Schema::table('clients', function (Blueprint $table) {
            $table->index('name');
        });
        Schema::table('phone_numbers', function (Blueprint $table) {
            $table->index('phone_number');
        });
        Schema::table('properties', function (Blueprint $table) {
            $table->index('address1');
        });
        DB::statement('CLUSTER contacts USING contacts_name_index');
        DB::statement('CLUSTER clients USING clients_name_index');
        DB::statement('CLUSTER phone_numbers USING phone_numbers_phone_number_index');
        DB::statement('CLUSTER properties USING properties_address1_index');
    }

    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropIndex('contacts_name_index');
        });
        Schema::table('clients', function (Blueprint $table) {
            $table->dropIndex('clients_name_index');
        });
        Schema::table('phone_numbers', function (Blueprint $table) {
            $table->dropIndex('phone_numbers_phone_number_index');
        });
        Schema::table('properties', function (Blueprint $table) {
            $table->dropIndex('properties_address1_index');
        });
    }
}
