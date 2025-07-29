<?php
include('config.php');

// Récupérer l'ID de l'article
$article_id = $_GET['id'] ?? 0;

if (!$article_id) {
    header('Location: index.php');
    exit;
}

// Gestion des likes (AJAX)
if ($_POST['action'] ?? '' === 'like') {
    if (!isset($_SESSION)) session_start();
    $liked_articles = $_SESSION['liked_articles'] ?? [];
    
    if (!in_array($article_id, $liked_articles)) {
        // Ajouter le like
        $stmt = $pdo->prepare("UPDATE articles SET likes = COALESCE(likes, 0) + 1 WHERE id_article = ?");
        $stmt->execute([$article_id]);
        
        // Marquer comme liké
        $_SESSION['liked_articles'][] = $article_id;
        
        // Retourner le nouveau nombre de likes
        $stmt = $pdo->prepare("SELECT COALESCE(likes, 0) as likes FROM articles WHERE id_article = ?");
        $stmt->execute([$article_id]);
        $result = $stmt->fetch();
        
        echo json_encode(['success' => true, 'likes' => $result['likes']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Déjà liké']);
    }
    exit;
}

// Récupérer l'article
$stmt = $pdo->prepare("SELECT * FROM articles WHERE id_article = ?");
$stmt->execute([$article_id]);
$article = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$article) {
    header('Location: index.php');
    exit;
}

// Récupérer les articles similaires (3 derniers articles différents)
$stmt = $pdo->prepare("SELECT * FROM articles WHERE id_article != ? ORDER BY id_article DESC LIMIT 3");
$stmt->execute([$article_id]);
$related_articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!isset($_SESSION)) session_start();
$liked_articles = $_SESSION['liked_articles'] ?? [];
?>