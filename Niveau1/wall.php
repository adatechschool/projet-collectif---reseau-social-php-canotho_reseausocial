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
                    SELECT posts.content, posts.created, users.alias as author_name, posts.user_id,
                    COUNT(likes.id) as like_number, GROUP_CONCAT(DISTINCT tags.label) AS taglist 
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
                    <form  method="post">
                        <button name="follow">S'abonner</button>
                    
                    </form>




                <!-- Ajout formulaire de Nosy 
                    
                <form action="add_message.php" method="post">
                    <textarea name="message" placeholder="Écrivez votre message ici"></textarea>
                    <input type="submit" value="Publier">
                </form> -->





            </main>
        </div>
    </body>
</html>
