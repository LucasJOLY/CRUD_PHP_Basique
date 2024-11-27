<?php
declare(strict_types=1);

require_once __DIR__ . '/Autoloader.php';

use App\Autoloader;

Autoloader::register();

$controllerSuffix = 'Controller';
$controllerPrefix = strtolower($_GET['controller'] ?? 'flight');
$controllerName = ucfirst($controllerPrefix) . $controllerSuffix;

$actionName = strtolower($_GET['action'] ?? 'list');

$controllerClass = "App\\Controller\\$controllerName";

try {
    // Instancier le contrôleur
    $controller = new $controllerClass();
    $controller->$actionName();
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}