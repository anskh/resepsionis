<?php

declare(strict_types=1);

if(!defined("ROOT")) define("ROOT", __DIR__);

require_once ROOT . "/vendor/autoload.php";

if($argc > 1){
    $action = $argv[1];
}else{
    $action = null;
}

if(!empty($action)){
    if(!in_array($action, ['up','down','seed'], true)){
        die('Argument is invalid. Available arguments are up, seed, or down');
    }
}

// init config
app()->init(ROOT . '/config');

// build migration
$builder = app()->buildMigration(ROOT . '/migration', $action);
$builder->applyMigration();