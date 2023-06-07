<!-- récupère l'URL de la page et stocke dans la variable $url -->
<?php  
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
         $url = "https://";   
    else  
         $url = "http://";   
    // Append the host(domain name, ip) to the URL.   
    $url.= $_SERVER['HTTP_HOST'];   
    
    // Append the requested resource location to the URL   
    $url.= $_SERVER['REQUEST_URI'];    
  ?>   



<!-- Etape 6 du Notions : traitement du formulaire like -->
<?php 
    //appel à la BDD
    include("dataBaseRequest.php");

  
    
    $enCoursDeTraitement = isset($_POST[$post['id']]);
    if ($enCoursDeTraitement)
    {
        $followed = $post['user_id'];
        $following = $_SESSION['connected_id'];
        $postid = $post['id'];
        

        //Requête SQL
        $lInstructionSql = "INSERT INTO likes (id, user_id, post_id) VALUES (NULL,  $following, $postid) ;";
        echo $lInstructionSql;

        // Execution
        $ok = $mysqli->query($lInstructionSql);
        if ( ! $ok)
        {
            echo "ça marche pas  " ;
        } else
        {
            echo "ok ça roule";
            header( "location:".$url );
        }
    };
    ?>   




<!-- Création de l'article -->
<article>
    <h3> 
        <time><?php echo $post['created'] ?></time>
    </h3>
    <address>
        <a href="wall.php?user_id=<?php echo $post['user_id']?>"><?php echo $post['author_name'] ?></a>
    </address>
    <div>
        <p><?php echo $post['content'] ?></p>
    </div>
    <footer>
        <small> <?php echo '♥'.$post['like_number'] ?></small>
        <?php
            $tagArray=array();
            $stringToBreak=$post['taglist'];
            $tagArray=explode("," , $stringToBreak);
            foreach( $tagArray as $element){
        ?>    
            <a href=""> <?php echo '#'.$element ?></a>
        <?php
        }?>
        <!-- Formulaire like -->
        <?php  
            if ($post['user_id'] != $_SESSION['connected_id']) 
            {   
        ?>
            <form action="" method="post">
                <button name=<?php echo $post['id'] ?> >♥</button> 
                <!-- <?php var_dump($post) ?> -->
            </form>
        <?php
            } else echo "vous ne pouvez pas liker votre propre message."
        ?>
    </footer>
</article>