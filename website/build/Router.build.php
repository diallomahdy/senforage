<?php

class Router {

    public $controller;

    public function __construct() {

        // Starting session
        session_start();

        // Controller maping array
        $controller_maping = array(
            'Home' => array('register')
        );

        if (isset($_GET['url'])) {
            $url = explode('/', $_GET['url']);
            $given_controller = ucfirst($url[0]);
            $file = __DIR__ . '/../controllers/' . $given_controller . '.ctrl.php';
            if (!file_exists($file) && $given_controller = PHPArray::getKeyByValue($given_controller, $controller_maping)) {
                $file = __DIR__ . '/../controllers/' . $given_controller . '.ctrl.php';
                $url[1] = $url[0];
            }
            if (file_exists($file)) {
                require_once $file;
                $controller = new $given_controller();
                //si la methode est saisie
                if (isset($url[1])) {
                    $given_method = $url[1];
                    if ($given_method == "") {
                        $given_method = "index";
                    }
                    if (method_exists($controller, $given_method)) {
                        $method = $given_method;
                        $reflect = new ReflectionMethod($given_controller, $given_method);
                        $params = $reflect->getParameters();
                        if (count($params) == 0) {
                            $controller->$method();
                        } else {
                            if (isset($url[2])) {
                                $controller->{$given_method}($url[2]);
                            } else {
                                $msg = "la methode<b> " . $given_method . "()</b> a un parameter";
                                $controller = $this->throwError($msg);
                            }
                        }
                    } else {
                        $msg = "La méthode <b>" . $given_method . "()</b> n'existe pas dans le controller <b>" . $given_controller . "</b> !";
                        $controller = $this->throwError($msg);
                    }
                } else {
                    if (method_exists($controller, "index")) {
                        $controller->{"index"}();
                    } else {
                        $msg = "La méthode <b>index()</b> n'existe pas dans le controller <b>" . $given_controller . "</b> !";
                        $controller = $this->throwError($msg);
                    }
                }
            } else {
                $given_controller = ucfirst($url[0]);
                $msg = "Le controller <b>" . $given_controller . "</b> n'existe pas !";
                $controller = $this->throwError($msg);
            }
        } else {
            $file = __DIR__ . '/../controllers/' . CONFIG['welcome_controller'] . '.ctrl.php';
            if (file_exists($file)) {
                require_once $file;
                $controller = CONFIG['welcome_controller'];
                $controller = new $controller();

                if (method_exists($controller, "index")) {
                    $controller->{"index"}();
                } else {
                    $msg = "La methode <b>index()</b> n'existe pas dans le controller <b>" . CONFIG['welcome_controller'] . "</b> !";
                    $controller = $this->throwError($msg);
                }
            } else {
                $msg = "Le controller <b>" . CONFIG['welcome_controller'] . "</b> n'existe pas !";
                $msg = $msg . "<br/>Merci de vérifier votre configuration.</b> !";
                $controller = $this->throwError($msg);
            }
        }
        $this->controller = $controller;
    }

    private function throwError($message) {
        //echo $message;
        //ob_get_clean();
        require_once __DIR__ . '/../controllers/Errors.ctrl.php';
        $controller = new Errors();
        if (method_exists($controller, "index")) {
            $controller->{"index"}();
        }
        //$controller->dom = str_get_html($controller->dom);
        // $controller->refreshDOM();
        $controller->dom->find('#errorMsg', 0)->innertext = $message;
        return $controller;
    }

    public function render() {
        $scripts = '<script>';
        $scripts .= 'PHPData=' . json_encode($this->controller->data) . ';';
        if(isset($this->controller->status)){
            $scripts .= 'PHPStatus=' . json_encode($this->controller->status) . ';';
        }
        $scripts .= 'PHPConfig=' . json_encode(CONFIG_ASSET) . ';';
        $scripts .= 'PHPTranslator=' . json_encode($this->controller->translation);
        $scripts .= '</script>';
        /*$scripts .= '<script src="assets/js/fusion.js"></script>';
        if(get_class($this->controller)=='installer')
            $app = 'installer';
        else
           $app = 'senforage';
        $scripts .= '<script src="assets/js/' . $app . '.interact.js"></script>';*/
        $this->controller->loadHtml($scripts, 'head');
        $this->controller->runModeAdapt();
        echo $this->controller->dom;
    }

}
