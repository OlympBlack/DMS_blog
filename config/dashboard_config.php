<?php

    session_start();

    //refuser l'accès sans être authentifié
    if(!isset($_SESSION['admin'])){
        header('Location: login.php');
    }

    //Connexion à la base de donnée
   include('bdd.php');

    if(isset($_SESSION['admin'])){
        $nomAdmin = $_SESSION['admin'];
    }

    // Sélection des données
    $stmt = $conn->prepare("SELECT * FROM articles  ORDER BY id_article DESC");
    $stmt->execute();
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Pagination
    $itemsPerPage = 5;  
    $totalItems = count($articles);
    $totalPages = ceil($totalItems / $itemsPerPage);
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $currentPage = max(1, min($currentPage, $totalPages)); // Assurer que la page courante est valide
    $startItem = ($currentPage - 1) * $itemsPerPage;
    $endItem = min($startItem + $itemsPerPage, $totalItems);
    $articlesToShow = array_slice($articles, $startItem, $itemsPerPage);
    // Génération des numéros de page
    $pageNumbers = [];
    for ($i = 1; $i <= $totalPages; $i++) {
        $pageNumbers[] = $i;
    }


?>