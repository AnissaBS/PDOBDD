<?php
    $dsn = 'mysql:host=localhost;dbname=maBase';
    $user = '';
    $password = 'tata';

    try {
        $cnx = new PDO($dsn, $user, $password);
    } catch(PDOException $e){
        echo "Une erreur est survenue !";
    }

?>