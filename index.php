<?php
// Base dynamique selon l'emplacement du projet
$script_name = dirname($_SERVER['SCRIPT_NAME']);
$request = str_replace($script_name, '', $_SERVER['REQUEST_URI']);
$request = parse_url($request, PHP_URL_PATH);

// Routage
if ($request === '/' || $request === '/index.php') {
    header('Location: views/visiteur/acceuil.php');
    exit();
} elseif ($request === '/adminer') {
    header('Location: views/admin/dashboard.php');
    exit();
} else {
    http_response_code(404);
    include 'views/404.php';
    exit();
}
