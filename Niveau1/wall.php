<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>ReSoC - Mur</title> 
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="style.css"/>
    </head>
    <body>
        <header>
            <?php include("header.php") ?>
        </header>

        <div id="wrapper">
            <?php
            /**
             * Etape 1: Le mur concerne un utilisateur en particulier
             * La première étape est donc de trouver quel est l'id de l'utilisateur
             * Celui ci est indiqué en parametre GET de la page sous la forme user_id=...
             * Documentation : https://www.php.net/manual/fr/reserved.variables.get.php
             * ... mais en résumé c'est une manière de passer des informations à la page en ajoutant des choses dans l'url
             */
            // session_start();
            $userId =intval($_GET['user_id']);
            // $_SESSION["userId"] = intval($_GET['user_id']);
            ?>

            <?php  
                if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
                $url = "https://";   
                else  
                $url = "http://";   
                // Append the host(domain name, ip) to the URL.   
                $url.= $_SERVER['HTTP_HOST'];
                // Append the requested resource location to the URL   
                $url.= $_SERVER['REQUEST_URI'];    

            /**
             * Etape 2: se connecter à la base de donnée
             */
                include('dataBaseRequest.php');
            ?>

            <aside>
                <?php
                /**
                 * Etape 3: récupérer le nom de l'utilisateur
                 */                
                $laQuestionEnSql = "SELECT * FROM users WHERE id= '$userId' ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                $user = $lesInformations->fetch_assoc();
                //@todo: afficher le résultat de la ligne ci dessous, remplacer XXX par l'alias et effacer la ligne ci-dessous
                //  echo "<pre>" . print_r($user, 1) . "</pre>";
                ?>
                <img src="user.jpg" alt="Portrait de l'utilisatrice"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez tous les message de l'utilisatrice : <?php echo $user['alias'] ?>
                       (n° <?php echo $userId  ?>)
                    </p>
                    
                </section>
            </aside>
            <main>
                <?php
                /**
                 * Etape 3: récupérer tous les messages de l'utilisatrice
                 */
                $laQuestionEnSql = "
                    SELECT posts.id, posts.content, posts.created, users.alias as author_name, posts.user_id,
                    COUNT(DISTINCT likes.id) as like_number, GROUP_CONCAT(DISTINCT tags.label) AS taglist 
                    FROM posts
                    JOIN users ON  users.id=posts.user_id
                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
                    LEFT JOIN likes      ON likes.post_id  = posts.id 
                    WHERE posts.user_id='$userId' 
                    GROUP BY posts.id
                    ORDER BY posts.created DESC  
                    ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                if ( ! $lesInformations)
                {
                    echo("Échec de la requete : " . $mysqli->error);
                }

                /**
                 * Etape 4: @todo Parcourir les messsages et remplir correctement le HTML avec les bonnes valeurs php
                 */
                while ($post = $lesInformations->fetch_assoc())
                {

                    // echo "<pre>" . print_r($post, 1) . "</pre>";
                                 
                   include('article.php');
               } ?>







                <!-- Etape 5 du Notions : formulaire d'abonnement -->
                <?php 
                    // * TRAITEMENT DU FORMULAIRE
                    // Vérifier si on est en train d'afficher ou de traiter le formulaire
                    // si on recoit un champs email rempli il y a une chance que ce soit un traitement
                    $enCoursDeTraitement = isset($_POST['follow']);
                    if ($enCoursDeTraitement)
                    {
                        $followed = $_GET["user_id"];
                        $following = $_SESSION['connected_id'];

                        //Construction de la requete
                        $lInstructionSql = "INSERT INTO followers  (id, followed_user_id, following_user_id) VALUES (NULL,  $followed, $following);";
                        echo $lInstructionSql;
                        // Execution
                        $ok = $mysqli->query($lInstructionSql);
                        if ( ! $ok)
                        {
                            echo "ça marche pas  " ;
                        } else
                        {
                            echo "ok ça roule";
                        }
                    }
                ?>   

                <!-- Formulaire follow -->

                

<!-- Vérification si on est abonné-->
<?php
    
    $followed = $_GET["user_id"];
    $following = $_SESSION['connected_id'];
    
    $laQuestionEnSql2 = "SELECT * FROM followers WHERE followed_user_id= $followed AND following_user_id= $following";
    $lesInformations2 = $mysqli->query($laQuestionEnSql2);
    $followdata = $lesInformations2->fetch_assoc();
    
    if (isset($followdata)){
        echo "<pre> coucou IF" . print_r($followdata, 1) . "</pre>";
        $_SESSION['toggleState'] = "ON";
    }
    else {
        echo "vous n'êtes pas abonné.";
        echo "<pre> coucou ELSE" . print_r($followdata, 1) . "</pre>";
        $_SESSION['toggleState'] = "OFF";
    }
    ?>



<!-- Gestion du switch -->
<?php

if (isset($_POST['toggle'])) {
    $followed = $_GET["user_id"];
    $following = $_SESSION['connected_id'];
    
    
    
    if (isset($_SESSION['toggleState']) && $_SESSION['toggleState'] === 'ON') {
      $_SESSION['toggleState'] = 'OFF';
      $lInstructionSql = "DELETE FROM followers WHERE followed_user_id = $followed AND following_user_id = $following;";
      echo $lInstructionSql;
    } else {
        $_SESSION['toggleState'] = 'ON';
        $lInstructionSql = "INSERT INTO followers (followed_user_id, following_user_id)
                          SELECT $followed, $following
                          WHERE NOT EXISTS (
                          SELECT $followed
                          FROM followers
                          WHERE followed_user_id = $followed AND following_user_id = $following
                          );";
        echo $lInstructionSql;
        // Execution
    }
    $ok = $mysqli->query($lInstructionSql);
    if ( ! $ok)
    {
        echo "ça marche pas  " ;
    } else
    {
        echo "ok ça roule";
    }
    
    // Perform any actions or updates based on the new state
    // For demonstration purposes, we'll simply display the new state
    echo 'New state: ' . $_SESSION['toggleState'];
}

?>

<!-- Formulaire switch -->
<?php  
    if ($_SESSION['connected_id'] != $_GET["user_id"])
    {   
        ?>
    <form method="POST">
        <button type="submit" name="toggle">
            <?php echo isset($_SESSION['toggleState']) && $_SESSION['toggleState'] === 'OFF' ? 'Follow' : 'Unfollow'; ?>
        </button>
    </form>
    <?php
        } else echo "vous ne pouvez pas vous abonner à vous-même";
        
        ?>









                <article>
                    <h2>Poster un message</h2>
                    <?php
                    /**
                     * BD
                     */
                    include("dataBaseRequest.php");
                    
                    $enCoursDeTraitement = isset($_POST['message']);
                    echo "issetmessage: ".$enCoursDeTraitement;
                    ?>
                    </br>
                    <?php
                    echo "post[message]:".empty($_POST['message']);
                    if ($enCoursDeTraitement && ! empty($_POST['message']))
                    {
                        // on ne fait ce qui suit que si un formulaire a été soumis.
                        // Etape 2: récupérer ce qu'il y a dans le formulaire @todo: c'est là que votre travaille se situe
                        // observez le résultat de cette ligne de débug (vous l'effacerez ensuite)
                        // echo "<pre>" . print_r($_POST, 1) . "</pre>";
                        // et complétez le code ci dessous en remplaçant les ???
                        $authorId = $userId;
                        $postContent = $_POST['message'];


                        //Etape 3 : Petite sécurité
                        // pour éviter les injection sql : https://www.w3schools.com/sql/sql_injection.asp
                        $authorId = intval($mysqli->real_escape_string($authorId));
                        $postContent = $mysqli->real_escape_string($postContent);
                        //Etape 4 : construction de la requete
                        $lInstructionSql = "INSERT INTO posts "
                                . "(id, user_id, content, created, parent_id) "
                                . "VALUES (NULL, "
                                . $authorId . ", "
                                . "'" . $postContent . "', "
                                . "NOW(), "
                                . "NULL);"
                                ;
                        echo $lInstructionSql;
                        // Etape 5 : execution
                        $ok = $mysqli->query($lInstructionSql);
                        ?>
                        </br>
                        <?php
                        echo "ok: ".$ok;
                        ?>
                        <?php
                        if ( ! $ok)
                        {
                            echo "Impossible d'ajouter le message: " . $mysqli->error;
                        } else
                        {
                            echo "Message posté en tant que :" . $authorId;
                            $postContent="";
                            header( "location:".$url );
                            
                        }
                    }


            ?>                     












<form action="" method="post">
    <input type='hidden' name='???' value='achanger'>
    <dl>
        <dt><label for='message'>Message</label></dt>
        <dd><textarea name='message'></textarea></dd>
    </dl>
    <input type='submit'>
</form>               
</article>
<!-- </main> -->

                





            </main>
        </div>
    </body>
</html>
