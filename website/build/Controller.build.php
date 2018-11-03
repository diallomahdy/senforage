<?php

class Controller{
    protected $root_dir;
    public $dom;
    public $rand;
    public $data;
    public $date;
    public $translation;


    protected function __construct(){
        $this->rand = rand(100000000, 999999999);
        $this->date = date('Y-m-d');
        $this->data = array();
        $this->em = new EntityManager();
        $classname = get_class($this);
        $this->retrievePostData();
        $this->retrieveSessionData();
        $this->views = __DIR__.'/../views/layout/';
        $this->loadView('index');
        $this->views = __DIR__.'/../views/' . get_class($this) . '/';
    }
    
    public function loadView(String $view, String $node=NULL) {
        //if(!isset($this->dom)){
        if($node==NULL){
            $this->dom = new simple_html_dom();
            $this->dom = file_get_contents($this->views . $view . '.html');
        }
        else{
            $dom_node = $this->dom->find($node, 0);
            if($dom_node==NULL){
                $dom_node = $this->dom->getElementsById($node, 0);
            }
            if($dom_node!=NULL){
                $dom_node->innertext .= file_get_contents($this->views . $view . '.html');
            }
        }
        $this->refreshDOM();
    }
    
    public function loadHtml(String $html, String $node=NULL) {
        if($node==NULL){
            $this->dom = new simple_html_dom();
            $this->dom = $html;
        }
        else{
            $dom_node = $this->dom->find($node, 0);
            if($dom_node==NULL){
                $dom_node = $this->dom->getElementsById($node, 0);
            }
            if($dom_node!=NULL){
                $dom_node->innertext .= $html;
            }
        }
        $this->refreshDOM();
    }
    
    public function refreshDOM() {
        $this->dom = str_get_html($this->dom);
    }
    
    /**
    * Load an entity object to current controller
    *
    * @param String   $entity  An entity string name
    * 
    * @return void
    */ 
    public function loadEntity(String $entity) {
        require_once CONFIG['entities_dir'] . $entity . '.entity.php';
    }
    
    public function redirect($url, $external=false) {
        header('Location:' . CONFIG['root_url'] . $url);
    }
    
    public function handleStatus($message, $status = 'success', $node = 'statusMsg') {
        $html = '<div class="alert alert-' .$status . '">';
        $html .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">';
        $html .= '×</button>';
        $html .= '<span class="glyphicon glyphicon-hand-right"></span>&nbsp;&nbsp;';
        $html .= $message;
        $html .= '</div>';
        $this->loadHtml($html, $node);
    }
    
    /**
    * Retrieve POST data and add it into current propertie post object
    *
    * @return void
    */ 
    public function retrievePostData() {
        if(isset($_POST)){
            $this->post = (object) $_POST;
        }
    }
    
    /**
    * Retrieve SESSION data and add it into current propertie data object
    *
    * @return void
    */ 
    private function retrieveSessionData() {
        if(isset($_SESSION)){
            $this->session = (object) $_SESSION;
        }
    }
    
    /**
    * Append data to current propertie data object
    *
    * @param mixed   $data  String, array, object...
    * 
    * @return void
    */ 
    public function appendData($data, $key=NULL) {
        if($key==NULL){
            $this->data[] = $data;
        }
        else{
            $this->data[$key] = $data;
        }
    }
    
    public function runModeAdapt() {
        if ( CONFIG['run_mode'] == 'local' ) {
            foreach($this->dom->find('[href]') as $node) {
                if(substr($node->href, 0, 4)!='http')
                    $node->href = CONFIG['root_url'] . $node->href;
                else
                    $node->href .= '?r=' . $this->rand;
            }
            foreach($this->dom->find('[src]') as $node) {
                if(substr($node->src, 0, 4)!='http')
                    $node->src = CONFIG['root_url'] . $node->src;
                else
                    $node->src .= '?r=' . $this->rand;
            }
            foreach($this->dom->find('[action]') as $node) {
                $node->action = CONFIG['root_url'] . $node->action;
            }
        }
    }
    
}

