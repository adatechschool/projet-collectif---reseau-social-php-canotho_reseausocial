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
                    echo "UserVar: ".$_SESSION['userVar'];
                    echo "Password: ".$_SESSION['userpassword'];
                    echo "PasswordDB: ".$_SESSION['motdepasse'];
                    if ( ! $_SESSION['userVar'] OR $_SESSION['userpassword']  != $_SESSION['motdepasse'])
                    {
                        echo "La connexion a échouée. ";
                        
                    } else
                    {
                        echo "Votre connexion est un succès : " . $_SESSION['useralias'] . ".";
                        // Etape 7 : Se souvenir que l'utilisateur s'est connecté pour la suite
                        // documentation: https://www.php.net/manual/fr/session.examples.basic.php
                    }

                    //Deconnexion
                    $connection_status= isset($_GET['status']) ? $_GET['status'] : "logged in" ;
                    if ($connection_status == "logout"){
                        session_unset();
                    }
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
