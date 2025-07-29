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
    
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --accent-color: #f093fb;
            --dark-color: #2c3e50;
            --light-color: #ecf0f1;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: var(--dark-color);
        }

        .header-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            padding: 2rem 0;
            margin-bottom: 3rem;
        }

        .main-title {
            font-weight: 700;
            font-size: 3rem;
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .subtitle {
            text-align: center;
            color: #6c757d;
            font-size: 1.2rem;
            font-weight: 300;
        }

        .whatsapp-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: linear-gradient(45deg, #25d366, #128c7e);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 15px 25px;
            font-size: 1.1rem;
            font-weight: 600;
            box-shadow: 0 8px 25px rgba(37, 211, 102, 0.4);
            transition: all 0.3s ease;
            z-index: 1000;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .whatsapp-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(37, 211, 102, 0.6);
            color: white;
        }

        .article-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            transition: all 0.4s ease;
            overflow: hidden;
            height: 100%;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            cursor: pointer;
        }

        .article-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
        }

        .media-container {
            position: relative;
            height: 250px;
            overflow: hidden;
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
        }

        .media-container img,
        .media-container video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
            background: #000;
        }

        .media-container video::-webkit-media-controls-panel {
            background-color: rgba(0, 0, 0, 0.8);
        }

        .media-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            text-align: center;
        }

        .article-card:hover .media-container img,
        .article-card:hover .media-container video {
            transform: scale(1.1);
        }

        .media-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, transparent, rgba(0,0,0,0.3));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .article-card:hover .media-overlay {
            opacity: 1;
        }

        .card-content {
            padding: 1.5rem;
        }

        .article-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.8rem;
            line-height: 1.4;
        }

        .article-description {
            color: #6c757d;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 1.2rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .like-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 1rem;
            border-top: 1px solid rgba(0,0,0,0.1);
        }

        .like-btn {
            background: none;
            border: none;
            color: #6c757d;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 8px 15px;
            border-radius: 25px;
        }

        .like-btn:hover {
            background: rgba(255, 20, 147, 0.1);
            color: #ff1493;
        }

        .like-btn.liked {
            color: #ff1493;
            background: rgba(255, 20, 147, 0.1);
        }

        .like-count {
            font-weight: 600;
            color: var(--dark-color);
        }

        .no-articles {
            text-align: center;
            padding: 4rem 0;
            color: white;
        }

        .no-articles h3 {
            font-size: 2rem;
            margin-bottom: 1rem;
            opacity: 0.9;
        }

        .no-articles p {
            font-size: 1.1rem;
            opacity: 0.7;
        }

        @media (max-width: 768px) {
            .main-title {
                font-size: 2rem;
            }
            
            .whatsapp-btn {
                bottom: 20px;
                right: 20px;
                padding: 12px 20px;
                font-size: 1rem;
            }
            
            .media-container {
                height: 200px;
            }
            
            .article-title {
                font-size: 1.1rem;
            }
        }

        .loading {
            opacity: 0.7;
            pointer-events: none;
        }

        .pulse {
            animation: pulse 0.6s ease;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
    </style>
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
                            <div class="media-container">
                                <?php 
                                $media_path = htmlspecialchars($article['media']);
                                
                                // Vérifier si le chemin commence par http/https ou s'il faut ajouter un dossier
                                if (!preg_match('/^https?:\/\//', $media_path)) {
                                    // Si ce n'est pas une URL complète, on assume que c'est dans un dossier local
                                    if (!str_starts_with($media_path, '/') && !str_starts_with($media_path, './')) {
                                        $media_path = '../uploads/' . $media_path; // Ajustez le dossier selon votre structure
                                    }
                                }
                                
                                $file_extension = strtolower(pathinfo($media_path, PATHINFO_EXTENSION));
                                $video_extensions = ['mp4', 'webm', 'ogg', 'avi', 'mov'];
                                $image_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
                                ?>
                                
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