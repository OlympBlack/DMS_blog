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
            line-height: 1.7;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem;
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .back-btn {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .article-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin: 2rem auto;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .article-header {
            position: relative;
            height: 400px;
            overflow: hidden;
        }

        .article-media {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .article-media video {
            background: #000;
        }

        .article-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0,0,0,0.8));
            color: white;
            padding: 3rem 2rem 2rem;
        }

        .article-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .article-meta {
            display: flex;
            align-items: center;
            gap: 2rem;
            font-size: 1rem;
            opacity: 0.9;
        }

        .article-content {
            padding: 3rem;
        }

        .article-description {
            font-size: 1.2rem;
            line-height: 1.8;
            color: #555;
            margin-bottom: 2rem;
        }

        .like-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 2rem 3rem;
            border-top: 1px solid rgba(0,0,0,0.1);
            background: rgba(248, 249, 250, 0.5);
        }

        .like-btn {
            background: linear-gradient(45deg, #ff6b6b, #ff8e8e);
            border: none;
            color: white;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 12px 25px;
            border-radius: 50px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
        }

        .like-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 107, 107, 0.4);
        }

        .like-btn.liked {
            background: linear-gradient(45deg, #ff1493, #ff69b4);
            box-shadow: 0 4px 15px rgba(255, 20, 147, 0.3);
        }

        .like-count {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--dark-color);
        }

        .related-section {
            margin-top: 4rem;
            padding: 0 15px;
        }

        .section-title {
            text-align: center;
            font-size: 2rem;
            font-weight: 700;
            color: white;
            margin-bottom: 2rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .related-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .related-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
            color: inherit;
        }

        .related-media {
            height: 200px;
            overflow: hidden;
        }

        .related-media img,
        .related-media video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .related-card:hover .related-media img,
        .related-card:hover .related-media video {
            transform: scale(1.1);
        }

        .related-content {
            padding: 1.5rem;
        }

        .related-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .related-description {
            color: #6c757d;
            font-size: 0.9rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
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

        .media-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            text-align: center;
        }

        @media (max-width: 768px) {
            .article-title {
                font-size: 1.8rem;
            }
            
            .article-header {
                height: 250px;
            }
            
            .article-content {
                padding: 2rem 1.5rem;
            }
            
            .like-section {
                padding: 1.5rem;
                flex-direction: column;
                gap: 1rem;
            }
            
            .whatsapp-btn {
                bottom: 20px;
                right: 20px;
                padding: 12px 20px;
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