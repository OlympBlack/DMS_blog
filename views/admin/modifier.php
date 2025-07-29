

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un article</title>

    <link rel="stylesheet" href="../../assets/css/modifier_style.css">
    <style>
        
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
