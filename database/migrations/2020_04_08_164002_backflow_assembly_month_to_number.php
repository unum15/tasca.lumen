<?php
use App\BackflowAssembly;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BackflowAssemblyMonthToNumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('backflow_assemblies', function (Blueprint $table) {
            $table->integer('month_integer')->nullable();
        });
          //DB::connection()->getPdo()->exec($sql);
        $assemblies = BackflowAssembly::all();
        foreach($assemblies as $assembly){
            $month = $assembly->month;
            $month = preg_replace('/\D/', '', $month);
            if(empty($month)){
                $month = null;
            }
            $assembly->month_integer = $month;
            $assembly->save();
        }
        Schema::table('backflow_assemblies', function (Blueprint $table) {
            $table->dropColumn(['month']);
            $table->renameColumn('month_integer', 'month');   
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('backflow_assemblies', function (Blueprint $table) {
            $table->string('month', 16)->nullable()->change();
        });
    }
}
