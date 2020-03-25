<?php
return [
    'default' => env('DB_CONNECTION', 'pgsql'),
    'connections' => [

        'pgsql' => [
            'driver' => 'pgsql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],
		
		'pgsql_old' => [
            'driver' => 'pgsql',
            'host' => env('OLDDB_HOST', '127.0.0.1'),
            'port' => env('OLDDB_PORT', '5432'),
            'database' => env('OLDDB_DATABASE', 'forge'),
            'username' => env('OLDDB_USERNAME', 'forge'),
            'password' => env('OLDDB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],
        
        'phreebooks' => [
            'driver' => 'mysql',
            'host' => env('PHREEBOOKS_HOST', '127.0.0.1'),
            'port' => env('PHREEBOOKS_PORT', '3306'),
            'database' => env('PHREEBOOKS_DATABASE', 'phreebooks'),
            'username' => env('PHREEBOOKS_USERNAME', 'phreebooks'),
            'password' => env('PHREEBOOKS_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],
    ],
    'migrations' => 'migrations'
];