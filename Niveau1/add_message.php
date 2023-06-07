<?php
    
     $connected_id = true;
    if(!empty($_POST)){

        echo  $message = $_POST['message'];
    }

    if(!empty($_FILES)){
        
        $file = $_FILES['file']; // Récupère les informations sur le fichier téléchargé
        $fileName = $file['name']; // Nom du fichier
        $fileTmpPath = $file['tmp_name']; // Chemin temporaire du fichier sur le serveur
        $fileSize = $file['size']; // Taille du fichier
        $fileType = $file['type']; // Type de fichier
        // print_r($_FILES);

        // Déplacer le fichier téléchargé vers un emplacement permanent
        $uploadDirectory = 'Images_upload';
       
        $targetFilePath = $uploadDirectory . $fileName;
        move_uploaded_file($fileTmpPath, $targetFilePath);  

        // Afficher l'image
        echo '<img src="' . $targetFilePath . '" alt="Image téléchargée">';
    }

    //il reste ajout des messages à la base des données 
    // la condition de login
    
?>