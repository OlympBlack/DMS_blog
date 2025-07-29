<?php
// Détection de l'environnement (local ou en ligne)
$host = $_SERVER['HTTP_HOST'];

if ($host === 'localhost') {
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'blog');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('BASE_URL', '/blog'); 
} else {
    define('DB_HOST', 'sql.nomduserveur.com');
    define('DB_NAME', 'tonbasededonnees');
    define('DB_USER', 'tonutilisateur');
    define('DB_PASS', 'tonmotdepasse');
    define('BASE_URL', '');
}

// Connexion PDO
try {
    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}
