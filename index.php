<?php

require_once('./Autoloader.php');

session_start();

use Application\Lib\Tools;
use Application\Router\MainRouter;

if(!isset($_SESSION['user'])) Tools::defaultUser();

$uri = str_replace('/','',$_SERVER['REQUEST_URI']);

$_SESSION['err'] = isset($_SESSION['err']) ? $_SESSION['err'] : null;
$_SESSION['success'] = isset($_SESSION['success']) ? $_SESSION['success'] : null;

$router = new MainRouter($uri);

$router->get('/','Homepage#index');