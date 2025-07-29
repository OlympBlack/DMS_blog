<?php
 include('../../config/login_config.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Administrateur</title>

    <link rel="stylesheet" href="../../assets/css/login_style.css">
    <style>
        
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