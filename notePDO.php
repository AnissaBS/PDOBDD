<?php

/*
    . La classe PDO
    Le rôle de la classe PDO est de servir d'intercae d'accès à une base de données, pour votre site internet.
    Objectif :
        - découvrir les fonctionnalités de cettte classe PDO.
        - sélectionner, insérer, modifier et supprimer des données.

        -- Qu'est-ce que le PDO ? --
    PDO signifie PHP Date Objects. PDO est une extension PHP orientée objet incluse depuis la verson 5.1 de PHP, dont le rôle est de servir d'interface d'accès à une base de données.
    L'objet PDO permet donc de communiquer une base de données, et ceci peu importe le type de SGBD (MySQL, Oracle, etc...).

        -- Connexion à une base de données --
    Auparavant, pour nous connecter à une base de données, nous utilision la fonction mysql_connect().
    Cette connexion st devenue totalement obsolète avec l'arrivée de PHP 7. Elle a été remplacée par deux nouvelles extensions : PDO et MySQLi.

    . PDO pour se connecter à une base de données
        -- Définition des variables de connexion --
    Nous allons commencer par définir nos variables de connexion :
    */
            $dsn = 'mysql:host=localhost;dbname=maBase';
            $user = 'root';
            $password = '';
    
    /*      Explication :
            - $dsn : contient le type de la base de données (mysql), l'adresse du serveur (ici localhost) ainsi que le nom de la bdd (ici maBase).
            - $user : contient le login de la connexion à la bdd (ici root).
            - $password : contient le mot de passe de connexion à la bdd (ici rien).

        -- Initialisation de l'objet PDO --
    Une fois nos vairables de connexion définies, nous devons ensuite initialiser l'objet PDO, comme ceci :
    */
            $cnx = new PDO($dsn, $user, $password);
    /*
            Explication : Nous initalisons l'objet PDO et nous le stockons dans une variable nommée $cnx.
            $cnx contient tous les paramètres de connexion de notre bdd.

        CONCLUSION
        Nous venons de créer un objet PDO pour nous connecter à notre base de données mysql.

    . Gestion d'une errur éventuelle de connexion
    Si pour une raison quelconque, une erreur de connexion à la base de données survient, nous allons gérer cette erreur et non la subir. En effet, en cas d'erreur, MySQL renvoie un message d'erreur, et ce message peut contenir des données sensibles.

    Exemple  : nous allons reprendre nos variables de connexion à notre base de données et nous allons modifier le login de la variable $user et ajouter un mot de passe à notre variable $password afin de générer une ereur de connexion. Pous, nous initialiserons l'objet PDO.
    */
            $dsn = 'mysql:host=localhost;dbname=maBase';
            $user = 'toto';
            $password = 'tata';
            $cnx = new PDO($dsn, $user, $password);

    /* Ensuite, nous lançons la page dans le browser. Nous nous attendonc à une erreur, puisque le couple user/password n'est pas correct.
    Nous pouvons observer une faille de sécurité indéniable. Le couple user/passcord apparait clairement.

    Pour remédier à cela, nous allons utiliser les blocs TRY/CATCH.

        -- Le couple TRY/CATCH --
    Ce couple va nous permettre de pouvoir gérer une erreur de connexion à la base de données et d'en personnaliser le message.

        -- Le principe de fonctionnement --
    TRY va tenter de se connecter à l base de données et s'il y a une erreur, CATCH fera en sorte de renvoyer un message d'erreur que nous allons personnaliser. Cette erreur sera déclarée sous la forme d'une exception.
    */
            try {
                $cnx = new PDO($dsn, $user, $password);
            } catch(PDOException $e){
                echo "Une erreur est survenue !";
            }
    /*
    Nous relançons la page dans notre navigateur. Cette fois, le message d'erreur qui s'affichera sera ceci : "Une erreur est survenue !".

    CONCLUSION
    Vous venez d'apprendre à vous connecter à une base de donnée en utilisant l'objet PDO de PHP.
    Nb : En  cas de problème, tout ce qui se trouve à l'intérieur du TRY sera stoppé au profit de ce qui se trouve à l'intérieur du CATCH. Et si tout va bien, alors seulement ce qui se trouve à l'intérieur du TRY sera exécuté.


    . Afficher des données avec PDO 
        -> Ecriture de la requête
            $sql = select * from client

        -> Exécution de la requête
            Pour exécuter cette requête, nous récupérons l'objet PDO et nous effectuons une requête query. Nous stockons cette requête dans une variable nommée $rs_req.
    */
                $rs_req = $cnx->query($sql);
    /*
    Nous allons maintenant récupérer les données de nôtre requête. Pour cela, nous utilisons une boucle while ainsi que la méthode fetch().
    On affecte à la variable $donnees, chaque enregistrement de la table clients.
    */
            while($donnees=$rs_req->fetch()){
                echo '<pre>';
                print_r($donnees);
                echo '</pre>';
            }
    /*
    On obtient chaque ligne de notre table clients, rangée dans un tableau (Array) et chaque tableau (array) contient :
            - un tableau associatif
            - un tableau numérique

    CONCLUSION
    Par défaut, le comportement de PDO est d'envoyer la méthode fetch() avec en retour un tableau associatif et un tableau numérique.


        . L'association PDO::FETCH_ASSOC
    Nous pouvons modifier ce comportement en précisant le type d'association à utiliser. Pour cela, nous allons ajouter à la méthode fetch(), le type d'association que nous souhaitons voir apparaître. Pour faire apparaître uniquement le résultat sous la forme d'un tableau associatif, nous écrirons : PDO::FETCH_ASSOC, à la méthode fetch().

        . Lassociation PDO::FETCH_BOTH
    Par défaut, la constante utilisée par PDO est PDO::FETCH_BOTH, qui signfie envoyer les deux tableaux (associatif et numérique).

        . L'association PDO::FETCH_OBJ
    Une quatrième constante peut être utilisée, PDO::FETCH_OBJ, qui donne en retour un objet. Le code suivant identique au précédent à la différence de l'ajout du type PDO::FETCH_OBJ à la méthode fetch().
    */
            while($donnees = $rs_req ->fetch(PDO::FETCH_OBJ)){
                echo '<pre>';
                print_r($donnees);
                echo '</pre>';
            }
    /*
    Dans la pratique, on utilise le plus souvent les deu xtypes d'association : ASSOC et OBJ.

        . Gestion des erreurs SQL
    Comme nous l'avons fait à l'initialisation de l'objet PDO lors de la mise en place de la connexion à notre base de donnnées, nous allons protéger nos requêtes SQL en bloquant le code en cas d'erreur, grâce au couple TRY/CATCH.
    Pour cela nous allons d'abord définir un attribut à notre variable de connexion à la base de données : $cnx, afin de modifier l'affichage des erreurs.

    Cela donnera :
            $cnx -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);

        -- Les différents types d'affichage des erreurs --
    Il existe trois types d'affichage des erreurs :
        - ERRMODE_SILENT (Affichage par défaut)
        - ERRMODE_WARNING
        - ERRMODE_EXCEPTION
    Nous allons voir les trois principaux types d'affichage des erreurs. Nous allons provoquer une erreur SQL en faisant une requête non pas dans la table clients mais dans la table client qui n'existe pas. Notre requête SQL deviendra alors :
            $sql = "SELECT * FROM client";

        -> Premier type d'affichage : ERRMODE_SILENT
    ERRMODE_SILENT est le mode d'affichage par défaut. Ce mode d'affichage affiche une erreur sans en préciser la cause.

            try {
                $cnx = new PDO ($dsn, $user, $password);
                $cnx -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT); // Ici, l'attribut des erreurs est défini en mode d'affichage ERRMODE_SILENT
                echo "Tout s'est bien passé !";
            } catch(PDOException $e){
                echo "Une erreur est survenue !";
            }


        -> Deuxième type d'affichage des erreurs sql: ERRMODE_ WARNING
        ERRMODE_ WaRNING permet affiche le detail de l'erreur. Ce mode peut être opportun en cours de développement afin d'indentifier rapidement les erreurs éventuelles. Notre code ressemble à ceci:

            try{
                $cnx = new PDO($dsn, $user, $password);
                $cnx -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // Ici, l'attribut des erreurs est défini en mode affichage ERRMODE_WARNING
                echo "Tout s'est bien passé!";
            }catch(PDOException $e){
                echo "Une erreur est survenue !";
            }


        -> Troisième type d'affichage des erreurs sql: ERRMODE_ EXCEPTION
        ERRMODE_ EXCEPTION permet, en cas d'erreur, d'envoyer une exception. Cela nous permet donc de récupérer cette exception au travers du couple TRY/CATCH et ainsi de personnaliser le message d'erreur qui apparaîtra à l'écran.

            try{
                $cnx = new PDO($dsn, $user, $password);
                $cnx -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Ici, l'attribut des erreurs est défini en mode affichage ERRMODE_EXCEPTION
                echo "Tout s'est bien passé!";
            }catch(PDOException $e){
                echo "Une erreur est survenue !";
            }

            $sql = "SELECT * FROM client"; // La requête faussée
            // Ici, la requête est exécutée. Si elle fonctionne, le script jouera uniquement le TRY. Si elle ne fonctionne pas, le script ira directement jouer le CATCH.

                try ($donnees = $rs_req ->fetch(PDO::FETCH_OBJ)){
                echo '<pre>';
                print_r($donnees);
                echo '</pre>';
            }
    */

?>