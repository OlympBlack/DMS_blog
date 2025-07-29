<?php

    session_start();

    //refuser l'accès sans être authentifier
    if(!isset($_SESSION['admin'])){
        header('Location: login.php');
    }

//connexion à la base de données
  include('config.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $titre = $_POST['title'];
        $description = $_POST['description'];
        $media = $_FILES['media'];

        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["media"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Vérifier si le fichier existe déjà
        /*if (file_exists($target_file)) {
            $error = "Désolé, le fichier existe déjà.";
            $uploadOk = 0;
        }

        // Vérifier la taille du fichier (facultatif)
        if ($_FILES["media"]["size"] > 500000) {
            $error = "Désolé, votre fichier est trop volumineux.";
            $uploadOk = 0;
        }

        // Autoriser certains formats de fichier (facultatif)
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" && $imageFileType != "mp4" && $imageFileType != "webm" && $imageFileType != "avi" ) {
            $error = "Désolé, seuls les formats JPG, JPEG, PNG, GIF, MP4, WEBM & AVI sont autorisés.";
            $uploadOk = 0;
        }*/

        $target_dir = realpath(__DIR__ . '/../uploads') . '/';
        $target_file = $target_dir . basename($_FILES["media"]["name"]);

        if ($uploadOk == 0) {
            $error = "Désolé, votre fichier n'a pas été téléversé.";
        } else {
            if (move_uploaded_file($_FILES["media"]["tmp_name"], $target_file)) {
                $media_name = basename($_FILES["media"]["name"]);
                $req = $pdo->prepare("INSERT INTO articles(media, description, titre) VALUES(?, ?, ?)");
                $req->execute([$media_name, $description, $titre]);
                $success = "Élément ajouté avec succès !";
                header("Location: ../admin/dashboard.php");
                exit();
            } else {
                $error = "Désolé, une erreur est survenue lors du téléversement de votre fichier.";
            }
        }


    }
?>