<?php

class EntityCore{
    
    /*public function __construct($object=NULL) {
        if(!is_null($object)){
            foreach ($object as $key => $value) {
                if(property_exists($this, $key)) {
                    $this->$key = $value;
                }
            }
        }
    }*/
    
    public function __construct($object=NULL) {
        if(!is_null($object)){
            foreach ($object as $key => $value) {
                $setter = 'set' . ucfirst($key);
                if(method_exists($this, $setter)) {
                    $this->$setter($value);
                }
            }
        }
    }
    
    public function getRefined() {
        $refined = array();
        foreach ($this as $key => $value) {
                $refined[$key] = $value;
        }
        return (object) $refined;
    }
    
    public function getFields() {
        return get_object_vars($this);
    }
    
    public function getSettedFields() {
        $arr_field = array();
        foreach ($this->getFields() as $field=>$value) {
            if(isset($this->$field)){
                $arr_field[$field] = $value;
            }
        }
        return $arr_field;
    }
    
}

