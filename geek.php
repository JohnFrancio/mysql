<?php

session_start();

if(!isset($_SESSION['email'])){
    header('location: index.php');
}

include 'class/connexion.php';

if (isset($_GET['action'])) {
    if ($_GET['action'] === "annulertout") {
        unset($_SESSION['panier']);
    }

    if ($_GET['action'] === "annuler") {
        foreach ($_SESSION['panier'] as $key => $value) {
            if ($value['id'] == $_GET['id']) {
                unset($_SESSION['panier'][$key]);
            }
        }
    }
}

if (isset($_POST['submit'])) {
    if (isset($_SESSION['panier'])) {
        $array_id = array_column($_SESSION['panier'], "id");

        if (!in_array($_GET['id'], $array_id)) {
            $session_array = array(
                'id' => $_GET['id'],
                "nom" => $_POST['nom'],
                "prix" => $_POST['prix'],
                "quantite" => $_POST['quantite']
            );
            $_SESSION['panier'][] = $session_array;
        }
    } else {
        $session_array = array(
            'id' => $_GET['id'],
            'nom' => $_POST['nom'],
            'prix' => $_POST['prix'],
            'quantite' => $_POST['quantite']
        );

        $_SESSION['panier'][] = $session_array;
    }
}

if(isset($_POST['commander'])){
    $_SESSION['facture'] = @$_SESSION['panier'];
    unset($_SESSION['panier']);
}

$sql = $co->prepare("SELECT * FROM produit");
$sql->execute();
if (isset($_GET['word']) and !empty($_GET['word'])) {

    @$recherche = htmlspecialchars($_GET['word']);
    $sql = $co->query('SELECT * FROM produit WHERE nom LIKE "%' . $recherche . '%"  ORDER BY id_pro DESC ');
    $sql->execute();
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/bootstrap.min.css">
    <title>GeekStore</title>
</head>

<body>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-md bg-dark navbar-dark fixed-top">
            <span class="navbar-brand">GeekStore</span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="collapsibleNavbar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <form action="geek.php" method="GET">
                            <div class="input-group me-3">
                                <input type="text" class="form-control" placeholder="Rechercher" name="word">
                                <div class="input-group-btn ">
                                    <button class="btn btn-success me-5" type="submit" name="chercher">Chercher</button>
                                </div>
                            </div>
                        </form>
                    </li>
                    <?php
                    if(!empty($_SESSION['facture'])){ ?>
                        <li class="nav-item">
                            <a class="nav-link me-5" href="facture/facture.php">Facture</a>
                        </li>
                    <?php }
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=deconnecter">Se déconnecter</a>
                    </li>
                </ul>
            </div>
        </nav>
        <br><br>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="text-center my-3 display-4">Les produits</h2>
                    <div class="col-md-12">
                        <div class="row">
                            <?php
                            foreach ($sql as $produit) { ?>
                                <div class="col-md-4">
                                    <form action="geek.php?id=<?= $produit['id_pro'] ?>" method="post">
                                        <div class="text-center"> <img src="<?= $produit['image'] ?>" style="height: 150px"></div>
                                        <h2 class="text-center"><?php echo $produit['nom'] ?></h2>
                                        <h2 class="text-center"><?php echo number_format($produit['prix']) ?> ar</h2>
                                        <input type="hidden" name="nom" value="<?php echo $produit['nom'] ?>">
                                        <input type="hidden" name="prix" value="<?php echo $produit['prix'] ?>">
                                        <input type="number" name="quantite" value="1" class="form-control text-end">
                                        <input type="submit" name="submit" value="Acheter" class="btn btn-danger" style="width: 100%">
                                    </form>
                                </div>
                            <?php }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h2 class="text-center my-3 display-4">Les produits selectionnees</h2>
                    <?php
                    $total = 0;
                    $output = "";
                    $output .= "
                            <table class='table table-bordered table-striped'>
                                <tr>
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th>Prix</th>
                                    <th>Quantite</th>
                                    <th>Prix total</th>
                                    <th>Action</th>
                                    <th>Commander</th>
                                </tr>
                    ";
                    if (!empty($_SESSION['panier'])) {
                        foreach ($_SESSION['panier'] as $key => $value) {
                            $output .= "
                                <tr>
                                    <td>" . $value['id'] . "</td>
                                    <td>" . $value['nom'] . "</td>
                                    <td>" . $value['prix'] . " ar</td>
                                    <td>" . $value['quantite'] . "</td>
                                    <td>" . number_format($value['prix'] * $value['quantite']) . " ar</td>
                                    <td>
                                        <a class='btn btn-warning' href='geek.php?action=annuler&id=" . $value['id'] . "'>
                                            Effacer
                                        </a>
                                    </td>
                            ";
                            $total = $total + $value['quantite'] * $value['prix'];
                        }
                        $output .= "
                            <tr>
                                <td colspan='3'></td>
                                <td></b>Prix Total</b></td>
                                <td>" . number_format($total) . " ar</td>
                                <td>
                                    <a class='btn btn-warning' href='geek.php?action=annulertout'>
                                        Annuler
                                    </a>
                                </td>
                                <td>
                                    <form action='geek.php' method='post'>
                                        <input class='btn btn-success' type='submit' name='commander' value='Tout commander'>
                                    </form>
                                </td>
                            </tr>
                        ";
                    }
                    echo $output;
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>