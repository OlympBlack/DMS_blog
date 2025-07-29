<?php

    session_start();

    //Connexion à la base de donnée
    include('bdd.php');

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //Récuperer les information entrer dans le formulaire.

        $email = $_POST['email'] ?? "";
        $pass = $_POST['password'] ?? "";
        
        // Selectionner l'admin dans la base de donnée
        $req = $conn->prepare("SELECT nom_complet, email, mot_de_pass FROM users");
        $req->execute();
        $admin = $req->fetch(PDO::FETCH_ASSOC);

        $emailAdmin = $admin['email'];
        $passAdmin = $admin['mot_de_pass'];

        if($email == $emailAdmin && $pass == $passAdmin){
            header("location: dashboard.php");
            $_SESSION['admin'] = $admin['nom_complet'];
        }
        else{
            $error = "Email ou mot de passe incorrecte";
        }


    }
?>
