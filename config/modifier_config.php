<?php
session_start();

// Refuser l'accès sans être authentifié
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

// Connexion à la base
include('config.php'); // Chemin absolu recommandé si ce fichier est dans admin/

$rows = [];

// Récupérer l'article
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $req = $pdo->prepare('SELECT * FROM articles WHERE id_article = :id');
    $req->bindParam(':id', $id, PDO::PARAM_INT);
    $req->execute();
    $rows = $req->fetchAll(PDO::FETCH_ASSOC);
}

// Mise à jour si formulaire soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $titre = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);

    if (isset($_FILES['media']) && $_FILES['media']['error'] === UPLOAD_ERR_OK) {
        // Préparer le répertoire cible
        $uploadDir = realpath(__DIR__ . '/../uploads');
        if (!$uploadDir) {
            die("Le dossier d'upload est introuvable.");
        }

        // Nettoyage du nom du fichier + prévention de conflit
        $mediaName = uniqid() . '_' . basename($_FILES['media']['name']);
        $mediaDest = $uploadDir . DIRECTORY_SEPARATOR . $mediaName;

        if (move_uploaded_file($_FILES['media']['tmp_name'], $mediaDest)) {
            $update = $pdo->prepare('UPDATE articles SET titre = :titre, description = :description, media = :media WHERE id_article = :id');
            $update->execute([
                ':titre' => $titre,
                ':description' => $description,
                ':media' => $mediaName, 
                ':id' => $id
            ]);
        } else {
            $error = "Erreur lors de l’upload du média.";
        }
    } else {
        $update = $pdo->prepare('UPDATE articles SET titre = :titre, description = :description WHERE id_article = :id');
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
