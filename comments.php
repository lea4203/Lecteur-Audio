<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>

<body>
    <?php include_once("configs/connexion.php"); 




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $pseudo = $_POST['pseudo'];
    $message = $_POST['message'];

    // Insertion des données dans la base de données

    $query = "INSERT INTO user (pseudo, comments) VALUES (:pseudo, :comments)";
    $statement = $pdo->prepare($query);
    $statement->execute([
        'pseudo' => $pseudo,
        'comments' => $message // Utiliser la variable $message ici
    ]);
}

?>

<!-- Bouton pour ouvrir la modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
    Ecrire un commentaire
</button>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nouveau message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="chat-form" method="POST">
                    <div class="form-group">
                        <label for="pseudo">Pseudo</label>
                        <input type="text" name="pseudo" id="pseudo" class="form-control" placeholder="Votre pseudo">
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea name="message" id="message" cols="30" rows="10" class="form-control"
                            placeholder="Votre message"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="comments-container">

<?php
    // Récupération des commentaires depuis la base de données
    $query = "SELECT * FROM user";
    $statement = $pdo->query($query);
    $comments = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($comments as $comment) {
        echo "<div class='col-12'>";
        echo "<div class='card'>";
        echo "<div class='card-body'>";
        echo "<h5 class='card-title'>" . $comment['pseudo'] . "</h5>";
        echo "<p class='card-text'>" . $comment['comments'] . "</p>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
    ?>
</div>


    </div>
    </div>

</div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
</body>

</html>