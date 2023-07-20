<?php
// Assurez-vous que la session est démarrée avant tout envoi de contenu HTML
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id_user']) || !isset($_SESSION['pseudo'])) {
    // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: index.php");
    exit;
}

// Inclure le fichier de connexion à la base de données
include 'configs/connexion.php';

// Requête SQL pour récupérer les informations de l'utilisateur connecté
$query = "SELECT * FROM user WHERE id = :id";
$statement = $pdo->prepare($query);
$statement->execute(['id' => $_SESSION['id_user']]);
$user = $statement->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compte</title>
</head>
<body>
    <h1>Bienvenue sur votre compte, <?php echo $_SESSION['pseudo']; ?>!</h1>
    <h2>Vos informations :</h2>
    <p>Nom d'utilisateur : <?php echo $user['pseudo']; ?></p>
    <!-- Ajoutez ici d'autres informations que vous souhaitez afficher sur le compte -->

    <a href="logout.php">Déconnexion</a>
</body>
</html>
