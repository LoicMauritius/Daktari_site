<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />   
    <link rel="stylesheet" href="creerCompte.css" >
    <title>Site Veterinaire</title>
</head>

<body>
    <?php
        session_start();
        include("connexion.inc.php");
    ?>

    <style>
        i {
          color: #1c87c9;
          text-shadow: 20px 20px 40px #00ffff;
          font-size: 30px;
        }
        .iconUser i {
            font-size: 27px;
            margin-top: 15px;
            margin-left: 10px;
        }
      </style>
      
    <header class="header-area">
        <!-- site-navbar start -->
        <div class="navbar-area">
            <div class="container">
                <nav class="site-navbar">
                    <!-- site logo -->
                    <a href="#home" class="site-logo">Dr Daktari</a>

                    <!-- site menu/nav -->
                    <ul>
                        <li><a href="index.html"><b>Accueil</b></a></li>
                        <li><a href="Apropos.html"><b>A propos</b></a></li>
                        <li><a href="Service.php"><b>Service</b></a></li>
                        <li><a href="Contact.php"><b>Contact</b></a></li>
                        <li><a href="connexion.php"><b>Connexion</b></a></li>
                        <li> <a href="compte.php"><div class="iconUser"><i class="fas fa-user"></div></i></a></li>
                    </ul>

                    <!-- nav-toggler for mobile version only -->
                    <button class="nav-toggler">
                        <span></span>
                    </button>
                </nav>
            </div>
        </div><!-- navbar-area end -->


        <div class="formulaire">
            <form method="POST">
              <h1>S'inscrire</h1>
              
              <div class="inputs">
                <input type="text" placeholder="Nom" name="nom"/>
                <input type="text" placeholder="Prenom" name="prenom"/>
                <input type="email" placeholder="Adresse" name="adresse"/>
                <input type="tel" placeholder="Tel" name="tel"/>
                <input type="password" placeholder="Mot de passe" name="mdp"/>
              </div>
            
              <div align="center">
                <button type="submit">Suivant</button>
              </div>
            </form>
        </div>

        <?php
            $cnx->query('SET search_path TO projet;');

            if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['adresse']) && isset($_POST['tel']) && isset($_POST['mdp'])){
                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];
                $adresse = $_POST['adresse'];
                $tel = $_POST['tel'];
                $mdp = md5($_POST['mdp']);

                $result=$cnx->query("INSERT INTO proprietaire VALUES ((SELECT MAX(nump)+1 FROM proprietaire),'$nom', '$prenom', '$adresse', '$tel', '$mdp');");

                $_SESSION['num'] = $cnx->query("SELECT MAX(nump) FROM proprietaire;");
                $_SESSION['nom'] = $nom;
                $_SESSION['prenom'] = $prenom;
                $_SESSION['adresse'] = $adresse;
                $_SESSION['tel'] = $tel;
            
                echo "<div>Nous avons bien mémoriser votre compte de proprietaire</div>
                <a href='inscrire_animal.html'>Vers la page d'inscription d'animal;On le laisse le temps qu'on inclut le php</a>";

                sleep(2);
                header("Location: compte.php");
            }
        ?>

    </header>

</body>

    <script src="index.js"></script>

</html>