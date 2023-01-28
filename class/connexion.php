<?php
    try{
        $co = new PDO ("mysql:host=localhost;dbname=gestion","root","");
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        echo "Erreur de connexion : ".$e->getMessage();
    }
?>