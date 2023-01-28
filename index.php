<?php session_start();
unset($_SESSION['panier']);
unset($_SESSION['email']);
unset($_SESSION['facture']);
unset($_SESSION['nom']);
unset($_SESSION['prenom']);
unset($_SESSION['tel']);

if(isset($_GET['admin'])){
  if($_GET['admin'] == 'deconnexion'){
    unset($_SESSION['nom_admin']);
  }
}

if (isset($_GET['erreur'])) {
  echo '<script>alert("Information incorrect ou compte inexistant")</script>';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/bootstrap.min.css">
  <link rel="stylesheet" href="assets/modal.css">
  <script src="assets/jquery-3.6.0.js"></script>
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
            <form action="search.php" method="GET">
              <div class="input-group me-5">
                <input type="text" class="form-control" placeholder="Rechercher" name="word">
                <div class="input-group-btn ">
                  <button class="btn btn-success me-5" type="submit" name="chercher">Chercher</button>
                </div>
              </div>
            </form>
          </li>
          <li class="nav-item">
            <button onclick="document.getElementById('admin').style.display='block'" class="btn btn-dark me-5">Admin</button>
          </li>
          <li class="nav-item">
            <button onclick="document.getElementById('form').style.display='block'" class="btn btn-dark me-5">S'inscrire</button>
          </li>
          <li class="nav-item">
            <button onclick="document.getElementById('log').style.display='block'" class="btn btn-dark">Se connecter</button>
          </li>
        </ul>
      </div>
    </nav>
    <br><br>
    <div class="mt-2 alert alert-warning text-center" role="alert">
      Vous devez vous connecter pour pouvoir acheter nos produits
    </div>
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-12">
          <h2 class="text-center">Les produits</h2>
          <div class="col-md-12">
            <div class="row display_product">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="admin" class="modal">
    <span onclick="document.getElementById('admin').style.display='none'" class="close" title="close">&times;</span>
    <div class="container-fluid">
      <form method="post" class="modal-content animate" action="controleur.php">
        <div class="row justify-content-around">
          <div class="col-md-4">
            <div class="card">
              <div class="card-header bg-dark text-center text-light">
                <h2>ADMIN</h2>
              </div>
              <div class="card-body">
                <div class="form-group ">
                  <label class="form-label" for="email">NOM ADMIN</label><input class="form-control" type="text" name="nom" id="nom" required />
                </div>
                <div class="form-group">
                  <label class="form-label" for="mdp">MOT DE PASSE</label><input class="form-control" type="password" name="mdp" id="mdp" required />
                </div>
                <div class="text-center mt-3">
                  <input type="submit" value="Connecter" name="admin_connecter" class="btn btn-dark w-25">
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
  <footer class="container-fluid text-center bg-dark text-white " style="height: 50px;">
    <p class="pt-2">Copyright geekstore@2023 </p>
  </footer>
  <div id="log" class="modal">
    <span onclick="document.getElementById('log').style.display='none'" class="close" title="Fermer">&times;</span>
    <div class="container-fluid">
      <form method="post" class="modal-content animate" action="controleur.php">
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
      <form method="post" class="modal-content animate formulaire" action="formulaire.php">
        <div class="row justify-content-around">
          <div class="col-md-4">
            <div class="card">
              <div class="card-header bg-dark text-center text-light">
                <h2>INSCRIPTION</h2>
              </div>
              <div class="card-body">
                <div class="form-group ">
                  <label class="form-label" for="nom">Votre Nom</label>:
                  <input type="text" name="nom" class="form-control nom" autofocus required />
                </div>
                <div class="form-group ">
                  <label class="form-label" for="prenom">Votre Prénom</label>:
                  <input type="text" name="prenom" class="form-control prenom" required />
                </div>
                <div class="form-group ">
                  <label class="form-label" for="cin">CIN</label>:
                  <input type="tel" name="cin" class="form-control cin" maxlength="12" required />
                </div>
                <div class="form-group ">
                  <label class="form-label" for="email">E-mail</label>:
                  <input type="email" name="email" class="form-control email" placeholder="EX:rakoto@gmail.com" required />
                </div>
                <div class="form-group ">
                  <label class="form-label" for="tel">Contact</label>:
                  <input type="tel" name="tel" class="form-control tel" maxlength="10" required />
                </div>
                <div class="form-group ">
                  <label class="form-label" for="mdp">Votre mot de passe</label>:
                  <input type="password" class="form-control mdp" name="mdp" required />
                </div>
                <div class="row justify-content-around mt-0">
                  <input type="submit" name="S'inscrire" value="Inscrire" class="inscription btn btn-warning w-25 mt-3" />
                </div>
                <div class="text-center text-success">
                  <span class="message"></span>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
    </form>
  </div>
  </div>
  <script src="index.js"></script>
  <script src="assets/bootstrap.min.js"></script>
</body>

</html>