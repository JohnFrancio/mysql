<?php
session_start();
require 'class/connexion.php';

if(isset($_POST['suggestion'])){
    $recherche = htmlentities($_POST['suggestion']);
    $select = "select nom from produit";
    $sql = $co->query($select);
    $sql->execute();
    if(!empty($recherche)){
        foreach($sql as $name){
            if(strpos($name['nom'], $recherche) !== false){
                echo $name['nom'];
                echo '<br>';
            }
        }
    }
}

if(isset($_POST['admin_request'])){
    $graphe_data = array();
    $select = "select * from produit";
    $sql = $co->query($select);
    $sql->execute();
    $num_produit = count($sql->fetchAll());

    $select1 = "select * from commande";
    $sql1 = $co->query($select1);
    $sql1->execute();
    $num_com = count($sql1->fetchAll());

    array_push($graphe_data, ['num_produit' => $num_produit, 'num_com' => $num_com]);
    header('Content-type: application/json');
    echo json_encode($graphe_data);
}

if(isset($_POST['modify'])){
    $id_modify = htmlentities($_POST['id_modify']);
    $nom_produit = htmlentities($_POST['nom_produit']);
    $prix_produit = htmlentities($_POST['prix_produit']);
    $modifier = "UPDATE produit SET nom = ?, prix = ? WHERE id_pro = ?";
    $sql = $co->prepare($modifier);
    $sql->bindParam(1, $nom_produit);
    $sql->bindParam(2, $prix_produit);
    $sql->bindParam(3, $id_modify);
    $sql->execute();
    header('location: admin/admin.php');
}

if(isset($_POST['graphe'])){
    $graphe_data = array();
    $select = "select * from produit";
    $sql = $co->query($select);
    $sql->execute();
    $num_produit = count($sql->fetchAll());

    $select1 = "select * from commande";
    $sql1 = $co->query($select1);
    $sql1->execute();
    $num_com = count($sql1->fetchAll());

    array_push($graphe_data, ['num_produit' => $num_produit, 'num_com' => $num_com]);
    header('Content-type: application/json');
    echo json_encode($graphe_data);
}

if(isset($_POST['delete_produit'])){
    $id_del = $_GET['id'];
    $sql = $co->prepare("delete from produit where id_pro = ?");
    $sql->bindParam(1, $id_del);
    $sql->execute();
    header('location:admin/afficher.php?message=yes');
}

if (isset($_POST['add_product'])) {
    // Compte le nombre de fichier
    $countfiles = count($_FILES['files']['name']);

    if($countfiles == 1){
        $prix = $_POST['prix'];
        $name = $_FILES['files']['name'][0];
        $image = './img/'.$name;
        $file_extension = pathinfo($image, PATHINFO_EXTENSION);
        $file_extension = strtolower($file_extension);
        // extension valide pour l'image
        $extension = ['jpg', 'jpeg', 'png'];
        // if (in_array($file_extension, $extension)) {
            if (move_uploaded_file($_FILES['files']['tmp_name'][0], $image)) {
                // preparation de la requete mysql
                $sql = $co->prepare("INSERT INTO produit (nom, prix, image) VALUES(?, ?, ?)");
                $sql->bindParam(1, $name);
                $sql->bindParam(2, $prix);
                $sql->bindParam(3, $image);
                $sql->execute();
            }
        // }
    }
    else{
        for ($i = 0; $i < $countfiles; $i++) {
            $name = $_FILES['files']['name'][$i];
            $image = './img/'.$name;
            $file_extension = pathinfo($image, PATHINFO_EXTENSION);
            $file_extension = strtolower($file_extension);
            // extension valide pour l'image
            $extension = ['jpg', 'jpeg', 'png'];
            // if (in_array($file_extension, $extension)) {
                if (move_uploaded_file($_FILES['files']['tmp_name'][$i], $image)) {
                    // preparation de la requete mysql
                    $sql = $co->prepare("INSERT INTO produit (nom, image) VALUES(?, ?)");
                    $sql->bindParam(1, $name);
                    $sql->bindParam(2, $image);
                    $sql->execute();
                }
            // }
        }
    }
    header('location: admin/upload.php?message=yes');
}

if (isset($_POST["admin_connecter"])) {
    if (empty($_POST["nom"]) || empty($_POST["mdp"])) {
        $message = 'Veuilez saisir tous les champs';
    } else {
        $query = "SELECT * FROM admi WHERE nom=:nom AND mdp= :mdp";

        $statement = $co->prepare($query);
        $statement->execute(
            array(
                'nom' => $_POST["nom"],
                'mdp' => $_POST["mdp"]
            )
        );
        $count = $statement->rowCount();
        if ($count > 0) {
            $_SESSION["nom_admin"] = $_POST["nom"];
            header("location: admin/admin.php");
        } else {
            header("location:index.php?erreur=true");
        }
    }
}

if (isset($_POST["connecter"])) {
    if (empty($_POST["email"]) || empty($_POST["mdp"])) {
        $message = 'Veuilez saisir tous les champs';
    } else {
        $query = "SELECT * FROM client WHERE email= :email AND mdp= :mdp";
        $statement = $co->prepare($query);
        $statement->execute(
            array(
                'email' => $_POST["email"],
                'mdp' => $_POST["mdp"]
            )
        );
        foreach($statement as $user){
            $contact = $user['tel'];
            $name = $user['nom'];
            $last_name = $user['prenom'];
        }
        $count = $statement->rowCount();
        if ($count > 0) {
            $_SESSION["email"] = $_POST["email"];
            $_SESSION['tel'] = $contact;
            $_SESSION['nom'] = $name;
            $_SESSION['prenom'] = $last_name;
            header("location:geek.php");
        } else {
            header("location: index.php?erreur=true");
        }
    }
}

if (isset($_POST['add_user'])) {
    $nom = htmlspecialchars($_POST["nom"]);
    $prenom = htmlspecialchars($_POST["prenom"]);
    $cin = htmlspecialchars($_POST["cin"]);
    $email = htmlspecialchars($_POST["email"]);
    $tel = htmlspecialchars($_POST["tel"]);
    $mdp = htmlspecialchars($_POST["mdp"]);
    $sql = $co->prepare("INSERT INTO client(nom, prenom, cin, email, tel, mdp) VALUES ('$nom','$prenom','$cin','$email','$tel','$mdp')");
    $sql->execute();
    echo 'Ajout reussie, Retour vers l\'ecran d\'accueil dans ...1...2...3!';
}

if (isset($_POST['display_product_index'])) {
    $products = $co->query("SELECT * FROM produit");
    $product_array = [];
    foreach ($products as $product) {
        $product_name = $product['nom'];
        $product_prix = $product['prix'];
        $product_img = $product['image'];
        array_push($product_array, ['product_name' => $product_name, 'product_prix' => $product_prix, 'product_img' => $product_img]);
    }
    header('Content-type: application/json');
    echo json_encode($product_array);
}