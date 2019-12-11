<?php
abstract class Controller{
    
    protected $getParams;

    protected $postParams;

    protected $controller;

    protected $view;

    protected $db;

    protected $headerParams;
    
    protected $payload;

    const STATUS_OK = 200;
    const STATUS_ERROR = 500;
    const STATUS_FORBIDDEN = 403;
    const STATUS_NOT_FOUND = 404;


    public function __construct($db){
        
        $this->view = $_GET['action']??DEFAULT_ACTION;
        $this->controller = $_GET['controller']??DEFAULT_CONTROLLER;
        $this->db = $db;

        unset($_GET['controller']);
        unset($_GET['action']);
        
        $this->getParams = new stdClass();
        $this->postParams = new stdClass();
        $this->headerParams =  apache_request_headers();
        $this->headerParams['client_ip'] = $_SERVER['REMOTE_ADDR'];
        foreach($_GET as $index=>$value){
            $this->getParams->$index = $value;
        }

        foreach($_POST as $index=>$value){
            $this->postParams->$index = $value;
        }

        $request_body = file_get_contents('php://input');
        $this->payload = json_decode($request_body);

    }

    protected function render($view, $vars = [],$type = 'phtml'){
        
        if($type == 'json'){
            header('Access-Control-Allow-Origin: *');
            header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
            header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
            return json_encode($vars);
        }elseif($type == 'webhook'){
            return $vars;
        }else{
            ob_start();
            foreach($vars as $nam=>$var){
                $$nam=$var;
            }
            include VIEW_FOLDER.$view.'.'.$type;
            $content = ob_get_contents();
            ob_end_clean();
            return $content;
        }
        
    }
    protected function httpResponse($type=self::STATUS_OK){
        switch($type){
            case self::STATUS_OK:
                header("HTTP/1.1 200 OK");
            break;
            case self::STATUS_FORBIDDEN:
                header("HTTP/1.1 403 Forbidden");
            break;
            case self::STATUS_ERROR:
                header("HTTP/1.1 500 Internal Server Error");
            break;
            default:
                header("HTTP/1.1 404 Not Found");
        }
    }

}