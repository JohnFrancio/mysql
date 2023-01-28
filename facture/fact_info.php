<?php
    session_start();
    require '../class/connexion.php';

    if(isset($_SESSION['email']) && isset($_SESSION['tel']) && isset($_SESSION['facture'])){
        foreach($_SESSION['facture'] as $produit){
            $insert = "insert into commande(email, tel, nom_produit, prix_produit, quantite) values(?, ?, ?, ?, ?)";
            $sql = $co->prepare($insert);
            $sql->bindParam(1, $_SESSION['email']);
            $sql->bindParam(2, $_SESSION['tel']);
            $sql->bindParam(3, $produit['nom']);
            $sql->bindParam(4, $produit['prix']);
            $sql->bindParam(5, $produit['quantite']);
            $sql->execute();
        }
    }

    if(!isset($_SESSION['email'])){
        header('location:index.php');
    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>facture</title>
    <style>
        .contenu{
            margin-left: 20%;
        }
        .contenu h3{
            font-family: Serif;
            margin-bottom: 50px;
        }
        .facture{
            margin-left: 25%;
            font-size: 35px;
            margin-bottom: 15px;
        }
        table{
            width: 80%;
            text-align: left; 
            border: 1px solid black;
        }
        th{
            text-align: left;
            border-right: 1px solid black;
            border-bottom: 1px solid black;
        }
        td{
            border-right: 1px solid black;
            border-bottom: 1px solid black;
        }
        .nb{
            color: crimson;
        }
        .merci{
            margin-top: 30px;
            margin-left: 30%;
            font-size: 13px;
        }
    </style>
</head>
<body> 
    <div class="contenu">
        <h3>
            GeekStore <br>
            Adresse : Vatofotsy <br>
            Code postal : 110 <br>
            Adresse electronique : geek@store.mg <br>
            Contact telephonique : +261345966707 <br>
        </h3>
        <p class="facture">Facture</p>
        <?php
            $total = 0;
            $table = "";
            $table .= "
                <table>
                    <tr>
                        <th>Nom</th>
                        <th>Prix</th>
                        <th>Quantite</th>
                    </tr>
                    ";
                    if(!empty($_SESSION['facture'])){
                        foreach($_SESSION['facture'] as $fact){
                            $table .= "
                                <tr>
                                    <td>".$fact['nom']."</td>
                                    <td>".$fact['prix']."</td>
                                    <td>".$fact['quantite']."</td>
                            ";
                            $total = $total + $fact['quantite'] * $fact['prix'];
                        }
                        $table .= "
                            <tr>
                                <td colspan='2'></td>
                                <td></b>Prix Total</b></td>
                                <td>".number_format($total)."$</td>
                            </tr>
                        </table>
                        ";
                    }
                    echo $table;
        ?>
        <p class="nb">
            Notice : Vos articles sont en cours de livraison, delai 5h max<br> On vous contactera sur votre numero de telephone 0<?php echo $_SESSION['tel']?> <br>
            Au nom de <?php echo $_SESSION['nom']?> <?php echo $_SESSION['prenom']?>
        </p>
        <p class="merci">
            La team GeekStore vous remercie pour votre confiance :) <br>
            GeekStore, le Roi c'est vous ;)
        </p>
    </div>
</body>
</html>