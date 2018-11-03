<?php

$config['welcome_controller'] = 'Accueil';
$config['entities_dir'] = __DIR__ . '/../entities/';
$config['viwes_dir'] = __DIR__ . '/../views';

// Run mode : local | dev | prod
$config['run_mode'] = 'local';

if($config['run_mode']=='local'){
    
    $config['root_url'] = '/senforage/';
    $config['root_dir'] = $_SERVER['DOCUMENT_ROOT'] . '/senforage/';

    /**
    * Defines the constants for MySQL database connection parameters.
    */
    
    $config['db_access'] = 'pdo';
    $config['db_debug'] = TRUE;
    $config['db_host'] = 'localhost';
    $config['db_name'] = 'senforage';
    $config['db_user'] = 'root';
    $config['db_pass'] = '';
    $config['db_port'] = '3306';

}

elseif($config['run_mode']=='prod'){

}

define('CONFIG', $config);