<?php
    try 
    {
        $pdo = new PDO('mysql:host=127.0.0.1;dbname=Lecteur_Audio;charset=utf8', 'root');
    }
            
    catch(Exception $e) 
    {
        die('Erreur : ' .$e->getMessage());
    }
?>