<!-- <?php
if (isset($_SESSION['connected_id'])) {
    // L'utilisateur est connecté, vous pouvez récupérer l'ID de l'utilisateur
    $connected_id = $_SESSION['connected_id'];

    // Vérifier si le formulaire a été soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupérer le contenu du message à partir des données du formulaire
        $message = $_POST['message'];

        // Effectuer le traitement pour ajouter le message à la base de données
        // ...

        // Rediriger l'utilisateur vers la page wall.php après l'ajout du message
        header("Location: wall.php?user_id=$connected_id");
        exit();
    } else {
        // Le formulaire n'a pas été soumis, afficher un message d'erreur ou une autre action si nécessaire
    }
} else {
    // L'utilisateur n'est pas connecté, rediriger vers la page de connexion
    header("Location: login.php");
    exit();
}
?> -->