<?php
include 'Configs/constants.php';
include 'Configs/Connection.php';
include CONTROLLER_FOLDER.'Controller.php';

$scanned_directory = array_diff(scandir(MODEL_FOLDER), array('..', '.','Model.php'));
include MODEL_FOLDER."Model.php";
foreach($scanned_directory as $modelFile){
    include MODEL_FOLDER.$modelFile;
}


try {
    $fileInclude =  DEFAULT_CONTROLLER.CONTROLLER_EXT;
    $controllerClass = DEFAULT_CONTROLLER;
    $action = DEFAULT_ACTION.ACTION_EXT;
    if(!empty($_GET) && !empty($_GET['controller'])){
        $fileInclude = $_GET['controller'].CONTROLLER_EXT;
        $controllerClass = $_GET['controller'];
    }
    if(!empty($_GET['action'])){
        $action = $_GET['action'].ACTION_EXT;
    }

    include CONTROLLER_FOLDER.$fileInclude;
    $object = new $controllerClass(Connection::get()->connect());
    $printer = $object->$action();
    foreach($printer as $p){
        echo $p;
    }
} catch (\PDOException $e) {
    echo $e->getMessage();
}