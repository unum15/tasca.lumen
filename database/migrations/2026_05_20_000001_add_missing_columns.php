<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingColumns extends Migration
{
    public function up()
    {
        // Add creator_id/updater_id to tables that need them
        $tablesNeedingAuditCols = [
            'asset_accessories',
            'asset_brands',
            'asset_categories',
            'asset_groups',
            'asset_subs',
            'asset_types',
            'partial_text_messages',
            'partial_text_message_types',
            'sms_message_types',
            'stock_text_messages',
        ];
        foreach ($tablesNeedingAuditCols as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->bigInteger('creator_id')->nullable();
                $table->bigInteger('updater_id')->nullable();
            });
        }

        // Add name to asset_appraisals
        Schema::table('asset_appraisals', function (Blueprint $table) {
            $table->string('name')->nullable();
        });

        // Add name to asset_improvements
        Schema::table('asset_improvements', function (Blueprint $table) {
            $table->string('name')->nullable();
        });

        // Add name to asset_pictures
        Schema::table('asset_pictures', function (Blueprint $table) {
            $table->string('name')->nullable();
        });

        // Add name to partial_text_messages
        Schema::table('partial_text_messages', function (Blueprint $table) {
            $table->string('name')->nullable();
        });

        // Add sort_order to task_actions
        Schema::table('task_actions', function (Blueprint $table) {
            $table->integer('sort_order')->nullable();
        });

        // Create task_types table
        Schema::create('task_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('notes')->nullable();
            $table->integer('sort_order')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down()
    {
        Schema::dropIfExists('task_types');

        Schema::table('task_actions', function (Blueprint $table) {
            $table->dropColumn('sort_order');
        });

        Schema::table('partial_text_messages', function (Blueprint $table) {
            $table->dropColumn('name');
        });

        Schema::table('asset_pictures', function (Blueprint $table) {
            $table->dropColumn('name');
        });

        Schema::table('asset_improvements', function (Blueprint $table) {
            $table->dropColumn('name');
        });

        Schema::table('asset_appraisals', function (Blueprint $table) {
            $table->dropColumn('name');
        });

        $tablesNeedingAuditCols = [
            'stock_text_messages',
            'sms_message_types',
            'partial_text_message_types',
            'partial_text_messages',
            'asset_types',
            'asset_subs',
            'asset_groups',
            'asset_categories',
            'asset_brands',
            'asset_accessories',
        ];
        foreach ($tablesNeedingAuditCols as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn(['creator_id', 'updater_id']);
            });
        }
    }
}
