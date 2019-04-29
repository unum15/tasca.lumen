<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\ActivityLevel;
use App\Client;
use App\Contact;
use App\Property;

class ImportPhreeBooksIdsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:phreebooks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate Data from database schema to new schema.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $olddb = DB::connection('pgsql_old');
                
        $contact_sql="
            SELECT
                contact_index,
                accounting_id
            FROM
                contacts.contacts
            ORDER BY
                contact_index
        ";
        
        $contacts = $olddb->select($contact_sql);
        
        
        foreach($contacts as $index => $contact){
            $new_contact = Contact::find($index + 1);
            $new_contact->update(['phreebooks_id' => $contact->accounting_id]);
        }
        
        
        $client_sql="
            SELECT
                client_index,
                client_name,
                accounting_id
            FROM
                clients.clients
            ORDER BY
                client_index
        ";
        
        $clients = $olddb->select($client_sql);
        $total_properties = 0;
        foreach($clients as $index => $client){
            $new_client = Client::find($index + 1);
            $new_client->update(['phreebooks_id' => $client->accounting_id]);
        
        
            $property_sql="
                SELECT
                    property_index,
                    property_name,
                    accounting_id
                FROM
                    properties.properties
                    LEFT JOIN properties.types ON (types.type_index=properties.type_index)
                    LEFT JOIN clients.active_levels ON (properties.active_level_index=active_levels.type_index)
                WHERE
                    client_index='".$client->client_index."'
                ORDER BY
                    property_index
            ";
            
            $properties = $olddb->select($property_sql);
        
            foreach($properties as $pindex => $property){
                $new_property = Property::find(++$total_properties);
                $new_property->update(['phreebooks_id' => $property->accounting_id]);
            }
        }

    }
}
