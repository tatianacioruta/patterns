<?php
//include config and core
require_once 'config/config.php';
require_once 'core/model.php';
require_once 'core/view.php';
require_once 'core/db.php';
require_once 'core/helper.php';
require_once 'core/controller.php';
require_once 'core/router.php';
require_once 'core/validator.php';

function class_autoload($className){
    if(file_exists(_ABS_PATH . "models/" . $className . ".php")) {
        require_once _ABS_PATH . "models/" . $className . ".php";
    }
    if(file_exists(_ABS_PATH . "classes/" . $className . ".php")) {
        require_once _ABS_PATH . "classes/" . $className . ".php";
    }
}

/**
 * Model autoloader
 */
spl_autoload_register('class_autoload');
/**
 * Start router
 */
Router::start();


