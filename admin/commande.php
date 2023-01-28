<?php
session_start();

require '../class/connexion.php';

if (!isset($_SESSION['nom_admin'])) {
    header('location: ../index.php');
}

$select = "select * from commande order by date desc";
$result = $co->prepare($select);
$result->execute();
@$word = htmlentities($_GET['word']);
@$rechercher = htmlentities($_GET['rechercher']);
if (isset($rechercher) && !empty($word)) {
    $words = explode(" ", trim($word));
    for ($i = 0; $i < count($words); $i++) {
        $search[$i] = "date LIKE '%" . $words[$i] . "%' order by date desc";
    }
    $select = "select * from commande where " . implode(" and ", $search);
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/nav.css">
    <title>commande-admin</title>
</head>

<body>

    <div class="sidebar">
        <a href="admin.php">Admin <img src="../assets/img/admin.png" class="w-25 text-end" style="margin-left: 160px;"></a>
        <a class="active">Commande <img src="../assets/img/commander.png" class="w-25 text-end" style="margin-left: 130px;"></a>
        <a href="upload.php">Ajouter <img src="../assets/img/ajouter.png" class="w-25 text-end" style="margin-left: 160px;"></a>
        <a href="afficher.php">Afficher <img src="../assets/img/afficher.png" class="w-25 text-end" style="margin-left: 150px;"></a>
        <a href="stat.php">Statistique <img src="../assets/img/stat.png" class="w-25 text-end" style="margin-left: 130px;"></a>
        <a href="../index.php?admin=deconnexion">Deconnecter <img src="../assets/img/deconnexion.png" class="w-25 text-end" style="margin-left: 110px;"></a>
    </div>
    <div class="container" style="margin-left:350px; width:1186px;"><br>
        <div class="row">
            <div class="col-lg-8">
                <div class="text-start">
                    <p class="lead display-4">Commande</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="text-end mt-4">
                    <form action="commande.php" method="GET">
                        <div class="input-group">
                            <div class="form-floating">
                                <input type="text" class="form-control border-dark" style="height: 37px; margin-top: 5px;" placeholder="annee-mois-jour" name="word">
                                <label for="word" class="">Annee-Mois-Jour</label>
                            </div>
                            <div class="input-group-btn ">
                                <button class="btn btn-success me-5" type="submit" name="chercher" style="height: 37px; margin-top: 5px;">Chercher</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <span class="text-center text-success"><?php echo @$message?></span>
        <hr>
        <div class="row justify-content-around">
            <div class="col-lg-12">
                <table class='table table-bordered table-striped mt-3'>
                    <tr>
                        <th class="text-start">Numero</th>
                        <th class="text-start">Adresse email</th>
                        <th class="text-start">Nom du produit</th>
                        <th class="text-start">Prix</th>
                        <th class="text-start">Quantite</th>
                        <th class="text-start">Date</th>
                    </tr>
                    <?php
                    foreach ($result as $cmd) {
                    ?>
                        <tr>
                            <td class="">0<?php echo $cmd['tel'] ?></td>
                            <td class=""><?php echo $cmd['email'] ?></td>
                            <td class=""><?php echo $cmd['nom_produit'] ?></td>
                            <td class=""><?php echo $cmd['prix_produit'] ?></td>
                            <td class=""><?php echo $cmd['quantite'] ?></td>
                            <td class=""><?php echo $cmd['date'] ?></td>
                            <!-- <td class="">
                                <form action="francio.php" method="post">
                                    <input type="hidden" name="id_del" value="<?php echo $cmd['id'] ?>">
                                    <input type="submit" name="effectuer" value="Effectuer" class="btn btn-success px-5">
                                </form>
                            </td> -->
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            </div>
        </div>
</body>

</html>