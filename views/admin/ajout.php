<?php
 include('../../config/ajout_config.php');
?>                                 
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Élément - Administration</title>

    <link rel="stylesheet" href="../../assets/css/ajout_style.css">
    <style>
        
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-left">
                <a href="acceuil.php" class="back-btn" onclick="goBack()">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
                    </svg>
                </a>
                <div>
                    <h1>
                        <div class="header-icon">
                            <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                            </svg>
                        </div>
                        Ajouter un Élément
                    </h1>
                    <div class="breadcrumb">
                        <span>Tableau de bord</span>
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/>
                        </svg>
                        <span>Ajouter</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-container">

            <div class="form-content">
                <?php
                    if(isset($error)) {
                        echo '<div class="error-message" style="display:block;">'.$error.'</div>';
                    }
                    if(isset($success)) {
                        echo '<div class="success-message" style="display:block;">'.$success.'</div>';
                    }
                ?>

                <form id="addItemForm" method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>' enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">
                            Titre <span class="required">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="title" 
                            name="title" 
                            maxlength="100"
                            placeholder="Saisissez le titre de l'élément"
                        >
                        <div class="form-help">
                            <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                            </svg>
                            Le titre doit être unique et descriptif
                        </div>
                        <div class="char-counter" id="titleCounter">0/100</div>
                    </div>

                    <div class="form-group">
                        <label for="description">
                            Description <span class="required">*</span>
                        </label>
                        <textarea 
                            id="description" 
                            name="description" 
                            maxlength="500"
                            placeholder="Décrivez en détail cet élément, son objectif et ses caractéristiques principales..."
                        ></textarea>
                        <div class="form-help">
                            <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                            </svg>
                            Fournissez une description complète et informative
                        </div>
                        <div class="char-counter" id="descriptionCounter">0/500</div>
                    </div>

                    <div class="form-group">
                        <label for="media">
                            Média (Image ou Vidéo)
                        </label>
                        <div class="media-upload-area" id="mediaUploadArea">
                            <input 
                                type="file" 
                                id="media" 
                                name="media" 
                                accept="image/*,video/*"
                                style="display: none;"
                            >
                            <div class="upload-placeholder" id="uploadPlaceholder">
                                <div class="upload-icon">
                                    <svg width="40" height="40" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                                    </svg>
                                </div>
                                <h4>Glissez-déposez ou cliquez pour sélectionner</h4>
                                <p>Images: JPG, PNG, GIF, WEBP (max 10MB)</p>
                                <p>Vidéos: MP4, WEBM, AVI (max 50MB)</p>
                                <button type="button" class="select-btn" onclick="document.getElementById('media').click()">
                                    Choisir un fichier
                                </button>
                            </div>
                            <div class="media-preview" id="mediaPreview" style="display: none;">
                                <div class="preview-header">
                                    <span class="file-name" id="fileName"></span>
                                    <button type="button" class="remove-btn" onclick="removeMedia()">
                                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="preview-content" id="previewContent"></div>
                                <div class="file-info" id="fileInfo"></div>
                            </div>
                        </div>
                        <div class="form-help">
                            <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                            </svg>
                            Ajoutez une image ou vidéo pour illustrer votre élément (optionnel)
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="goBack()">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11 18h2v-2h-2v2zm1-16C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                            </svg>
                            Annuler
                        </button>
                        <button type="submit" class="btn btn-primary" id="submitBtn" form="addItemForm">
                            <div class="loading-spinner" id="loadingSpinner"></div>
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24" id="submitIcon">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                            </svg>
                            <span id="submitText">Ajouter l'élément</span>
                        </button>
                    </div>
                </form>
            </div>

            
        </div>
    </div>

    
</body>
</html>