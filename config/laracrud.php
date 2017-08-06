<?php
return [
    /**
     * Default Model Namespace
     */
    'modelNameSpace' => 'App\Models',
    /**
     * Default Model Folder
     */
    'modelpath' => 'app/Models',
    /**
     * Request Class suffex. E.g. UserRequest
     */
    'requestClassSuffix' => 'Request',
    /**
     * Controller Classes Folder
     */
    'controllerNameSpace' => 'App\Http\Controllers',
    /**
     * Controller Classes Folder
     */
    'controllerPath' => 'app/Http/Controllers/',
    /**
     * Request Classes Folder
     */
    'requestNameSpace' => 'App\Http\Requests',
    /**
     * Request Classes Folder
     */
    'requestPath' => 'app/Http/Requests/',
    /**
     * Path to route file
     */
    'routeFile' => 'routes/web.php',
    /**
     * Path to route file
     */
    'viewPath' => 'resources/views/',
    /**
     * Path to Migration
     */
    'migrationPath' => 'database/migrations/',
    /**
     * Path to store chart pages
     */
    'chartPath' => 'resources/views/charts',
    /**
     * Chart Library
     */
    'chartLibrary' => 'chartjs',
    /**
     * Default Layout
     */
    'layout' => 'app',
    /**
     * Pivot tables
     */
    'pivotTables' => [],
    /**
     * Get Date Format. Model Date/ Time related column will display date to user in this format
     */
    'getDateFormat' => [
        'time' => 'h:i A',
        'date' => 'm/d/Y',
        'datetime' => 'm/d/Y h:i A',
        'timestamp' => 'm/d/Y h:i A'
    ],
    /**
     * Date will be convert in this format before save.
     */
    'setDateFormat' => [
        'time' => 'H:i:s',
        'date' => 'Y-m-d',
        'datetime' => 'Y-m-d H:i:s',
        'timestamp' => 'Y-m-d H:i:s'
    ],
    /**
     * System Columns
     */
    'systemColumns' => ['created_at', 'updated_at', 'deleted_at'],
    /**
     * Not Fillable Columns
     */
    'protectedColumns' => ['id', 'created_at', 'updated_at', 'deleted_at'],
];
