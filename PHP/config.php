<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors',TRUE);
spl_autoload_register(function($nameClass){
    $fileName = "class".DIRECTORY_SEPARATOR.$nameClass.".php";
    if(file_exists($fileName)){
        require_once($fileName);
    }
});
?>