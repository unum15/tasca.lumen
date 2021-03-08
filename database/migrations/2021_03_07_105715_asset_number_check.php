<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AssetNumberCheck extends Migration
{
    public function up()
    {
        $sql = "
    CREATE FUNCTION verify_asset_number() 
    RETURNS TRIGGER 
    LANGUAGE PLPGSQL
    AS $$
    DECLARE
        sub CHARACTER;
        conflict INTEGER;
    BEGIN
        IF (NEW.item_number != '0') THEN
        SELECT number INTO sub FROM asset_subs WHERE id = NEW.asset_sub_id;
            IF (sub != '0') THEN
                SELECT id INTO conflict FROM assets WHERE asset_sub_id = NEW.asset_sub_id AND item_number = NEW.item_number;
                IF (conflict != NULL) THEN
                    RAISE 'Duplicate asset number' USING ERRCODE = 'unique_violation';
                END IF;
            END IF;
        END IF;
        RETURN NEW;
    END;
    $$";
        DB::unprepared($sql);
        
        DB::unprepared("CREATE TRIGGER verify_asset_number_update BEFORE UPDATE ON assets FOR EACH ROW EXECUTE PROCEDURE verify_asset_number();");
        DB::unprepared("CREATE TRIGGER verify_asset_number_insert BEFORE INSERT ON assets FOR EACH ROW EXECUTE PROCEDURE verify_asset_number();");
    }

    public function down()
    {
          DB::unprepared('DROP FUNCTION IF EXISTS verify_asset_number() CASCADE;');
    }
}
