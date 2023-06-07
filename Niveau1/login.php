<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>ReSoC - Connexion</title> 
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="style.css"/>
    </head>
    <body>
        <header>
        <?php include("header.php") ?>
        </header>

        <div id="wrapper" >

            <aside>
                <h2>Présentation</h2>
                <p>Bienvenue sur notre réseau social.</p>
            </aside>
            <main>
                <article>
                    <h2>Connexion</h2>
                    <?php
                    $motDePasseUser=isset($_POST['motpasse']) ? $_POST['motpasse']:"mdp non renseigné";
                    echo "mot de passe non encrypté: ".$motDePasseUser;
                    ?>
                    </br>
                    <?php

                    $motDePasseUser=isset($_POST['motpasse']) ? md5($_POST['motpasse']):'';

                    echo "UserVar: ".$_SESSION['userVar'];
                    ?>
                    </br>
                    <?php
                    
                    echo "userpassword: ".$_SESSION['userpassword'];
                    
                    ?>
                    </br>
                    <?php
                    echo "motpasse: ".$motDePasseUser;
                    ?>  
                    </br>
                    <?php
                    
                    echo "Statut de Connection:".session_status();
                    ?>  
                    </br>
                    <?php
                    echo "variable connectionstatus: ".$connection_status;
                    ?>  
                    </br>
                    <?php
                    

                    if ( $connection_status!="loggedOut" && (! $_SESSION['userVar'] || $_SESSION['userpassword']  != $motDePasseUser))
                    {
                        echo "La connexion a échoué. ";
                        
                    } else if ($_SESSION['userVar'] && $_SESSION['userpassword']  == $motDePasseUser)
                    {
                        echo "Votre connexion est un succès : " . $_SESSION['useralias'] . ".";
                        $connection_status="loggedIn";
                        // Etape 7 : Se souvenir que l'utilisateur s'est connecté pour la suite
                        // documentation: https://www.php.net/manual/fr/session.examples.basic.php
                    }

                    //Deconnexion
                    // $connection_status= isset($_GET['status']) ? $_GET['status'] : "logged in" ;
                    // if ($connection_status == "logout"){
                    //     session_unset();
                    // }


                    
                    ?>
                    </br>
                    <?php
                    echo $connection_status;

                    // echo $_SESSION['connected_id'];
                    ?>    

                    <form action="login.php" method="post">
                        <input type='hidden'name='???' value='achanger'>
                        <dl>
                            <dt><label for='email'>E-Mail</label></dt>
                            <dd><input type='email'name='email'></dd>
                            <dt><label for='motpasse'>Mot de passe</label></dt>
                            <dd><input type='password'name='motpasse'></dd>
                        </dl>
                        <input type='submit'>
                    </form>
                    <p>
                        Pas de compte?
                        <a href='registration.php'>Inscrivez-vous.</a>
                    </p>

                </article>
            </main>
        </div>
    </body>
</html>
