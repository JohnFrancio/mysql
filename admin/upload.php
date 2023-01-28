<?php
session_start();

if (!isset($_SESSION['nom_admin'])) {
    header('location: ../index.php');
}

if(isset($_GET['message'])){
    if($_GET['message'] == 'yes'){
        echo '<script>alert("Ajout de produit reussie")</script>';
    }
}

include '../class/connexion.php';
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/nav.css">
    <title>ajouter-produit</title>
</head>

<body>

    <div class="sidebar">
        <a href="admin.php">Admin <img src="../assets/img/admin.png" class="w-25 text-end" style="margin-left: 160px;"></a>
        <a href="commande.php">Commande <img src="../assets/img/commander.png" class="w-25 text-end" style="margin-left: 130px;"></a>
        <a class="active">Ajouter <img src="../assets/img/ajouter.png" class="w-25 text-end" style="margin-left: 160px;"></a>
        <a href="afficher.php">Afficher <img src="../assets/img/afficher.png" class="w-25 text-end" style="margin-left: 150px;"></a>
        <a href="stat.php">Statistique <img src="../assets/img/stat.png" class="w-25 text-end" style="margin-left: 130px;"></a>
        <a href="../index.php?admin=deconnexion">Deconnecter <img src="../assets/img/deconnexion.png" class="w-25 text-end" style="margin-left: 110px;"></a>
    </div>
    <div class="container" style="margin-left:350px; width:1186px;">
        <br>
        <p class="display-4 lead" style="margin-bottom: 32px;">Ajout d'un produit</p>
        <hr>
        <form action="../controleur.php" enctype="multipart/form-data" method="post">
            <div class="row justify-content-around mt-5">
                <div class="col-lg-6">
                    <div class="form-floating mb-3">
                        <input type="num" name="prix" class="form-control border-dark" placeholder="Prix en Ariary" required>
                        <label for="prix" class="text-dark">Prix en Ariary</label>
                    </div> 
                    <label for="img" class="form-label">Image</label>
                    <input type="file" name="files[]" class="form-control" multiple required>
                    <div class="text-center">
                        <input type="submit" value="Ajouter" class="btn btn-success mt-3 px-5" name="add_product">
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>

</html>