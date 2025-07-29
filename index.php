<?php
// Récupérer le chemin demandé dans l'URL
$request = $_SERVER['REQUEST_URI'];

// Enlever le nom du dossier si présent dans l'URL
$request = str_replace('/blog', '', $request);

// Nettoyer l'URL (supprimer les éventuels paramètres ?... )
$request = parse_url($request, PHP_URL_PATH);

// Routage simple
if ($request === '/' || $request === '/index.php') {
    header('Location: views/visiteur/acceuil.php');
    exit();
} elseif ($request === '/adminer') {
    header('Location: views/admin/dashboard.php');
    exit();
} else {
    http_response_code(404);
    header('Location: views/404.php');
    exit();
}
