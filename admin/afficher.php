<?php
session_start();
require '../class/connexion.php';

if(isset($_GET['message'])){
    if($_GET['message'] == 'yes'){
        echo '<script>alert("Suppression du produit reussie")</script>';
    }
}

if (!isset($_SESSION['nom_admin'])) {
    header('location: ../index.php');
}
$result = $co->prepare("SELECT * FROM produit LIMIT 8");
$result->execute();
@$word = htmlentities($_GET['word']);
@$rechercher = htmlentities($_GET['rechercher']);
if (isset($rechercher) && !empty($word)) {
  $words = explode(" ", trim($word));
  for ($i = 0; $i < count($words); $i++) {
    $search[$i] = "nom LIKE '%" . $words[$i] . "%'";
  }
  $select = "select * from produit where " . implode(" and ", $search);
  $sql = $co->prepare($select);
  $sql->execute();
  $result = $sql->fetchAll();
  if (count($result) > 1) {
    $message = count($result) . " resultats trouves";
  } elseif (count($result) == 1) {
    $message = count($result) . " resultat trouve";
  } else {
    $message = "Aucun resultat trouve";
  }
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
    <title>commande-admin</title>
</head>

<body>

    <div class="sidebar">
        <a href="admin.php">Admin <img src="../assets/img/admin.png" class="w-25 text-end" style="margin-left: 160px;"></a>
        <a href="commande.php">Commande <img src="../assets/img/commander.png" class="w-25 text-end" style="margin-left: 130px;"></a>
        <a href="upload.php">Ajouter <img src="../assets/img/ajouter.png" class="w-25 text-end" style="margin-left: 160px;"></a>
        <a class="active">Afficher <img src="../assets/img/afficher.png" class="w-25 text-end" style="margin-left: 150px;"></a>
        <a href="stat.php">Statistique <img src="../assets/img/stat.png" class="w-25 text-end" style="margin-left: 130px;"></a>
        <a href="../index.php?admin=deconnexion">Deconnecter <img src="../assets/img/deconnexion.png" class="w-25 text-end" style="margin-left: 110px;"></a>
    </div>
    <div class="container" style="margin-left:350px; width:1186px;"> <br>
        <div class="row">
            <div class="col-lg-8">
                <div class="text-start">
                    <p class="lead display-4">Affichage des produits</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="mt-4">
                    <form action="afficher.php" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control border-dark word" placeholder="Rechercher" name="word">
                            <div class="input-group-btn ">
                                <button class="btn btn-success me-5" type="submit" name="chercher">Chercher</button>
                            </div>
                        </div>
                    </form>
                    <span class="resultat text-start"></span>
                </div>
            </div>
        </div>
        <span class="text-center text-success"><?php echo @$message?></span>
        <hr>
        <div class="row mt-3">
            <?php
            foreach ($result as $produit) { ?>
                <div class="col-md-3 mb-3">
                    <form action="../controleur.php?id=<?=$produit['id_pro']?>" method="post">
                        <div class="text-center"> <img src=".<?= $produit['image'] ?>" style="height: 150px"></div>
                        <h2 class="text-center"><?php echo $produit['nom'] ?></h2>
                        <h2 class="text-center"><?php echo number_format($produit['prix']) ?> ar</h2>
                        <div class="text-center">
                            <button type="submit" name="delete_produit" class="btn btn-danger px-4 me-3"><img src="../assets/img/delete.png" style="width:30px; height:30px;" alt=""></button>
                            <a href="admin.php?id=<?php echo $produit['id_pro']?>" class="btn btn-warning px-4"><img src="../assets/img/detail.png" style="width:30px; height:30px;" alt=""></a>
                        </div>
                    </form>
                </div>
            <?php }
            ?>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('.word').keyup(function () { 
                const recherche = $('.word').val();
                $.post("../controleur.php", {
                    suggestion : recherche
                },
                    function (data, status) {
                        $('.resultat').html(data);
                    }
                );
            });
        });
    </script>
</body>

</html>