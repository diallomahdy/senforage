<?php

class SchemaReflection extends  mysqli
{
    public $totalTables=0;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->connect(CONFIG['db_host'],CONFIG['db_user'],CONFIG['db_pass'],CONFIG['db_name'],CONFIG['db_port']);
        if ($this->connect_errno) {
            printf("Connection failed. Modify MySQL connection settings into <b>mysql_connection.inc.php</b> file.");
            exit();
        }
    }

    /**
     * generateClassesFromSchema()
     * Generates the PHP Classes for managing all tables of the given MySql schema.
     * @param null $path Output for the generated classes
     */
    public function generateClassesFromSchema($path=null){
        $sql = "show full tables where Table_Type != 'VIEW'";
        $result = $this->query($sql);
        $this->totalTables = $result->num_rows;

        while ($row = $result->fetch_row()) {
            $table = $row[0];
            $reflection = new TableReflection($table);
            $source = $reflection->generateClass();
            $class = $reflection->saveClass($source, $path);
            if ($class) {
               $msg = "<br> Class <b>$table.core.php</b> was generated for table <b>$table</b>";
               $msgjs= strip_tags($msg);
               $msgjs= strip_tags($msg);
               $msgjs= strip_tags($msg);
               $msgjs = str_replace("\\","\\\\",$msgjs);
            } else if (!file_exists($path)) {
                $msg = "<br> <b>Destination path error!</b> Unable to create classes. <br> Check if your destination path: <b>$path</b> really exists.";
                $msgjs= strip_tags($msg);
                $msgjs = str_replace("\\","\\\\",$msgjs);  
                return false;
            } else {
                $msg = "<br> <b>Unknow error!</b> Unable to generate classes.";
                $msgjs= strip_tags($msg);
                $msgjs = str_replace("\\","\\\\",$msgjs);
                return false;
            }
            $output = 'Entity class';
            $was = 'was';
            
            // Creating extended classes if not yet
            $extended_class = '';
            $className = ucfirst($table);
            $extended_classe_file = CONFIG['entities_dir'] . $className . '.entity.php';
            if(!file_exists($extended_classe_file)){
                $extended_class = $className . '.entity.php';
                $extended_classe_file = CONFIG['entities_dir'] . $extended_class;
                $extended_classe_content = '<?php';
                $extended_classe_content .= "\n\nrequire_once __DIR__ . '/core/" . $className . ".core.php';";
                $extended_classe_content .= "\n\nclass " . $className . ' extends ' . $className . '_core {';
                $extended_classe_content .= "\n\t";
                $extended_classe_content .= "\n}";
                file_put_contents($extended_classe_file, $extended_classe_content);
                $extended_class = ' and ' . $extended_class;
                $output .= 'es';
                $was = 'were';
            }
            
            echo $output . ' ' . $className . '.core.php ' . $extended_class . ' ' . $was . ' generated for table ' . $table . '<br/>';
            //echo $output . ' ' . $className . '.core.php ' . $extended_class . ' ' . $was . ' generated for table ' . $table . "\n";
            //echo $msgjs . "\n";
            //@flush();
            //@ob_flush();
            
        }
        return true;
    }



}
