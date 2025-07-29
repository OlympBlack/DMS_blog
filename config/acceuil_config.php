<?php
include('config.php');


// Récupération des articles
$stmt = $pdo->query("SELECT * FROM articles ORDER BY id_article DESC");
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Gestion des likes (AJAX)
if ($_POST['action'] ?? '' === 'like') {
    $article_id = $_POST['article_id'] ?? 0;
    
    // Vérifier si l'utilisateur a déjà liké (simple vérification par session)
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

if (!isset($_SESSION)) session_start();
$liked_articles = $_SESSION['liked_articles'] ?? [];
?>