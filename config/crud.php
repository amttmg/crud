<?php

return [
    //Template
    'view_template'        => 'admin.layouts.master',


    //Path
    'view_path'            =>  'admin/', //Example 'Entity/'
    'model_path'           => 'app/Entities/', //Example 'app/Entity/'
    'controller_path'      => 'app/Http/Controllers/Admin/', //Example 'Entity/'
    'service_path'         => 'app/Services/',
    'request_path'         => 'app/Http/Requests/',
    'migration_path'       => 'database/migrations/',


    //Namespaces
    'model_namespace'      => 'App\Entities', //Example 'app/Entity/'
    'controller_namespace' => 'App\Http\Controllers\Admin', //Example 'Entity/'
    'service_namespace'    => 'App\Services',
    'request_namespace'    => 'App\Http\Requests',


    'use_default_template' => false,
];
