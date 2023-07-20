function initializeAudioPlayer() {
    const audioPlayer = document.getElementById('audio-player');
    const playPauseButton = document.getElementById('play-pause-button');
    const previousButton = document.getElementById('previous-button');
    const nextButton = document.getElementById('next-button');
    const randomButton = document.getElementById('random-button');
    const repeatButton = document.getElementById('repeat-button');
    const audioTitle = document.getElementById('audio-title');
    const audioArtist = document.getElementById('audio-artist');
    const coverImage = document.querySelector('.cover img');
  
    let currentSongIndex = 0;
    let songs = [];
    let isRepeatOn = false;
  
    // Charger les chansons à partir de PHP (JSON)
    function loadSongs() {
      // Remplacez l'URL ci-dessous par l'URL de votre fichier PHP
      const url = 'get-songs.php';
  
      fetch(url)
        .then(response => response.json())
        .then(data => {
          songs = data.songs;
  
          if (songs.length > 0) {
            loadSong(currentSongIndex);
          }
        })
        .catch(error => {
          console.error('Erreur lors du chargement des chansons:', error);
        });
    }
  
    // Charger une chanson
    function loadSong(index) {
      const song = songs[index];
      audioPlayer.src = song.file;
      audioTitle.textContent = song.name;
      audioArtist.textContent = song.author;
      coverImage.src = song.images; // Afficher l'image de la chanson
    }
  
    // Lecture ou pause de la chanson en cours
    function togglePlayPause() {
      if (audioPlayer.paused) {
        audioPlayer.play();
        playPauseButton.innerHTML = '<i class="fas fa-pause"></i>';
      } else {
        audioPlayer.pause();
        playPauseButton.innerHTML = '<i class="fas fa-play"></i>';
      }
    }
  
    // Chanson suivante
    function playNextSong() {
      currentSongIndex = (currentSongIndex + 1) % songs.length;
      loadSong(currentSongIndex);
      audioPlayer.play();
      playPauseButton.innerHTML = '<i class="fas fa-pause"></i>';
    }
  
    // Chanson précédente
    function playPreviousSong() {
      currentSongIndex = (currentSongIndex - 1 + songs.length) % songs.length;
      loadSong(currentSongIndex);
      audioPlayer.play();
      playPauseButton.innerHTML = '<i class="fas fa-pause"></i>';
    }


     // Chanson aléatoire
     function playRandomSong() {
      const randomIndex = Math.floor(Math.random() * songs.length);
      currentSongIndex = randomIndex;
      loadSong(currentSongIndex);
      audioPlayer.play();
      playPauseButton.innerHTML = '<i class="fas fa-pause"></i>';
  }

  function toggleRepeat() {
    isRepeatOn = !isRepeatOn;
    audioPlayer.loop = isRepeatOn; // Activer ou désactiver la propriété loop de l'élément audio
    repeatButton.classList.toggle('active', isRepeatOn); // Ajouter la classe 'active' pour indiquer l'état de répétition
}

// Fonction pour jouer la chanson suivante ou arrêter la lecture
function playNextOrStop() {
  if (currentSongIndex === songs.length - 1) {
      // Dernière chanson de la liste, arrêter la lecture
      audioPlayer.pause();
      audioPlayer.currentTime = 0; // Remettre la lecture au début
      playPauseButton.innerHTML = '<i class="fas fa-play"></i>';
  } else {
      // Jouer la chanson suivante
      currentSongIndex++;
      loadSong(currentSongIndex);
      audioPlayer.play();
      playPauseButton.innerHTML = '<i class="fas fa-pause"></i>';
  }
}
 // Événement pour détecter la fin de la chanson et appliquer le fondu de sortie
 audioPlayer.addEventListener('timeupdate', function () {
  // Durée de la chanson
  const duration = audioPlayer.duration;
  // Temps restant de la chanson
  const timeRemaining = duration - audioPlayer.currentTime;

  // Si le temps restant est inférieur à 5 secondes, appliquer le fondu de sortie
  if (timeRemaining <= 5) {
      // Calculer le volume à appliquer en fonction du temps restant
      const fadeOutVolume = timeRemaining / 5; // Réduit progressivement le volume à zéro sur les 5 dernières secondes

      // Appliquer le volume
      audioPlayer.volume = fadeOutVolume;
  }
});
 // Événement pour détecter la fin de la chanson
 audioPlayer.addEventListener('ended', function () {
  // Réinitialiser le volume à 1 après la fin de la chanson
  audioPlayer.volume = 1;

  // Jouer la chanson suivante ou arrêter la lecture
  playNextOrStop();
});

  
    // Événements des boutons de contrôle
    playPauseButton.addEventListener('click', togglePlayPause);
    nextButton.addEventListener('click', playNextSong);
    previousButton.addEventListener('click', playPreviousSong);
    randomButton.addEventListener('click', playRandomSong); 
    repeatButton.addEventListener('click', toggleRepeat); // Ajout de l'événement pour le bouton de répétition

  
    // Charger les chansons au chargement de la page
    loadSongs();
  }
  
  // Initialisation du lecteur audio
  initializeAudioPlayer();

