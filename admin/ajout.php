<?php

    session_start();

    //refuser l'accès sans être authentifier
    if(!isset($_SESSION['admin'])){
        header('Location: login.php');
    }


    $server = 'localhost';
    $dbname = 'blog';
    $username = 'root';
    $password = '';

    try{
        $conn = new PDO("mysql:host=$server;dbname=$dbname", $username, $password);
    }
    catch(PDOException $e){ // Correction ici
        echo 'Erreur'. $e->getMessage();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $titre = $_POST['title'];
        $description = $_POST['description'];
        $media = $_FILES['media'];

        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["media"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Vérifier si le fichier existe déjà
        /*if (file_exists($target_file)) {
            $error = "Désolé, le fichier existe déjà.";
            $uploadOk = 0;
        }

        // Vérifier la taille du fichier (facultatif)
        if ($_FILES["media"]["size"] > 500000) {
            $error = "Désolé, votre fichier est trop volumineux.";
            $uploadOk = 0;
        }

        // Autoriser certains formats de fichier (facultatif)
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" && $imageFileType != "mp4" && $imageFileType != "webm" && $imageFileType != "avi" ) {
            $error = "Désolé, seuls les formats JPG, JPEG, PNG, GIF, MP4, WEBM & AVI sont autorisés.";
            $uploadOk = 0;
        }*/

        // Vérifier si $uploadOk est à 0 à cause d'une erreur
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["media"]["name"]);

        if ($uploadOk == 0) {
            $error = "Désolé, votre fichier n'a pas été téléversé.";
        } else {
            if (move_uploaded_file($_FILES["media"]["tmp_name"], $target_file)) {
                $media_name = basename($_FILES["media"]["name"]);
                $req = $conn->prepare("INSERT INTO articles(media, description, titre) VALUES(?, ?, ?)");
                $req->execute([$media_name, $description, $titre]);
                $success = "Élément ajouté avec succès !";
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Désolé, une erreur est survenue lors du téléversement de votre fichier.";
            }
        }

    }
?>                                           
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Élément - Administration</title>
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
            max-width: 800px;
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

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .back-btn {
            background: #f8f9fa;
            border: 1px solid #e1e8ed;
            color: #666;
            padding: 10px 12px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .back-btn:hover {
            background: #e9ecef;
            transform: translateX(-2px);
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
            background: linear-gradient(135deg, #28a745, #20c997);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .breadcrumb {
            color: #666;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .form-header {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            padding: 25px 30px;
            border-bottom: 1px solid #e1e8ed;
        }

        .form-title {
            font-size: 20px;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .form-subtitle {
            color: #666;
            font-size: 14px;
        }

        .form-content {
            padding: 40px 30px;
        }

        .form-group {
            margin-bottom: 30px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .required {
            color: #dc3545;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e1e8ed;
            border-radius: 12px;
            font-size: 16px;
            font-family: inherit;
            transition: all 0.3s ease;
            background: #fafbfc;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
            line-height: 1.6;
        }

        .form-help {
            font-size: 12px;
            color: #6c757d;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .char-counter {
            position: absolute;
            bottom: -25px;
            right: 0;
            font-size: 12px;
            color: #6c757d;
        }

        .char-counter.warning {
            color: #fd7e14;
        }

        .char-counter.danger {
            color: #dc3545;
        }

        .form-actions {
            padding: 25px 30px;
            background: #f8f9fa;
            border-top: 1px solid #e1e8ed;
            display: flex;
            gap: 15px;
            justify-content: flex-end;
        }

        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            text-align: center;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
        }

        .loading-spinner {
            width: 16px;
            height: 16px;
            border: 2px solid transparent;
            border-top: 2px solid currentColor;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            display: none;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: none;
            align-items: center;
            gap: 10px;
        }

        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: none;
            align-items: center;
            gap: 10px;
        }

        .form-tips {
            background: #e7f3ff;
            border: 1px solid #b3d7ff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
        }

        .tips-title {
            font-weight: 600;
            color: #0056b3;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .tips-list {
            list-style: none;
            color: #0056b3;
            font-size: 14px;
        }

        .tips-list li {
            margin-bottom: 5px;
            padding-left: 20px;
            position: relative;
        }

        .tips-list li::before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #28a745;
            font-weight: bold;
        }

        .media-upload-area {
            border: 2px dashed #e1e8ed;
            border-radius: 12px;
            background: #fafbfc;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .media-upload-area:hover {
            border-color: #667eea;
            background: #f8f9ff;
        }

        .media-upload-area.dragover {
            border-color: #667eea;
            background: #f0f4ff;
            transform: scale(1.02);
        }

        .upload-placeholder {
            padding: 40px 20px;
            text-align: center;
            color: #666;
        }

        .upload-icon {
            margin-bottom: 15px;
            color: #ccc;
        }

        .upload-placeholder h4 {
            margin-bottom: 10px;
            color: #333;
            font-weight: 600;
        }

        .upload-placeholder p {
            font-size: 13px;
            margin-bottom: 5px;
            color: #888;
        }

        .select-btn {
            margin-top: 15px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .select-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .media-preview {
            padding: 20px;
        }

        .preview-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e1e8ed;
        }

        .file-name {
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .remove-btn {
            background: #ff6b6b;
            color: white;
            border: none;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .remove-btn:hover {
            background: #ff5252;
            transform: scale(1.1);
        }

        .preview-content {
            margin-bottom: 15px;
            border-radius: 8px;
            overflow: hidden;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 200px;
        }

        .preview-content img {
            max-width: 100%;
            max-height: 300px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .preview-content video {
            max-width: 100%;
            max-height: 300px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .file-info {
            display: flex;
            gap: 20px;
            font-size: 12px;
            color: #666;
            background: #f8f9fa;
            padding: 10px 15px;
            border-radius: 6px;
        }

        .file-info span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .upload-progress {
            display: none;
            margin-top: 10px;
        }

        .progress-bar {
            width: 100%;
            height: 6px;
            background: #e1e8ed;
            border-radius: 3px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            width: 0%;
            transition: width 0.3s ease;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .form-content {
                padding: 30px 20px;
            }

            .form-actions {
                flex-direction: column;
                padding: 20px;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
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