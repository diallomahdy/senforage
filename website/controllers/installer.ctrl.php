<?php

class Installer extends Controller {

    public function __construct() {
        parent::__construct();
        // Charger l'entité compteur => inclure le fichier /entities/compteur.entity.php 
        $this->loadView('index');
    }

    public function index() {
        $this->loadView('home', 'content');
    }

    public function generate_entities() {
        $this->loadView('generate_entities', 'content');
        // Generating entities
        if (isset($this->post->generate_entities)) {
            require_once CONFIG['root_dir'] . 'config/orm.conf.php';
            if (!file_exists(CONFIG['entities_dir'])) {
                mkdir(CONFIG['entities_dir']);
            }
            if (!file_exists(CONFIG['entities_dir'] . '/core')) {
                mkdir(CONFIG['entities_dir'] . '/core');
            }
            // Create reflection object and invoke classes generation from the specified schema into mysql_connection.inc.php
            $reflection = new SchemaReflection();
            // Generates the classes into the given path. During the generation it outputs the results.
            ob_start(); // Start output buffer
            $reflection->generateClassesFromSchema(CONFIG['entities_dir']);
            $output = ob_get_contents(); // Grab output
            ob_end_clean(); // Grab output and Discard output buffer
            if (isset($reflection->totalTables)) {
                $nbEntities = $reflection->totalTables;
            } else {
                $nbEntities = 0;
            }
            //echo json_encode(array('nbEntities'=>$nbEntities, 'verbose'=>$output));
            if ($nbEntities == 0){
                $this->handleStatus('No class found.', 'danger');
            }
            else if ($nbEntities > 0) {
                if($nbEntities > 1){
                    $plural = 'es';
                }
                else{
                    $plural = '';
                }
                $this->handleStatus('Building success : ' . $nbEntities . ' class' . $plural . ' builded.');
                $this->loadHtml($output, 'statusVerbose');
            }
        }
    }

}
