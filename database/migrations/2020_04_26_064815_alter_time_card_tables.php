<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\SignIn;
use App\ClockIn;

class AlterTimeCardTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sign_ins', function (Blueprint $table) {
            $table->datetimeTZ('sign_in')->change();
            $table->datetimeTZ('sign_out')->change();
            $table->integer('clock_in_id')->default(0);
        });
        Schema::table('clock_ins', function (Blueprint $table) {
            $table->datetimeTZ('clock_in')->change();
            $table->datetimeTZ('clock_out')->change();
        });
        $sign_ins = SignIn::all();
        $sql = "
            SELECT
                sign_in::DATE AS sign_in_date,
                contact_id,
                MIN(sign_in) AS sign_in,
                MAX(sign_out) AS sign_out
            FROM
                sign_ins
            GROUP BY
                sign_in::DATE,
                contact_id
        ";
        $dates = DB::connection()->getPdo()->query($sql);
        foreach($dates as $date){
            $clock_in = ClockIn::create(
              [
                'contact_id' => $date['contact_id'],
                'clock_in' => $date['sign_in'],
                'clock_out' => $date['sign_out'],
                'updater_id' => $date['contact_id'],
                'creator_id' => $date['contact_id'],
              ]
            );
            SignIn::where('sign_in', '>=', $date['sign_in_date'].' 00:00:00')
            ->where('sign_in', '<=', $date['sign_in_date'].' 23:59:59.9999')
            ->where('contact_id', '<=', $date['contact_id'])
            ->update(['clock_in_id' => $clock_in->id]);
        }
        Schema::table('sign_ins', function (Blueprint $table) {
            $table->dropColumn('contact_id');
            $table->foreign('clock_in_id')
                ->references('id')
                ->on('clock_ins')
                ->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sign_ins', function (Blueprint $table) {
            $table->integer('contact_id')->default(0);
        });
        $sql="
            UPDATE
                sign_ins
            SET
                contact_id = clock_ins.contact_id
            FROM
                clock_ins
            WHERE
                sign_ins.clock_in_id = clock_ins.id
        ";
        DB::connection()->getPdo()->exec($sql);
        Schema::table('sign_ins', function (Blueprint $table) {
            $table->datetime('sign_in')->change();
            $table->datetime('sign_out')->change();
            $table->dropColumn('clock_in_id');
        });
        DB::table('clock_ins')->delete();
        Schema::table('clock_ins', function (Blueprint $table) {
            $table->datetime('clock_in')->change();
            $table->datetime('clock_out')->change();
        });
        
    }
    
}
