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




if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pseudo']) && isset($_POST['message'])) {
    // Récupération des données du formulaire
    $pseudo = $_POST['pseudo'];
    $message = $_POST['message'];

    // Vérifier si l'utilisateur existe dans la table "user"
    $query = "SELECT id FROM user WHERE pseudo = :pseudo";
    $statement = $pdo->prepare($query);
    $statement->execute(['pseudo' => $pseudo]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    // Si l'utilisateur n'existe pas, l'insérer dans la table "user"
    if (!$user) {
        $query = "INSERT INTO user (pseudo) VALUES (:pseudo)";
        $statement = $pdo->prepare($query);
        $statement->execute(['pseudo' => $pseudo]);

        // Récupérer l'ID de l'utilisateur nouvellement inséré
        $user_id = $pdo->lastInsertId();
    } else {
        // Utiliser l'ID de l'utilisateur existant
        $user_id = $user['id'];
    }

    // Insérer le commentaire dans la table "comments" en utilisant l'ID de l'utilisateur
    $query = "INSERT INTO comments (id_user, content) VALUES (:id_user, :content)";
    $statement = $pdo->prepare($query);
    $statement->execute([
        'id_user' => $user_id,
        'content' => $message
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
 <!-- Bouton pour ouvrir la modal des commentaires -->
 <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#commentsModal">
        Afficher les commentaires
    </button>

    <!-- Modal pour afficher les commentaires -->
    <div class="modal fade" id="commentsModal" tabindex="-1" aria-labelledby="commentsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="commentsModalLabel">Commentaires</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="comments-container">
                        <?php
                        $query = "SELECT * FROM comments INNER JOIN user ON comments.id_user = user.id";
                        $statement = $pdo->prepare($query);
                        $statement->execute();
                        $comments = $statement->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($comments as $comment) {
                         echo '<div class="comment">';
                            echo '<div class="comment-header">';
                            echo '<br>';
                                echo '<div class="comment-author">' . $comment['pseudo'] . '</div>';
                                echo '<br>';
                                echo '<div class = "comment-text">' . $comment['content'] . '</div>';
                            echo '</div>';
                        echo '</div>';

                        }

                        
                        ?>
                       
                            
                          
                   
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</body>

</html>