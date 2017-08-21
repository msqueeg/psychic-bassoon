<?php

//composer autoloader
require __DIR__ .'/vendor/autoload.php';


//moved app instantiation to separate class
$app = (new HRM\Classes\App())->get();
//run the app
$app->run();