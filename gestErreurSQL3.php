<?php
    $dsn = 'mysql:host=localhost;dbname=maBase';
    $user = 'root';
    $password = '';

    try{
        $cnx = new PDO($dsn, $user, $password);
        $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Ici, l'attribut des erreurs est défini en mode affichage ERRMODE_WARNING
        // echo "Tout s'est bien passé!";
    }catch(PDOException $e){
        echo " Une erreur est survenue !";
    }

    $sql = "select * from client";

    try{
        $rs_req = $cnx->query($sql);
        while($donnees=$rs_req->fetch(PDO::FETCH_OBJ)){
            echo '<pre>';
            print_r($donnees);
            echo '</pre>';
        }
    }catch(PDOException $e){
        echo "Une erreur est survenue !";
    }

?>