<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />   
    <link rel="stylesheet" href="connexion.css">
    <title>Site Veterinaire</title>
    <?php
        //On démarre une nouvelle session
        session_start();
        /*On utilise session_id() pour récupérer l'id de session s'il existe.
        *Si l'id de session n'existe  pas, session_id() rnevoie une chaine
        *de caractères vide*/
        $id_session = session_id();
    ?>
</head>

<body>
    
    <?php
        include("connexion.inc.php");
    ?>
    <style>
        i {
          color: #1c87c9;
          text-shadow: 20px 20px 40px #00ffff;
          font-size: 30px;
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
                        <li><a href="compte.php"><div class="iconUser"><i class="fas fa-user"></div></i></a></li>
                    </ul>

                    <!-- nav-toggler for mobile version only -->
                    <button class="nav-toggler">
                        <span></span>
                    </button>
                </nav>
            </div>
        </div><!-- navbar-area end -->


        <div class="formulaire">
            <form action="" method="POST">
              <h1>Se connecter</h1>
              
              <div class="inputs">
                <input type="text" placeholder="Nom" name="nom"/>
                <input type="text" placeholder="Prenom" name="prenom"/>
                <input type="password" placeholder="Mot de passe" name="mdp">
              </div>
              
              <p class="inscription">Créer un <a href="creerCompte.php">compte</a>.</p>
              <div align="center">
                <button type="submit">Se connecter</button>
              </div>
            </form>
        </div>

        <?php
        $cnx->query('SET search_path TO projet;');

        if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['mdp'])){
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $mdp = md5($_POST['mdp']);

            echo $nom;
            echo $prenom;
            echo $_POST['mdp'];
            if($nom == 'root' && $prenom == 'root' && $_POST['mdp'] == 'root'){
                header("Location: admin.php");
                exit;
            }

            $result=$cnx->query("SELECT * FROM proprietaire WHERE nomp='$nom' AND prenomp='$prenom' AND mdp='$mdp';");

            while( $ligne = $result->fetch(PDO::FETCH_OBJ) ) // un par un
            {
                echo "<div>Vous êtes identifier au nom de : $ligne->nomp, $ligne->prenomp <div>"; // on affiche
                $_SESSION['num'] = $ligne->nump;
                $_SESSION['nom'] = $nom;
                $_SESSION['prenom'] = $prenom;
                $_SESSION['adresse'] = $ligne->adresse;
                $_SESSION['tel'] = $ligne->telp;
                sleep(2);
                header("Location: compte.php");
            }
            if(!isset($_SESSION['nom']) or !isset($_SESSION['prenom'])){
                echo "<div id='erreur'>Vous n'êtes pas connecter ! Mauvais identifiant ou mauvais mot de passe</div>";
            }
            $result->closeCursor();
        }

        
        ?>
        <?php
            if($id_session){
                echo 'ID de session (récupéré via session_id()) : <br>'
                .$id_session. '<br>';
            }
        ?>

    </header>

</body>

    <script src="index.js"></script>

</html>