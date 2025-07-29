<?php 
// supprimer.php
//Connexion à la base de donnée
    $server = 'localhost';
    $dbname = 'blog';
    $username = 'root';
    $password = '';

    try{
        $conn = new PDO("mysql:host=$server;dbname=$dbname", $username, $password);
    }
    catch(PDOExcetion $e){
        echo 'Erreur'. $e->getMessage();
    }

// Vérifier si l'ID de l'article est passé en paramètre
if (isset($_GET['id'])) {

    $id = $_GET['id'];

    // Préparer et exécuter la requête de suppression
    $stmt = $conn->prepare("DELETE FROM articles WHERE id_article = :id");
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        // Rediriger vers la page d'accueil après la suppression
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Erreur lors de la suppression de l'article.";
    }
} else {
    echo "ID d'article non spécifié.";
}
?>