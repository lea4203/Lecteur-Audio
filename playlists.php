<?php
// Assurez-vous d'inclure le fichier de connexion à votre base de données
include_once('configs/connexion.php');

// Vérifier si le formulaire de création de playlist est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $playlistName = $_POST['playlist_name'];
    $selectedSongs = $_POST['selected_songs'];

    // Créer une nouvelle playlist
    $stmt = $pdo->prepare('INSERT INTO playlists (name) VALUES (:name)');
    $stmt->execute(['name' => $playlistName]);
    $playlistId = $pdo->lastInsertId();

    // Ajouter les chansons sélectionnées à la playlist
    foreach ($selectedSongs as $songId) {
        $stmt = $pdo->prepare('INSERT INTO playlists_to_chanson (id_playlist, id_chanson) VALUES (:id_playlist, :id_chanson)');
        $stmt->execute(['id_playlist' => $playlistId, 'id_chanson' => $songId]);
    }
}

// Récupérer les chansons disponibles
$stmt = $pdo->prepare('SELECT * FROM chanson');
$stmt->execute();
$songs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les playlists avec les chansons associées
$stmt = $pdo->prepare('SELECT playlists.id, playlists.name AS playlist_name, chanson.name AS chanson_name
          FROM playlists
          LEFT JOIN playlists_to_chanson ON playlists.id = playlists_to_chanson.id_playlist
          LEFT JOIN chanson ON playlists_to_chanson.id_chanson = chanson.id
          ORDER BY playlists.id');

$stmt->execute();
$playlists = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les chansons associées à chaque playlist
foreach ($playlists as &$playlist) {
    $stmt = $pdo->prepare('SELECT chanson.name FROM chanson
                          INNER JOIN playlists_to_chanson ON chanson.id = playlists_to_chanson.id_chanson
                          WHERE playlists_to_chanson.id_playlist = :playlist_id');
    $stmt->execute(['playlist_id' => $playlist['id']]);
    $chansons_associees = $stmt->fetchAll(PDO::FETCH_COLUMN);
    $playlist['chansons_associees'] = $chansons_associees;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Le reste du code HTML reste inchangé -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<div class="container mt-5">
        <h1>Créer une nouvelle playlist</h1>
        <form method="POST">
            <div class="mb-3">
                <input type="text" class="form-control" id="playlist-name" name="playlist_name"
                    placeholder="Nom de la playlist" required>
            </div>
            <h2>Liste des chansons disponibles</h2>
            <?php if (!empty($songs)): ?>
                <?php foreach ($songs as $song): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="selected_songs[]"
                            value="<?php echo $song['id']; ?>" id="song-<?php echo $song['id']; ?>">
                        <label class="form-check-label" for="song-<?php echo $song['id']; ?>">
                            <?php echo $song['name']; ?> - <?php echo $song['author']; ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucune chanson disponible pour le moment.</p>
            <?php endif; ?>
            <button type="submit" class="btn btn-primary">Créer</button>
        </form>

        <h2>Liste des playlists avec les chansons associées</h2>
        <?php if (!empty($playlists)): ?>
            <?php foreach ($playlists as $playlist): ?>
                <h3><?php echo $playlist['playlist_name']; ?></h3>
                <?php if (!empty($playlist['chansons_associees'])): ?>
                    <select class="form-select">
                        <?php foreach ($playlist['chansons_associees'] as $chanson): ?>
                            <option><?php echo $chanson; ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php else: ?>
                    <p>Aucune chanson associée à cette playlist.</p>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucune playlist avec des chansons associées pour le moment.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
