<?php

// https://github.com/lincanbin/PHP-PDO-MySQL-Class

class EntityManager{
    
    private $dao;
    private $db;
    public $lastInsertId;
    public $rowCount;
    private $sql;
    public $entityName;
    private $arrValues = null;
    
    public function __construct() {
        //$this->dao = new Dao();
        //require_once __DIR__ . '/PDO.class.php';
        require_once(dirname(__FILE__)."/PDO.class.php");
        $this->db = new Db(CONFIG['db_host'], CONFIG['db_name'], CONFIG['db_user'], CONFIG['db_pass']);
    }
    
    private function getSelectedEntities($fetched, $entityName) {
        $arr_entity = array();
        foreach ($fetched as $entity_key => $entity_value) {
            $entity = new $entityName($entity_value);
            /*if(method_exists($entity, 'getId')){
                $arr_entity[$entity->getId()] = $entity;
            }
            else*/{
                $arr_entity[] = $entity;
            }
        }
        return $arr_entity;
    }
    
    public function getRefined($mixed) {
        $arr = array();
        if(is_object($mixed)){
            if(method_exists($mixed, 'getRefined')){
                return $mixed->getRefined();
            }
        }
        elseif(is_array($mixed)){
            foreach ($mixed as $key => $entity) {
                if(method_exists($entity, 'getId')){
                    $arr[$entity->getId()] = $this->getRefined($entity);
                }
                else{
                    $arr[$key] = $this->getRefined($entity);
                }
            }
            return $arr;
        }
        return false;
    }
    
    private function queryAppend(int $limit=0, bool $desc=true) {
        if($desc){
            $order = 'DESC';
        } else{
            $order = 'ASC';
        }
        if(!$limit){
            $limit_filter = '';
        } else{
            $limit_filter = ' LIMIT ' . $limit;
        }
        return ' ORDER BY id ' . $order . $limit_filter;
    }
    
    public function save($entity) {
        $this->db->querycount = 0;
        $filed_list = '';
        $value_arr = array();
        $qm_list = '';
        foreach ($entity->getSettedFields() as $field=>$value) {
            $filed_list .= ',' . $field;
            $value_arr[] = $value;
            $qm_list .= ',?';
        }
        $filed_list = substr($filed_list, 1);
        $qm_list = substr($qm_list, 1);
        $sql = "INSERT INTO " . get_class($entity) . "(" . $filed_list . ") VALUES(" . $qm_list . ")";
        //echo $sql;        var_dump($value_arr);     exit;
        $this->db->query($sql, $value_arr);//Parameters must be ordered
        $this->lastInsertId = $this->db->lastInsertId();
        $this->rowCount = $this->db->querycount;
        $entity->setId($this->lastInsertId);
    }
    
    public function replace($entity) {
        $this->db->querycount = 0;
        $filed_list = '';
        $value_arr = array();
        $qm_list = '';
        foreach ($entity->getSettedFields() as $field=>$value) {
            $filed_list .= ',' . $field;
            $value_arr[] = $value;
            $qm_list .= ',?';
        }
        $filed_list = substr($filed_list, 1);
        $qm_list = substr($qm_list, 1);
        $sql = "REPLACE INTO " . get_class($entity) . "(" . $filed_list . ") VALUES(" . $qm_list . ")";
        //echo $sql;        var_dump($value_arr);     exit;
        $this->db->query($sql, $value_arr);//Parameters must be ordered
        $this->lastInsertId = $this->db->lastInsertId();
        $this->rowCount = $this->db->querycount;
    }
    
    public function selectAll(String $entityName, int $limit=0, bool $desc=true) {
        $this->db->querycount = 0;
        $fetched = $this->db->query('SELECT * FROM ' . $entityName . $this->queryAppend($limit, $desc), NULL, PDO::FETCH_ASSOC);
        return $this->getSelectedEntities($fetched, $entityName);
    }
    
    public function selectJoinAll(String $entity, int $limit=0, bool $desc=true) {
        $this->db->querycount = 0;
        $sql = 'SELECT * FROM ' . $entity;
        $entityName = ucfirst($entity);
        $object = new $entityName();
        foreach ($object->getFields() as $field) {
            if(substr($field, -3)=='_id'){
                $joined_table = substr($field, 0, -3);
                $sql .= ' LEFT OUTER JOIN ' . $joined_table . ' ON ' . $entity . '.id=' . $joined_table . '.id';
            }
        }
        //$fetched = $this->db->query('SELECT * FROM ' . $entityName . $this->queryAppend($limit, $desc), NULL, PDO::FETCH_ASSOC);
        //return $this->getSelectedEntities($fetched, $entityName);
    }
    
    public function selectColumnAll(String $entity, String $column, int $limit=0, bool $desc=true) {
        $this->db->querycount = 0;
        $fetched = $this->db->query('SELECT ' . $column . ' FROM ' . $entity . $this->queryAppend($limit, $desc), NULL, PDO::FETCH_ASSOC);
        return $this->getSelectedEntities($fetched, $entity);
    }
    
    public function selectLike(object $entity, int $limit=0, bool $desc=true) {
        $this->db->querycount = 0;
        $entityName = get_class($entity);
        $condition = '';
        $value_arr = array();
        foreach ($entity->getSettedFields() as $key => $value) {
            if($condition!=''){
                $condition .= ' AND ';
            }
            $condition .= $key . '=?';
            $value_arr[] = $value;
        }
        $fetched = $this->db->query('SELECT * FROM ' . $entityName . ' WHERE ' . $condition . $this->queryAppend($limit, $desc), $value_arr, PDO::FETCH_ASSOC);
        return $this->getSelectedEntities($fetched, $entityName);
    }
    
    public function selectById($entityName, $id, $desc=true) {
        //return $this->selectByAttr($entityName, 'id', $id)[0];
        $arr = $this->selectByAttr($entityName, 'id', $id);
        if(!empty($arr)){
            return $arr[0];
        }
        else {
            return $arr;
        }
    }
    
    /*public function selectByAttr($entityName, $attribute, $value, $desc=true) {
        $this->db->querycount = 0;
        $sql = 'SELECT * FROM ' . $entityName . ' WHERE ' . $attribute . '=?' . $this->queryAppend(0, $desc);
        $fetched = $this->db->query($sql, array($value), PDO::FETCH_ASSOC);
        //var_dump($sql); exit;
        return $this->getSelectedEntities($fetched, $entityName);
    }*/
    
    public function selectByAttr(String $entity, $attribute, $value = null, int $limit = 0, bool $desc = true) {
        $this->db->querycount = 0;
        if (is_array($attribute)) {
            $condition = '';
            $value_arr = array();
            foreach ($attribute as $key => $value) {
                if ($condition != '') {
                    $condition .= ' AND ';
                }
                $condition .= $key . '=?';
                $value_arr[] = $value;
            }
            $sql = 'SELECT * FROM ' . $entity . ' WHERE ' . $condition . $this->queryAppend($limit, $desc);
            $fetched = $this->db->query($sql, $value_arr, PDO::FETCH_ASSOC);
        } else {
            $sql = 'SELECT * FROM ' . $entity . ' WHERE ' . $attribute . '=?' . $this->queryAppend(0, $desc);
            $fetched = $this->db->query($sql, array($value), PDO::FETCH_ASSOC);
        }
        return $this->getSelectedEntities($fetched, $entity);
    }
    
    /*public function select(String $entityName) {
        $this->db->querycount = 0;
        $this->sql = 'SELECT * FROM ' . $entityName;
        $this->entityName = $entityName;
        return $this;
    }
    
    public function where(String $condition) {
        if(isset($this->sql)){
            $this->sql . ' WHERE ' . $condition;
            return $this;
            //$fetched = $this->db->query($this->sql . ' WHERE ' . $condition . $this->queryAppend($limit, $desc), NULL, PDO::FETCH_ASSOC);
            //return $this->getSelectedEntities($fetched, $this->entityName);
        } else{
            die('SELECT function is missing');
        }
    }*/
    
    public function select($column = '*') {
        $this->db->querycount = 0;
        $this->sql = 'SELECT ' . $column;
        return $this;
    }

    public function from(String $entityName) {
        if (!isset($this->sql)) {
            die('SELECT function is missing');
        }
        $this->sql .= ' FROM ' . $entityName;
        if(!isset($this->entityName)){
            $this->entityName = $entityName;
        }
        return $this;
    }

    public function where(String $condition, $array = null) {
        if (!isset($this->sql)) {
            die('SELECT function is missing');
        }
        $this->sql .= ' WHERE ' . $condition;
        $this->arrValues = $array;
        return $this;
    }

    public function queryExcec(int $limit = 0, bool $desc = true) {
        $fetched = $this->db->query($this->sql . ' ' . $this->queryAppend($limit, $desc), $this->arrValues, PDO::FETCH_ASSOC);
        return $this->getSelectedEntities($fetched, $this->entityName);
    }
    
    public function innerJOIN($column, $table) {
        $this->sql .= ' INNER JOIN ' . $table . ' ON ' . $column . '=' . $table . '.id';
        return $this;
    }
    
    public function run($limit=0, $desc=true) {
        $fetched = $this->db->query($this->sql, NULL, PDO::FETCH_ASSOC);
        return $this->getSelectedEntities($fetched, $this->entityName);
    }
    
    public function update($entity) {
        $this->db->querycount = 0;
        $set_string = '';
        $value_arr = array();
        foreach ($entity->getSettedFields() as $field=>$value) {
            $set_string .= ',' . $field . '=?';
            $value_arr[] = $value;
        }
        $set_string = substr($set_string, 1);
        $this->db->query('UPDATE ' . get_class($entity) . ' SET ' . $set_string . ' WHERE id=' . $entity->getId() . ' LIMIT 1', $value_arr);//Parameters must be ordered
        $this->rowCount = $this->db->querycount;
    }
    
    public function delete($entity) {
        if(!is_object($entity)){
            $this->throwError('Invalid entity');
        }
        $this->db->querycount = 0;
        try{
            $this->db->query('DELETE FROM ' . get_class($entity) . ' WHERE id=' . $entity->getId() . ' LIMIT 1', NULL);
        } catch (Exception $ex) {
            $this->throwError(get_class($entity) . ' with id ' . $entity->getId() . ' not exist');
        }
        $this->rowCount = $this->db->querycount;
    }
    
    private function throwError($errorMessage) {
        die($errorMessage);
    }
    
}

