<?php
session_start();

require '../class/connexion.php';

if (!isset($_SESSION['nom_admin'])) {
    header('location: ../index.php');
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_detail = htmlentities($_GET['id']);
    $select = "select id_pro, nom, prix from produit where id_pro = '$id_detail'";
    $sql = $co->query($select);
    $sql = $sql->fetch(PDO::FETCH_ASSOC);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../assets/jquery-3.6.0.js"></script>
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/nav.css">
    <title>admin</title>
</head>

<body>

    <div class="sidebar">
        <a class="active" href="">Admin <img src="../assets/img/admin.png" class="w-25 text-end" style="margin-left: 160px;"></a>
        <a href="commande.php">Commande <img src="../assets/img/commander.png" class="w-25 text-end" style="margin-left: 130px;"></a>
        <a href="upload.php">Ajouter <img src="../assets/img/ajouter.png" class="w-25 text-end" style="margin-left: 160px;"></a>
        <a href="afficher.php">Afficher <img src="../assets/img/afficher.png" class="w-25 text-end" style="margin-left: 150px;"></a>
        <a href="stat.php">Statistique <img src="../assets/img/stat.png" class="w-25 text-end" style="margin-left: 130px;"></a>
        <a href="../index.php?admin=deconnexion">Deconnecter <img src="../assets/img/deconnexion.png" class="w-25 text-end" style="margin-left: 110px;"></a>
    </div>
    <div class="container" style="margin-left:350px; width:1186px;"><br>
        <p class="lead display-4" style="margin-bottom: 32px;">Administrateur</p>
        <hr>
        <div class="row mt-4">
            <div class="col-lg-6">
                <div class="ms-5 mt-4" id="cible">
                    
                </div>
            </div>
            <div class="col-lg-6">
                <p class="lead display-5 mt-5">Details du produit</p>
                <form action="../controleur.php" method="post">
                    <label for="id" class="form-label">Id du produit</label>
                    <input type="num" name="id_modify" class="form-control w-25" value="<?php echo @$sql['id_pro'] ?>" readonly>
                    <label for="nom" class="form-label">Nom du produit</label>
                    <input type="text" name="nom_produit" class="form-control w-75" value="<?php echo @$sql['nom'] ?>">
                    <label for="prix" class="form-label">Prix du produit</label>
                    <input type="num" name="prix_produit" class="form-control w-75" value="<?php echo @$sql['prix'] ?>">
                    <div class="mt-3" style="margin: 127px;">
                        <input type="submit" name="modify" value="Modifier" class="btn btn-success px-5">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function () {
        admin()

        function admin(){
            $.ajax({
                type: "post",
                url: "../controleur.php",
                data: {
                    admin_request : true
                },
                success: function (response) {
                    $.each(response, function (key, value) { 
                        $('#cible').append(`<div class="bg-danger ms-5 px-5 pb-5 mb-4" style="width: 350px; border-radius: 25px;">
                        <img src="../assets/img/afficher.png" style="width: 120px; height: 120px;">
                        <span class="" style="font-size: 110px; color:black; margin-top:3px;">${value.num_produit}</span>
                    </div>
                    <div class="bg-primary ms-5 px-5 pb-4" style="width: 350px; border-radius: 25px;">
                        <img src="../assets/img/commander.png" style="width: 120px; height: 120px;">
                        <span class="" style="font-size: 110px; color:black; margin-top:3px;">${value.num_com}</span>
                    </div>`);
                    });
                }
            });
        }
    });
    </script>
</body>

</html>