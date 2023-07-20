function initializeAudioPlayer() {
    const audioPlayer = document.getElementById('audio-player');
    const playPauseButton = document.getElementById('play-pause-button');
    const previousButton = document.getElementById('previous-button');
    const nextButton = document.getElementById('next-button');
    const audioTitle = document.getElementById('audio-title');
    const audioArtist = document.getElementById('audio-artist');
    const coverImage = document.querySelector('.cover img');
  
    let currentSongIndex = 0;
    let songs = [];
  
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
  
    // Événements des boutons de contrôle
    playPauseButton.addEventListener('click', togglePlayPause);
    nextButton.addEventListener('click', playNextSong);
    previousButton.addEventListener('click', playPreviousSong);
  
    // Charger les chansons au chargement de la page
    loadSongs();
  }
  
  // Initialisation du lecteur audio
  initializeAudioPlayer();

