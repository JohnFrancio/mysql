<?php
session_start();

if (!isset($_SESSION['nom_admin'])) {
    header('location: ../index.php');
}

require '../class/connexion.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/nav.css">
    <script src="../assets/jquery-3.6.0.js"></script>
    <script src="../assets/chart.js"></script>
    <title>commande-admin</title>
</head>

<body>

    <div class="sidebar">
        <a href="admin.php">Admin <img src="../assets/img/admin.png" class="w-25 text-end" style="margin-left: 160px;"></a>
        <a href="commande.php">Commande <img src="../assets/img/commander.png" class="w-25 text-end" style="margin-left: 130px;"></a>
        <a href="upload.php">Ajouter <img src="../assets/img/ajouter.png" class="w-25 text-end" style="margin-left: 160px;"></a>
        <a href="afficher.php">Afficher <img src="../assets/img/afficher.png" class="w-25 text-end" style="margin-left: 150px;"></a>
        <a class="active">Statistique <img src="../assets/img/stat.png" class="w-25 text-end" style="margin-left: 130px;"></a>
        <a href="../index.php?admin=deconnexion">Deconnecter <img src="../assets/img/deconnexion.png" class="w-25 text-end" style="margin-left: 110px;"></a>
    </div>
    <div class="container" style="margin-left:350px; width:1186px;"><br>
        <p class="lead display-4" style="margin-bottom: 32px;">Statistiques</p>
        <hr>
        <div class="row">
            <div class="col-lg-6">
                <canvas id="graphe" width="560" height="350"></canvas>
            </div>
            <div class="col-lg-6">
                <canvas id="graphe1" width="560" height="350"></canvas>
                <div class="text-center">
                    <span class="text-danger me-5">Produits</span>
                    <span class="text-dark">Commandes</span>
                </div>
            </div>
        </div>
        <div class="text-center">
            <canvas id="graphe3"></canvas>
        </div>
    </div>
    <script src="index.js"></script>
</body>

</html>