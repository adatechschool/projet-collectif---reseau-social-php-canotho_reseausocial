

<?php
    
    include("authentification.php") ;
    
    function clearCurrentSession(){
        session_unset();
        session_destroy();
        session_write_close();
        setcookie(session_name(),'',0,'/');
    }
    
?>

<a href='admin.php'><img src="resoc.jpg" alt="Logo de notre réseau social"/></a>
<nav id="menu">
    <?php 
        
        global $connection_status;
        $connection_status = isset($_GET['sessionstatus']) ? $_GET['sessionstatus'] : "notLoggedOut" ;
        echo "connection_status: ". $connection_status;
    ?>
        </br>
    <?php
        echo "GET['sessionsstatuts']: ".isset($_GET['sessionstatus']);
        if ($connection_status!="loggedOut") {
    ?>
        <a href="news.php">Actualités</a>
        <a href="wall.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Mur</a>
        <a href="feed.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Flux</a>
        <a href="tags.php?tag_id=1">Mots-clés</a>
 
    <?php }
        else{
            clearCurrentSession();
            $_SESSION['userVar'] = 'user';
            $_SESSION['userpassword'] = 'pwd';
            $_SESSION['useralias'] = 'alias';
            $_SESSION['connected_id']='userId';
        }
    ?>
        </br>
    <?php
        echo "Session Status: ".session_status()
    ?>
</nav>
<nav id="user">
    <a href="#">▾ Profil</a>
    <ul>
        <li><a href="settings.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Paramètres</a></li>
        <li><a href="login.php">Log in</a></li>
        <li><a href="followers.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Mes suiveurs</a></li>
        <li><a href="subscriptions.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Mes abonnements</a></li>
        <li><a href="login.php?sessionstatus=loggedOut">Log out</a></li>
    </ul>   
</nav>
