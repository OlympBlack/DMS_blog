<?php

    session_start();

    //refuser l'accès sans être authentifier
    if(!isset($_SESSION['admin'])){
        header('Location: login.php');
    }

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

    if(isset($_SESSION['admin'])){
        $nomAdmin = $_SESSION['admin'];
    }

    // Sélection des données
    $stmt = $conn->prepare("SELECT * FROM articles  ORDER BY id_article DESC");
    $stmt->execute();
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Pagination
    $itemsPerPage = 5;  
    $totalItems = count($articles);
    $totalPages = ceil($totalItems / $itemsPerPage);
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $currentPage = max(1, min($currentPage, $totalPages)); // Assurer que la page courante est valide
    $startItem = ($currentPage - 1) * $itemsPerPage;
    $endItem = min($startItem + $itemsPerPage, $totalItems);
    $articlesToShow = array_slice($articles, $startItem, $itemsPerPage);
    // Génération des numéros de page
    $pageNumbers = [];
    for ($i = 1; $i <= $totalPages; $i++) {
        $pageNumbers[] = $i;
    }


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord - Administration</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            background: white;
            padding: 25px 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            color: #333;
            font-size: 28px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
            color: #666;
            font-size: 14px;
        }

        .avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .table-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .table-header {
            padding: 25px 30px;
            border-bottom: 1px solid #e1e8ed;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-title {
            font-size: 20px;
            font-weight: 600;
            color: #333;
        }

        .add-btn {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .add-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        .table-content {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f8f9fa;
            padding: 20px 30px;
            text-align: left;
            font-weight: 600;
            color: #555;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 20px 30px;
            border-bottom: 1px solid #f0f0f0;
            color: #333;
        }

        tr:hover {
            background: #f8f9ff;
            transition: background 0.3s ease;
        }

        .title-cell {
            font-weight: 600;
            color: #333;
            max-width: 250px;
        }

        .description-cell {
            color: #666;
            max-width: 350px;
            line-height: 1.5;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .action-btn {
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .edit-btn {
            background: #e3f2fd;
            color: #1976d2;
        }

        .edit-btn:hover {
            background: #bbdefb;
            transform: translateY(-1px);
        }

        .delete-btn {
            background: #ffebee;
            color: #d32f2f;
        }

        .delete-btn:hover {
            background: #ffcdd2;
            transform: translateY(-1px);
        }

        .view-btn {
            background: #e8f5e8;
            color: #2e7d32;
        }

        .view-btn:hover {
            background: #c8e6c9;
            transform: translateY(-1px);
        }

        .pagination {
            padding: 25px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #e1e8ed;
            background: #f8f9fa;
        }

        .pagination-info {
            color: #666;
            font-size: 14px;
        }

        .pagination-controls {
            display: flex;
            gap: 5px;
            align-items: center;
        }

        .page-btn {
            padding: 8px 12px;
            border: 1px solid #e1e8ed;
            background: white;
            color: #666;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .page-btn:hover {
            background: #f0f0f0;
            border-color: #ccc;
        }

        .page-btn.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-color: #667eea;
        }

        .page-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .empty-state {
            text-align: center;
            padding: 60px 30px;
            color: #999;
        }

        .empty-icon {
            width: 60px;
            height: 60px;
            background: #f0f0f0;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ccc;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .table-header {
                flex-direction: column;
                gap: 15px;
                align-items: stretch;
            }

            .table-content {
                font-size: 14px;
            }

            th, td {
                padding: 15px 20px;
            }

            .pagination {
                flex-direction: column;
                gap: 15px;
            }
        }
        .logout-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 15px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.3s ease;
            margin: 20px auto;
        }

        .logout-btn:hover {
            background: linear-gradient(135deg, #5a67d8, #6b46c1);
        }

        .logout-btn svg {
            flex-shrink: 0;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>
                <div class="header-icon">
                    <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/>
                    </svg>
                </div>
                Tableau de Bord
            </h1>
            <div class="user-info">
                <span>
                    <?php
                        if(isset($nomAdmin)){
                            echo "Bienvenue, ". htmlspecialchars($nomAdmin);
                        }
                        else{
                            echo "Bienvenue, Admninstrateur";
                        }
                    ?>
                </span>
                <button class="logout-btn" onclick="window.location.href='logout.php'">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M16 13v-2H7V8l-5 4 5 4v-3h9zM20 3h-8v2h8v14h-8v2h8a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2z"/>
                    </svg>
                    Déconnexion
                </button>

            </div>
        </div>

        <div class="table-container">
            <div class="table-header">
                <h2 class="table-title">Gestion des Éléments</h2>
                <button class="add-btn" onclick="addItem()">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                    </svg>
                    Ajouter
                </button>
            </div>
            
            <div class="table-content">
                <table id="dataTable">
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <!-- Afficher les element dans une table depuis la base de donnée -->
                        <?php if (count($articlesToShow) > 0): ?>
                            <?php foreach ($articlesToShow as $article): ?>
                                <tr>
                                    <td class="title-cell"><?php echo htmlspecialchars($article['titre']); ?></td>
                                    <td class="description-cell"><?php echo htmlspecialchars($article['description']); ?></td>  
                                    <td class="action-buttons">
                                        <button class="action-btn edit-btn" onclick="editItem(<?php echo $article['id_article']; ?>)">
                                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                            </svg>
                                            <a href="modifier.php?id=<?php echo $article['id_article']; ?>" style="color: inherit; text-decoration: none;">Modifier</a>
                                        </button>

                                        <button class="action-btn delete-btn" onclick="deleteItem(<?php echo $article['id_article']; ?>)">
                                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M6 19c0 .55.45 1 1 1h10c.55 0 1-.45 1-1V7H6v12zm5-14h4v2h-4V5zm8-2H5c-.55 0-1 .45-1 1v2h16V4c0-.55-.45-1-1-1zM5 8h14v11c0 .55-.45 1-1 1H6c-.55 0-1-.45-1-1V8z"/>
                                            </svg>
                                            <a href="supprimer.php?id=<?php echo $article['id_article']; ?>" style="color: inherit; text-decoration: none;">Supprimer</a>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="empty-state">
                                    <div class="empty-icon
                                        <svg width="60" height="60" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                                            <path d="M16.59 7.41L15.17 6l-4.58 4.59L15.17 15l1.41-1.41L11.83 12z"/>
                                        </svg>
                                    </div>
                                    <p>Aucun élément trouvé.</p>
                                </td>
                            </tr>
                        <?php endif; ?>

                    </tbody>
                </table>
            </div>

            <div class="pagination">
                <div class="pagination-info">
                    Affichage de <span id="startItem">1</span> à <span id="endItem">5</span> sur <span id="totalItems">15</span> éléments
                </div>
            
                    <div class="pagination-controls">
                        <?php if ($currentPage > 1): ?>
                            <a style ="text-decoration: none;" class="page-btn" href="?page=<?php echo $currentPage - 1; ?>">
                                &lt;
                            </a>
                        <?php endif; ?>
                        <?php foreach ($pageNumbers as $num): ?>
                            <a style ="text-decoration: none;" class="page-btn<?php if ($num == $currentPage) echo ' active'; ?>" href="?page=<?php echo $num; ?>">
                                <?php echo $num; ?>
                            </a>
                        <?php endforeach; ?>
                        <?php if ($currentPage < $totalPages): ?>
                            <a class="page-btn" style ="text-decoration: none;" href="?page=<?php echo $currentPage + 1; ?>">
                                &gt;
                            </a>
                        <?php endif; ?>
                    </div>
             </div>
        </div>
    </div>
    
</body>
<script>
  
//fonction pour ajouter un nouvel élément
function addItem() {
    window.location.href = 'ajout.php';
}

</script>
</html>