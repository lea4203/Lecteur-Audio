<?php

session_start();
include_once 'configs/connexion.php'
       // Démarrer la session
       
        
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <title>QuizzMaster</title>
</head>

<body>
    <?php include("configs/connexion.php"); ?>
    <?php include("header.php"); ?>
    <?php include("login.php"); ?>
   


    <div class="audio-player">
    <div class="cover">
        <img src="cover.jpg" alt="Cover">
    </div>
    <div class="info">
        <div id="audio-title">Song Title</div>
        <div id="audio-artist">Artist Name</div>
    </div>
    <div class="controls">
        <button id="play-pause-button"><i class="fas fa-play"></i></button>
        <button id="previous-button"><i class="fas fa-step-backward"></i></button>
        <button id="next-button"><i class="fas fa-step-forward"></i></button>
        <button id="random-button"><i class="fas fa-random"></i></button>
    </div>
    <audio id="audio-player"  src="musics/Djadja-Dinaz-Capitaine.mp3" type="audio/mp3">
    </audio>
    <audio id="audio-player-1"src="musics/Gaulois-et-Ninho-Jolie .mp3" type="audio/mp3">
    </audio>
    <audio id="audio-player-2" src="musics/Lomepal-Descrendo.mp3" type="audio/mp3">
    </audio>
    <audio id="audio-player-3"  src="musics/Nocif-Hamza.mp3" type="audio/mp3">
    </audio>
    <audio id="audio-player-4"  src="musics/Tiakola-Meuda.mp3" type="audio/mp3">
    </audio>
    <audio id="audio-player-5"src="musics/Zola-amber.mp3" type="audio/mp3">
    </audio>
    <audio id="audio-player-6" src="musics/📀 Danakil-Marley [Official Audio].mp3" type="audio/mp3">
    </audio>
    <audio id="audio-player-7" src="musics/Ces-femmes-là.mp3" type="audio/mp3">
    </audio>
    <audio id="audio-player-8" src="musics/Generique-pokemon.mp3" type="audio/mp3">
    </audio>
    <audio id="audio-player-9" src="musics/Iko-Iko-ma-bestie.mp3" type="audio/mp3">
    </audio>
    <audio id="audio-player-10" src="musics/J'irai-ou-tu-iras.mp3" type="audio/mp3">
    </audio>
    <audio id="audio-player-11" src="musics/Je-m'apelle-funny-bear.mp3" type="audio/mp3">
    </audio>
    <audio id="audio-player-12" src="musics/Mulan-Comme-un-homme.mp3" type="audio/mp3">
    </audio>

</div>
    <?php include ("comments.php"); ?>
<script>
  <?php include("js/audio-player.js"); ?>
</script>
</body>





