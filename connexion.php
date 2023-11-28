<?php
    $dsn = 'mysql:host=localhost;dbname=maBase';
    $user = 'root';
    $password = '';
    $cnx = new PDO($dsn, $user, $password);
    
    $sql = "select * from client";
    $rs_req = $cnx->query($sql);
    while($donnees=$rs_req->fetch()){
        echo '<pre>';
        print_r($donnees);
        echo '</pre>';
    }
?>