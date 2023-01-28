<?php
require 'class/connexion.php';
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

if (empty($word)) {
  header('location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>

  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/bootstrap.min.css">
    <script src="assets/bootstrap.min.js"> </script>


    <link rel="stylesheet" href="assets/modal.css">
    <script src="assets/jquery-3.6.0.js"> </script>
    <title>GeekStore</title>
  </head>

  <body>
    <div class="container-fluid">
      <nav class="navbar navbar-expand-md bg-dark navbar-dark fixed-top">
        <!-- Brand -->
        <a class="navbar-brand" href="index.php">Accueil</a>
        <!-- Toggler/collapsibe Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
          <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Navbar links -->
        <div class="collapse navbar-collapse justify-content-end" id="collapsibleNavbar">
          <ul class="navbar-nav">
            <li class="nav-item">
              <form action="search.php" method="GET">
                <div class="input-group me-3 ">
                  <input type="text" class="form-control" placeholder="Rechercher" name="word">
                  <div class="input-group-btn ">
                    <button class="btn btn-success me-5" type="submit" name="chercher">Chercher</button>
                  </div>
                </div>
              </form>
            </li>
          </ul>
        </div>
      </nav>
      <div class="alert alert-warning text-center mt-5" role="alert">
        Vous devez vous connecter pour pouvoir acheter nos produits
      </div>
      <div class="container" style="margin-top: 60px;">
        <div class="col-md-12">
          <h3 class=" text-center"> <?php echo @$message; ?></h3>
        </div>
        <div class=" row ">
          <?php foreach ($result as $produit) { ?>
            <div class="col-md-3 mt-5">
              <div class="text-center">
                <img src="<?= $produit['image'] ?>" style="width: 150px; height: 150px;" alt="">
                <h2><?php echo $produit['nom'] ?></h2>
                <h2> <?php echo $produit['prix'] ?> ar</h2>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
    </form>
    <div id="log" class="modal">
      <span onclick="document.getElementById('log').style.display='none'" class="close" title="close">&times;</span>
      <div class="container-fluid">
        <form method="post" class="modal-content animate" action="login.php">
          <div class="row justify-content-around">
            <div class="col-md-4">
              <div class="card">
                <div class="card-header bg-dark text-center text-light">
                  <h2>LOGIN</h2>
                </div>
                <div class="card-body">
                  <div class="form-group ">
                    <label class="form-label" for="email">E-MAIL</label><input class="form-control" type="email" name="email" id="email" required />
                  </div>
                  <div class="form-group">
                    <label class="form-label" for="mdp">MOT DE PASSE</label><input class="form-control" type="password" name="mdp" id="mdp" required />
                  </div>
                  <div class="text-center mt-3">
                    <input type="submit" value="Connecter" name="connecter" class="btn btn-dark w-25 me-5">
                    <a href="formulaire.php"><input type="button" value="S'inscrire" class="btn btn-danger w-25"></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div id="form" class="modal">
      <span onclick="document.getElementById('form').style.display='none'" class="close" title="Fermer">&times;</span>
      <div class="container-fluid">
        <form method="post" class="modal-content animate" action="formulaire.php">
          <div class="row justify-content-around">
            <div class="col-md-4">
              <div class="card">
                <div class="card-header bg-dark text-center text-light">
                  <h2>INSCRIPTION</h2>
                </div>
                <div class="card-body">
                  <div class="form-group ">
                    <label class="form-label" for="nom">Votre Nom</label>:<br /> <input type="text" name="nom" class="form-control" autofocus required />
                  </div>
                  <div class="form-group ">
                    <label class="form-label" for="prenom">Votre Prénom</label>:<br /> <input type="text" name="prenom" class="form-control" required />
                  </div>
                  <div class="form-group ">

                    <label class="form-label" for="cin">CIN</label>:<br /> <input type="tel" name="cin" class="form-control" maxlength="12" required />
                  </div>
                  <div class="form-group ">
                    <label class="form-label" for="email">E-mail</label>:<br /> <input type="email" name="email" class="form-control" placeholder="EX:rakoto@gmail.com" required />
                  </div>
                  <div class="form-group ">
                    <label class="form-label" for="tel">Contact</label>:<br /> <input type="tel" name="tel" class="form-control" maxlength="10" required />
                  </div>
                  <div class="form-group ">
                    <label class="form-label" for="mdp">Votre mot de passe</label>:<br /> <input type="password" class="form-control" name="mdp" required />
                  </div>
                  <div class="row justify-content-around mt-0">
                    <input type="submit" name="INSCRIRE" value="Inscrire" class="btn btn-warning w-25 mt-3" />
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
      </form>
    </div>
    </div>
    <script src="index.js"> </script>
  </body>

  </html>