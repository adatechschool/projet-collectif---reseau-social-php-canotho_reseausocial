<?php
    
    include("authentification.php") ;
    
    function clearCurrentSession(){
        session_unset();
        session_destroy();
        session_write_close();
        setcookie(session_name(),'',0,'/');
    } 
    
    global $connection_status;
    $connection_status = isset($_GET['sessionstatus']) ? $_GET['sessionstatus'] : "notLoggedOut" ;

    if ($connection_status=="loggedOut") {
        clearCurrentSession();
        $_SESSION['userVar'] = 'user';
        $_SESSION['userpassword'] = 'pwd';
        $_SESSION['useralias'] = 'alias';
        // $_SESSION['connected_id']='userId';
    }
?>

<a href='admin.php'><img src="resoc.jpg" alt="Logo de notre réseau social"/></a>
<?php if(isset($_SESSION['connected_id'])==1 && $connection_status!="loggedOut"){ ?>
    <nav id="menu">
        <a href="news.php">Actualités</a>
        <a href="wall.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Mur</a>
        <a href="feed.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Flux</a>
        <a href="tags.php?tag_id=1">Mots-clés</a>  
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
<?php } ?>
