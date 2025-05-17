<?php
session_start();
require_once __DIR__ . '/../src/Core/Autoloader.php';
(new \Liberta_Mobile\Core\Autoloader())->register();

use Liberta_Mobile\Controller\MainController;

$controller = new MainController();
$controller->route();