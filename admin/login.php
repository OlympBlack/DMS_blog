<?php

    session_start();
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

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Administrateur</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 400px;
            position: relative;
            overflow: hidden;
        }

        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: none;
            align-items: center;
            gap: 10px;
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4, #feca57);
            background-size: 300% 300%;
            animation: gradient 3s ease infinite;
        }

        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        .logo-icon svg {
            width: 40px;
            height: 40px;
            color: white;
        }

        .logo h1 {
            color: #333;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .logo p {
            color: #666;
            font-size: 14px;
        }

        .form-group {
            position: relative;
            margin-bottom: 25px;
        }

        .form-group input {
            width: 100%;
            padding: 15px 20px 15px 50px;
            border: 2px solid #e1e8ed;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group .icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            transition: color 0.3s ease;
        }

        .form-group input:focus + .icon {
            color: #667eea;
        }

        .form-group label {
            position: absolute;
            left: 50px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 16px;
            pointer-events: none;
            transition: all 0.3s ease;
        }

        .form-group input:focus + .icon + label,
        .form-group input:not(:placeholder-shown) + .icon + label {
            top: -10px;
            left: 20px;
            font-size: 12px;
            color: #667eea;
            background: white;
            padding: 0 5px;
        }

        .forgot-password {
            text-align: right;
            margin-bottom: 25px;
        }

        .forgot-password a {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .forgot-password a:hover {
            color: #764ba2;
        }

        .login-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .login-btn:hover::before {
            left: 100%;
        }

        .divider {
            text-align: center;
            margin: 30px 0;
            position: relative;
            color: #999;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e1e8ed;
        }

        .divider span {
            background: white;
            padding: 0 15px;
        }

        .security-note {
            background: #f8f9fa;
            border: 1px solid #e1e8ed;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            margin-top: 20px;
        }

        .security-note .shield-icon {
            color: #28a745;
            margin-bottom: 5px;
        }

        .security-note p {
            font-size: 12px;
            color: #666;
            margin: 0;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
                margin: 10px;
            }

            .logo h1 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <div class="logo-icon">
                <svg fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/>
                </svg>
            </div>
            <h1>Administration</h1>
            <p>Accès sécurisé aux fonctionnalités</p>

        </div>

        <?php 
             if(isset($error)) {
                echo '<div class="error-message" style="display:block;">'.$error.'</div>';
            }
        ?>

        <form id="loginForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="form-group">
                <input type="email" name="email" id="email" placeholder=" " required>
                <div class="icon">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
                <label for="email">Adresse email</label>
            </div>

            <div class="form-group">
                <input type="password" name="password" id="password" placeholder=" " required>
                <div class="icon">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                    </svg>
                </div>
                <label for="password">Mot de passe</label>
            </div>


            <input type="submit" value="Se connecter" class="login-btn">
        </form>
    </div>

    <script>
        // document.getElementById('loginForm').addEventListener('submit', function(e) {
        //     e.preventDefault();
            
        //     const email = document.getElementById('email').value;
        //     const password = document.getElementById('password').value;
            
        //     // Animation du bouton
        //     const btn = document.querySelector('.login-btn');
        //     btn.style.background = '#28a745';
        //     btn.innerHTML = '✓ Connexion en cours...';
            
        //     // Simulation de la connexion
        //     setTimeout(() => {
        //         if (email && password) {
        //             alert('Connexion réussie ! Redirection vers le tableau de bord...');
        //             // Ici vous pouvez rediriger vers la page d'administration
        //             // window.location.href = '/admin/dashboard';
        //         } else {
        //             alert('Veuillez remplir tous les champs.');
        //             btn.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
        //             btn.innerHTML = 'Se connecter';
        //         }
        //     }, 1500);
        // });

        // // Animation des champs au focus
        // document.querySelectorAll('input').forEach(input => {
        //     input.addEventListener('focus', function() {
        //         this.parentElement.style.transform = 'translateY(-2px)';
        //     });
            
        //     input.addEventListener('blur', function() {
        //         this.parentElement.style.transform = 'translateY(0)';
        //     });
        // });
    </script>
</body>
</html>