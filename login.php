
<?php

   

include_once('configs/connexion.php');

    $query = 'SELECT * FROM user';
    $userStatement = $pdo -> prepare($query);
    $userStatement -> execute();
    $users = $userStatement -> fetchAll(PDO::FETCH_ASSOC);
?>

<?php
    if (isset($_POST['pseudo'])) {
        foreach ($users as $user) {
        if ($user['pseudo'] === $_POST['pseudo']) {
            $loggedUser = [
                'pseudo' => $user['pseudo']
            ];

                $_SESSION['LOGGED_USER'] = $loggedUser['pseudo'];
        }
    }
    if (!isset($loggedUser)) {
        $name = htmlspecialchars($_POST['pseudo']);
            $insertStatement = $pdo -> prepare("INSERT INTO user (pseudo) VALUES (:pseudo)");
            $insertStatement -> execute([
                'pseudo' => $name,
            ]);
    }
}
?>

<?php
if (isset($_SESSION['LOGGED_USER'])) {
    $loggedUser = [
        'pseudo' => $_SESSION['LOGGED_USER'],
    ];
}
?>

<?php if (!isset($loggedUser)): ?>
    <form action="../index.php" method="POST">
        <h2>Connectez-vous </h2>
    <?php if(isset($errorMessage)) : ?>
        <div>
            <?php echo($errorMessage); ?>
        </div>
    <?php endif; ?>
    <div>
        <label for="pseudo">Pseudo</label>
        <input type="text" name="pseudo" id="pseudo">
    </div>
    <input type="submit" value="Envoyer">
    </form>
<?php endif; ?>


