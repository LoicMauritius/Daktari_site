<!DOCTYPE html>
<html lang="en">

<?php
    session_start();
    if(!isset($_SESSION['nom']) && !isset($_SESSION['prenom'])){
        header("Location: connexion.php");
    }
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />   
    <link rel="stylesheet" href="inscrire_animal.css">
    <title>Site Veterinaire</title>
</head>

<body>
        <?php
            include("connexion.inc.php");
            $cnx->query('SET search_path TO projet;');

            if(isset($_POST['nom']) && isset($_POST['genre']) && isset($_POST['espece']) && isset($_POST['race']) && isset($_POST['taille']) && isset($_POST['poids']) && isset($_POST['castration']) && isset($_POST['vaccination'])){
                $nom = $_POST['nom'];
                $genre = $_POST['genre'];
                $espece = $_POST['espece'];
                $race = $_POST['race'];
                $taille = $_POST['taille'];
                $poids = $_POST['poids'];
                $castration = $_POST['castration'];
                $vaccination = $_POST['vaccination'];
                $num = $_SESSION['num'];

                $result=$cnx->query("INSERT INTO animaux VALUES ((SELECT MAX(numa)+1 FROM animaux),'$nom', '$espece', '$race', $taille,'$genre',  $vaccination,$poids,$castration,$num);");
            
                echo "<div>Nous avons bien mémoriser votre animal $nom</div>";

                sleep(2);
                header("Location: compte.php");
            }
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
    </header>
    <main>
        <form method="POST">
            <section id="info_de_base">
                <h1>Inscrire un animal</h1>
                <div>
                    <div>
                        <label for="nom">Nom *</label>
                        <input type="text" name="nom" id="nom" required>
                    </div>
                    <div>
                        <label for="genre">Genre *</label>
                        <div id="R">
                            <input type="radio" name="genre" id="genre" value="Mâle"><h4>Mâle</h4><br>
                            <input type="radio" name="genre" id="genre" value="femelle"><h4>Femelle</h4>
                        </div>
                    </div>
                    <div>
                        <label for="espece">Espece de l'animal *</label>
                        <input type="text" name="espece" id="espece" required>
                    </div>
                    <div>
                        <label for="race">Race de l'animal *</label>
                        <input type="text" name="race" id="race" required>
                    </div>
                    <div>
                        <label for="taille">Taille (en cm) *</label>
                        <input type="number" name="taille" id="taille">
                    </div>
                    <div>
                        <label for="poids">Poids (en g)*</label>
                        <input type="number" name="poids" id="poids">
                    </div>
                </div> 
            </section>
            <section id="info_sup">
                <h1>Plus d'information sur l'animal</h1>
                <div>
                    <section>
                        <h2>Votre animal est-il castré ?</h2>
                        <div>
                            <div id="vacc">
                                <label for="castration">Oui</label>
                                <input type="radio" name="castration" id="cast" value="true">
                            </div>
                            <div id="vacc">
                                <label for="castration">Non</label>
                                <input type="radio" name="castration" id="cast" value="false">
                            </div>
                        </div>
                    </section>
                    <section>
                        <h2>Votre animal est-il vacciné ?</h2>
                        <div>
                            <div id="vacc">
                                <label for="vaccination">Oui</label>
                                <input type="radio" name="vaccination" id="cast" value="true">
                            </div>
                            <div id="vacc">
                                <label for="vaccination">Non</label>
                                <input type="radio" name="vaccination" id="cast" value="false">
                            </div>
                        </div>
                    </section>
                </div>
            </section>
            <div id="envoi">
                <button type="reset">Effacer</button>
                <button type="submit">Envoyer</button>
            </div>
        </form>
    </main>

</body>

    <script src="index.js"></script>

</html>