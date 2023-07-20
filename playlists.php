<?php
include_once('configs/connexion.php');

// Vérifier si le formulaire de création de playlist est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $playlistName = $_POST['playlist_name'];

    // Étape 1: Insérer la nouvelle playlist avec l'ID de l'utilisateur
    $userId = 1; // Remplacez cette valeur par l'ID réel de l'utilisateur
    $chansonId = 1; // Remplacez cette valeur par l'ID réel de la chanson
    $query = "INSERT INTO playlists (name, id_user ,id_chanson) VALUES (:name, :id_user , :id_chanson)";
    $statement = $pdo->prepare($query);
    $statement->execute([
        'name' => $playlistName,
        'id_user' => $userId,
        'id_chanson' => $chansonId
    ]);

    header("Location: playlists.php");
    exit;
}

// Récupérer les chansons
$query = "SELECT * FROM chanson";
$statement = $pdo->prepare($query);
$statement->execute();
$songs = $statement->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les playlists
$query = "SELECT * FROM playlists";
$statement = $pdo->prepare($query);
$statement->execute();
$playlists = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Le reste du code HTML reste inchangé -->
</head>
<body>
    <div class="container mt-5">
        <h1>Créer une nouvelle playlist</h1>
        <form method="POST">
            <div class="form-group">
                <input type="text" class="form-control" id="playlist-name" name="playlist_name" placeholder="Nom de la playlist" required>
            </div>
            <button type="submit" class="btn btn-primary">Créer</button>
        </form>

        <!-- Afficher la liste des chansons -->
        <h2>Liste des chansons</h2>
        <ul>
            <?php foreach ($songs as $song): ?>
                <li><?php echo $song['name']; ?> - <?php echo $song['author']; ?></li>
            <?php endforeach; ?>
        </ul>

        <!-- Afficher la liste des playlists -->
        <h2>Liste des playlists</h2>
        <ul>
            <?php foreach ($playlists as $playlist): ?>
                <li><?php echo $playlist['name']; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>

