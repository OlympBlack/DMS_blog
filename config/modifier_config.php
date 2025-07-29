<?php

    session_start();

    //refuser l'accès sans être authentifier
    if(!isset($_SESSION['admin'])){
        header('Location: login.php');
    }


// Connexion à la base
include('config.php');

$rows = [];

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Récupérer l'article
    $req = $bdd->prepare('SELECT * FROM articles WHERE id_article = :id');
    $req->bindParam(':id', $id);
    $req->execute();
    $rows = $req->fetchAll(PDO::FETCH_ASSOC);
}

// Mise à jour si formulaire soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $titre = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);

    if (isset($_FILES['media']) && $_FILES['media']['error'] === UPLOAD_ERR_OK) {
        $mediaName = $_FILES['media']['name'];
        $mediaTmp = $_FILES['media']['tmp_name'];
        $mediaDest = 'uploads/' . uniqid() . '_' . basename($mediaName);

        if (move_uploaded_file($mediaTmp, $mediaDest)) {
            $update = $bdd->prepare('UPDATE articles SET titre = :titre, description = :description, media = :media WHERE id_article = :id');
            $update->execute([
                ':titre' => $titre,
                ':description' => $description,
                ':media' => $mediaDest,
                ':id' => $id
            ]);
        } else {
            $error = "Erreur lors de l’upload du média.";
        }
    } else {
        $update = $bdd->prepare('UPDATE articles SET titre = :titre, description = :description WHERE id_article = :id');
        $update->execute([
            ':titre' => $titre,
            ':description' => $description,
            ':id' => $id
        ]);
    }

    header("Location: modifier.php?id=$id&success=1");
    exit();
}
?>