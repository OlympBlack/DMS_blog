<?php

    session_start();

    //refuser l'accès sans être authentifier
    if(!isset($_SESSION['admin'])){
        header('Location: login.php');
    }


// Connexion à la base
try {
    $bdd = new PDO('mysql:host=localhost; dbname=blog; charset=utf8', 'root', '');
} catch (Exception $e) {
    die("Une erreur s'est produite");
}

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

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un article</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            color: #333;
        }

        .form-container {
            width: 90%;
            max-width: 550px;
            margin: 60px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 16px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            font-size: 14px;
        }

        input[type="text"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
        }

        button {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            transition: background 0.3s ease;
        }

        button:hover {
            background: linear-gradient(135deg, #5a6bd6, #6a4196);
        }

        a {
            display: block;
            text-align: center;
            margin-top: 16px;
            text-decoration: none;
            color: #667eea;
            font-weight: bold;
        }

        .success-message,
        .error-message {
            width: 90%;
            max-width: 550px;
            margin: 20px auto;
            padding: 15px;
            border-radius: 10px;
            font-size: 15px;
            text-align: center;
        }

        .success-message {
            background-color: #e6ffe6;
            border: 1px solid #33cc33;
            color: #2d862d;
        }

        .error-message {
            background-color: #ffe6e6;
            border: 1px solid #cc0000;
            color: #990000;
        }

        img, video {
            max-width: 100%;
            max-height: 250px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 15px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }


        @media (max-width: 600px) {
            .form-container {
                padding: 20px;
                margin: 30px auto;
            }

            button {
                font-size: 15px;
            }
        }
    </style>
</head>
<body>


<?php if (count($rows) > 0): ?>
    <?php foreach($rows as $row): ?>
        <div class="form-container">
            <h2>Modifier l'article</h2>

            <?php if (isset($_GET['success'])): ?>
                <div class="success-message">L'article a été modifié avec succès !</div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>

            <form action="modifier.php?id=<?php echo $row['id_article']; ?>" method="POST" enctype="multipart/form-data">
                <label for="title">Titre</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($row['titre']); ?>">

                <label for="description">Description</label>
                <textarea id="description" name="description" rows="5"><?php echo htmlspecialchars($row['description']); ?></textarea>

                <?php if (!empty($row['media'])): ?>
                    <p>Média actuel :</p>
                    <?php if (preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $row['media'])): ?>
                        <img src="<?php echo $row['media']; ?>" alt="Média">
                    <?php else: ?>
                        <video src="<?php echo $row['media']; ?>" controls></video>
                    <?php endif; ?>
                <?php endif; ?>

                <label for="media">Changer le média</label>
                <input type="file" id="media" name="media" accept="image/*,video/*">

                <button type="submit">Sauvegarder</button>
                <a href="dashboard.php">← Retour au dashboard</a>
            </form>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p style="text-align:center; color:white; margin-top: 50px;">Aucun article trouvé.</p>
<?php endif; ?>

</body>
</html>
