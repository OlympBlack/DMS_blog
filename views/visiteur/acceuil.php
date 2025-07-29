<?php
 include('../../config/acceuil_config.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MonBlog - Accueil</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome pour les icônes -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../../assets/css/acceuil_style.css">
</head>
<body>
    <!-- En-tête -->
    <div class="header-section">
        <div class="container">
            <h1 class="main-title">DMS</h1>
            <h4  class="text-center">Delco Multi Service</h4>
            <p class="subtitle">Découvrez nos derniers articles</p>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="container">
        <?php if (empty($articles)): ?>
            <div class="no-articles">
                <h3><i class="fas fa-newspaper"></i> Aucun article pour le moment</h3>
                <p>Revenez bientôt pour découvrir nos nouveaux contenus !</p>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($articles as $article): ?>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="article-card" onclick="window.location.href='article.php?id=<?= $article['id_article'] ?>'" style="cursor: pointer;">
                            <?php 
                                // Constante base URL, définie dans config.php, exemple ici
                                if (!defined('BASE_URL')) {
                                    define('BASE_URL', '/blog');  // Modifie selon ta config serveur
                                }

                                $media_file = htmlspecialchars($article['media']);
                                
                                // Si URL complète
                                if (preg_match('/^https?:\/\//', $media_file)) {
                                    $media_path = $media_file;
                                } else {
                                    $media_path = BASE_URL . '/uploads/' . $media_file;
                                }
                                
                                $file_extension = strtolower(pathinfo($media_file, PATHINFO_EXTENSION));
                                $video_extensions = ['mp4', 'webm', 'ogg', 'avi', 'mov'];
                                $image_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
                            ?>

                            <div class="media-container">
                                <?php if (in_array($file_extension, $video_extensions)): ?>
                                    <video controls muted preload="metadata" playsinline>
                                        <source src="<?= $media_path ?>" type="video/<?= $file_extension === 'mov' ? 'mp4' : $file_extension ?>">
                                        <div style="display: flex; align-items: center; justify-content: center; height: 100%; background: #f8f9fa; color: #6c757d;">
                                            <div style="text-align: center;">
                                                <i class="fas fa-video" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                                                <p>Vidéo non disponible</p>
                                            </div>
                                        </div>
                                    </video>
                                <?php elseif (in_array($file_extension, $image_extensions) || empty($file_extension)): ?>
                                    <img src="<?= $media_path ?>" 
                                        alt="<?= htmlspecialchars($article['titre']) ?>" 
                                        loading="lazy"
                                        onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div style="display: none; align-items: center; justify-content: center; height: 100%; background: linear-gradient(45deg, #667eea, #764ba2); color: white;">
                                        <div style="text-align: center;">
                                            <i class="fas fa-image" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                                            <p>Image non disponible</p>
                                            <small style="opacity: 0.8;"><?= basename($media_path) ?></small>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div style="display: flex; align-items: center; justify-content: center; height: 100%; background: #f8f9fa; color: #6c757d;">
                                        <div style="text-align: center;">
                                            <i class="fas fa-file" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                                            <p>Format non supporté</p>
                                            <small><?= $file_extension ?></small>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="media-overlay"></div>
                            </div>

                            
                            <div class="card-content">
                                <h3 class="article-title"><?= htmlspecialchars($article['titre']) ?></h3>
                                <p class="article-description"><?= htmlspecialchars($article['description']) ?></p>
                                
                                <div class="like-section">
                                    <button class="like-btn <?= in_array($article['id_article'], $liked_articles) ? 'liked' : '' ?>" 
                                            onclick="likeArticle(<?= $article['id_article'] ?>, this)">
                                        <i class="fas fa-heart"></i>
                                        <span>J'aime</span>
                                    </button>
                                    <span class="like-count" id="likes-<?= $article['id_article'] ?>">
                                        <?= $article['likes'] ?? 0 ?> likes
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Bouton WhatsApp -->
    <a href="https://wa.me/+22990010184" 
       class="whatsapp-btn" target="_blank">
        <i class="fab fa-whatsapp"></i>
        <span class="d-none d-sm-inline">Contactez-nous</span>
    </a>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Fonction pour gérer les likes
        function likeArticle(articleId, button) {
            // Vérifier si déjà liké
            if (button.classList.contains('liked')) {
                return;
            }
            
            // Animation du bouton
            button.classList.add('loading');
            const heart = button.querySelector('i');
            heart.classList.add('pulse');
            
            // Requête AJAX
            fetch(window.location.href, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=like&article_id=${articleId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Mettre à jour l'affichage
                    button.classList.add('liked');
                    document.getElementById(`likes-${articleId}`).textContent = `${data.likes} likes`;
                    
                    // Animation de succès
                    setTimeout(() => {
                        heart.classList.remove('pulse');
                        button.classList.remove('loading');
                    }, 600);
                } else {
                    console.log('Déjà liké ou erreur');
                    button.classList.remove('loading');
                    heart.classList.remove('pulse');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                button.classList.remove('loading');
                heart.classList.remove('pulse');
            });
        }

        // Animation d'apparition au scroll
        function animateOnScroll() {
            const cards = document.querySelectorAll('.article-card');
            
            cards.forEach(card => {
                const cardTop = card.getBoundingClientRect().top;
                const cardVisible = 150;
                
                if (cardTop < window.innerHeight - cardVisible) {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }
            });
        }

        // Initialiser les animations
        document.addEventListener('DOMContentLoaded', function() {
            // Préparer les cartes pour l'animation
            const cards = document.querySelectorAll('.article-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(50px)';
                card.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
            });
            
            // Déclencher l'animation
            setTimeout(animateOnScroll, 100);
        });

        // Animation au scroll
        window.addEventListener('scroll', animateOnScroll);
    </script>
</body>
</html>