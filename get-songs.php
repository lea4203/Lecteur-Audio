<?php 

include_once('configs/connexion.php');

function getMusics($pdo) {

$query = "SELECT * FROM chanson";
$statement = $pdo->prepare($query);
$statement->execute();
$musics = $statement->fetchAll(PDO::FETCH_ASSOC);

$songs = [];
foreach ($musics as $music) {
    $song = [
        'id' => $music['id'],
        'name' => $music['name'],
        'author' => $music['author'],
        'file' => $music['file'],
        'images' => $music['images'],
    ];
    array_push($songs, $song);



}
return $songs;
}


$songs = getMusics($pdo);
header('Content-Type: application/json');
echo json_encode(array('songs' => $songs));

?>
