




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <?php
    include 'configs/connexion.php';


    // Vérifier si le formulaire a été soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupérer les données du formulaire
        $pseudo = $_POST['pseudo'];
      

       

    

            // Requête SQL pour récupérer les informations de l'utilisateur
            $query = "SELECT * FROM user WHERE pseudo = :pseudo";
            $statement = $pdo->prepare($query);
            $statement->execute(['pseudo' => $pseudo]);
            $user = $statement->fetch(PDO::FETCH_ASSOC);

          if ($user) {
         

                // Stocker les informations de l'utilisateur dans la session
                $_SESSION['id_user'] = $user['id'];
                $_SESSION['pseudo'] = $user['pseudo'];

            } else {
                $error = "Le nom d'utilisateur ou le mot de passe est incorrect.";
            }
        }
    ?>

    <!-- Formulaire de connexion -->
    <form action="index.php" method="POST">
        <label for="pseudo">Nom d'utilisateur:</label>
        <input type="text" name="pseudo" id="pseudo" required><br>

        <button type="submit">Se connecter</button>
    </form>
          <!-- Afficher le message de connexion -->
    <?php if (isset($_SESSION['user_id']) && isset($_SESSION['pseudo'])) { ?>
        <p>Vous êtes connecté en tant que <?php echo $_SESSION['pseudo']; ?></p>
    <?php } ?>
    

</body>
</html>

