<?php
 include('../../config/dashboard_config.php');
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord - Administration</title>

    <link rel="stylesheet" href="../../assets/css/dashboard_style.css">
    <style>
        

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