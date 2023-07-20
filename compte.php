<?php
    include_once('configs/connexion.php');
    include("header.php");
    if (!isset($_SESSION['LOGGED_USER'])){
        include_once('login.php');
    }
    else {
    $query = 'SELECT * FROM user where pseudo = "' . $_SESSION['LOGGED_USER'] . '"';
    $userStatement = $pdo -> prepare($query);
    $userStatement -> execute();
    $user = $userStatement -> fetch(PDO::FETCH_ASSOC);
    ?>
    <div class="d-flex flex-column align-items-center">
    <h1>Mon compte</h1>
    <h2>Votre pseudo : <?php echo($user['pseudo']) ?></h2> 
    

    <form action="traitement/modif-compte.php" method="post" class="d-flex flex-column text-center">
    <label for="pseudo">
    <input type="text" name="pseudo" id="pseudo" value="<?php echo($user['pseudo']);?>">
    <input type="submit" value="modifier">
    </form>
    
<h4> Vous voulez vous déconnecter ? </h4>
<a href="logout.php">Se déconnecter</a>
</div>
<?php } ?>