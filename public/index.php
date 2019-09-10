<?php
namespace Fighter;
use Fighter\Core\App;

require __DIR__.'/../vendor/autoload.php';
$app = new App();
return $app->handleRequest();