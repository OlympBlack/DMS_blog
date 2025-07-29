<?php
 include('../../config/article_config.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($article['titre']) ?> - MonBlog</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome pour les icônes -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../../assets/css/article_style.css">
    <style>
        
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center w-100">
                <a href="index.php" class="navbar-brand">DMS</a>
                <a href="index.php" class="back-btn">
                    <i class="fas fa-arrow-left"></i>
                    <span class="d-none d-sm-inline">Retour</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Article principal -->
    <div class="container">
        <div class="article-container">
            <!-- En-tête avec média -->
            <div class="article-header">
                <?php 
                $media_path = htmlspecialchars($article['media']);
                
                // Gestion des chemins (même logique que dans index.php)
                if (!preg_match('/^https?:\/\//', $media_path)) {
                    if (!str_starts_with($media_path, '/') && !str_starts_with($media_path, './')) {
                        $media_path = './uploads/' . $media_path;
                    }
                }
                
                $file_extension = strtolower(pathinfo($media_path, PATHINFO_EXTENSION));
                $video_extensions = ['mp4', 'webm', 'ogg', 'avi', 'mov'];
                $image_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
                ?>
                
                <?php if (in_array($file_extension, $video_extensions)): ?>
                    <video class="article-media" controls muted preload="metadata" playsinline>
                        <source src="<?= $media_path ?>" type="video/<?= $file_extension === 'mov' ? 'mp4' : $file_extension ?>">
                        <div class="media-placeholder">
                            <div>
                                <i class="fas fa-video" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                                <p>Vidéo non disponible</p>
                            </div>
                        </div>
                    </video>
                <?php elseif (in_array($file_extension, $image_extensions) || empty($file_extension)): ?>
                    <img src="<?= $media_path ?>" 
                         alt="<?= htmlspecialchars($article['titre']) ?>" 
                         class="article-media"
                         loading="lazy"
                         onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="media-placeholder" style="display: none;">
                        <div>
                            <i class="fas fa-image" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                            <p>Image non disponible</p>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="media-placeholder">
                        <div>
                            <i class="fas fa-file" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                            <p>Format non supporté</p>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- Overlay avec titre -->
                <div class="article-overlay">
                    <h1 class="article-title"><?= htmlspecialchars($article['titre']) ?></h1>
                    <div class="article-meta">
                        <span><i class="fas fa-calendar"></i> Publié récemment</span>
                        <span><i class="fas fa-heart"></i> <?= $article['likes'] ?? 0 ?> likes</span>
                    </div>
                </div>
            </div>

            <!-- Contenu de l'article -->
            <div class="article-content">
                <div class="article-description">
                    <?= nl2br(htmlspecialchars($article['description'])) ?>
                </div>
            </div>

            <!-- Section likes -->
            <div class="like-section">
                <button class="like-btn <?= in_array($article['id_article'], $liked_articles) ? 'liked' : '' ?>" 
                        onclick="likeArticle(<?= $article['id_article'] ?>, this)">
                    <i class="fas fa-heart"></i>
                    <span><?= in_array($article['id_article'], $liked_articles) ? 'Aimé' : 'J\'aime' ?></span>
                </button>
                <div class="like-count" id="likes-<?= $article['id_article'] ?>">
                    <?= $article['likes'] ?? 0 ?> likes
                </div>
            </div>
        </div>

        <!-- Articles similaires -->
        <?php if (!empty($related_articles)): ?>
        <div class="related-section">
            <h2 class="section-title">Articles similaires</h2>
            <div class="row g-4">
                <?php foreach ($related_articles as $related): ?>
                    <div class="col-12 col-md-4">
                        <a href="article.php?id=<?= $related['id_article'] ?>" class="related-card d-block">
                            <div class="related-media">
                                <?php 
                                $related_media = htmlspecialchars($related['media']);
                                if (!preg_match('/^https?:\/\//', $related_media)) {
                                    if (!str_starts_with($related_media, '/') && !str_starts_with($related_media, './')) {
                                        $related_media = '../uploads/' . $related_media;
                                    }
                                }
                                
                                $related_extension = strtolower(pathinfo($related_media, PATHINFO_EXTENSION));
                                ?>
                                
                                <?php if (in_array($related_extension, $video_extensions)): ?>
                                    <video muted>
                                        <source src="<?= $related_media ?>" type="video/<?= $related_extension ?>">
                                    </video>
                                <?php else: ?>
                                    <img src="<?= $related_media ?>" 
                                         alt="<?= htmlspecialchars($related['titre']) ?>"
                                         onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="media-placeholder" style="display: none;">
                                        <div>
                                            <i class="fas fa-image"></i>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="related-content">
                                <h3 class="related-title"><?= htmlspecialchars($related['titre']) ?></h3>
                                <p class="related-description"><?= htmlspecialchars($related['description']) ?></p>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Bouton WhatsApp -->
    <a href="https://wa.me/22990010184" 
       class="whatsapp-btn" target="_blank">
        <i class="fab fa-whatsapp"></i>
        <span class="d-none d-sm-inline">Contactez-nous</span>
    </a>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Fonction pour gérer les likes
        function likeArticle(articleId, button) {
            if (button.classList.contains('liked')) {
                return;
            }
            
            button.classList.add('loading');
            const heart = button.querySelector('i');
            const text = button.querySelector('span');
            heart.classList.add('pulse');
            
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
                    button.classList.add('liked');
                    text.textContent = 'Aimé';
                    document.getElementById(`likes-${articleId}`).textContent = `${data.likes} likes`;
                    
                    setTimeout(() => {
                        heart.classList.remove('pulse');
                        button.classList.remove('loading');
                    }, 600);
                } else {
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

        // Animation d'apparition
        document.addEventListener('DOMContentLoaded', function() {
            const articleContainer = document.querySelector('.article-container');
            const relatedCards = document.querySelectorAll('.related-card');
            
            // Animation du container principal
            articleContainer.style.opacity = '0';
            articleContainer.style.transform = 'translateY(30px)';
            articleContainer.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
            
            setTimeout(() => {
                articleContainer.style.opacity = '1';
                articleContainer.style.transform = 'translateY(0)';
            }, 100);
            
            // Animation des cartes liées
            relatedCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
                
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 500 + (index * 100));
            });
        });
    </script>
</body>
</html>