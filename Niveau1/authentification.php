<?php 
 session_start();

 /**
  * TRAITEMENT DU FORMULAIRE
  */
 // Etape 1 : vérifier si on est en train d'afficher ou de traiter le formulaire
 // si on recoit un champs email rempli il y a une chance que ce soit un traitement
 $enCoursDeTraitement = isset($_POST['email']);
 if ($enCoursDeTraitement)
 {
     // on ne fait ce qui suit que si un formulaire a été soumis.
     // Etape 2: récupérer ce qu'il y a dans le formulaire @todo: c'est là que votre travaille se situe
     // observez le résultat de cette ligne de débug (vous l'effacerez ensuite)
    //  echo "<pre>" . print_r($_POST, 1) . "</pre>";
     // et complétez le code ci dessous en remplaçant les ???
     $emailAVerifier = $_POST['email'];
     $passwdAVerifier = $_POST['motpasse'];


     //Etape 3 : Ouvrir une connexion avec la base de donnée.
     include("dataBaseRequest.php");
     //Etape 4 : Petite sécurité
     // pour éviter les injection sql : https://www.w3schools.com/sql/sql_injection.asp
     $emailAVerifier = $mysqli->real_escape_string($emailAVerifier);
     $passwdAVerifier = $mysqli->real_escape_string($passwdAVerifier);
     // on crypte le mot de passe pour éviter d'exposer notre utilisatrice en cas d'intrusion dans nos systèmes
     $passwdAVerifier = md5($passwdAVerifier);
     // NB: md5 est pédagogique mais n'est pas recommandée pour une vraies sécurité
     //Etape 5 : construction de la requete
     $lInstructionSql = "SELECT * "
             . "FROM users "
             . "WHERE "
             . "email LIKE '" . $emailAVerifier . "'"
             ;
     // Etape 6: Vérification de l'utilisateur
     $res = $mysqli->query($lInstructionSql);
     $user = $res->fetch_assoc();
     $_SESSION['userVar'] = isset($user) ? implode(" ",$user) : "user";
     $_SESSION['userpassword'] = isset($user['password']) ? $user["password"] : "pwd";
     $_SESSION['useralias'] = isset($user['alias']) ? $user['alias'] : "alias";
     $_SESSION['connected_id']=isset($user['id']) ? $user['id']: "userId";
    

     
     
    //  if ( $user And $user['password'] == $passwdAVerifier)
    //  {
    //      $_SESSION['connected_id']=$user['id'];
    //  }
 }
?>