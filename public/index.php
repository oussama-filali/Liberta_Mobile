<?php
session_start();
require_once __DIR__ . '/../src/core/Autoloader.php';
(new \Liberta_Mobile\Core\Autoloader())->register();

use Liberta_Mobile\controller\MainController;

$controller = new MainController();
$GLOBALS['controller'] = $controller;
$controller->route();