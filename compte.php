<!DOCTYPE html>
<html lang="en">
<?php
    session_start();
    if(!isset($_SESSION['nom']) && !isset($_SESSION['prenom'])){
        header("Location: connexion.php");
    }
    
    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: connexion.php"); // Redirige l'utilisateur vers la page de connexion
        exit();
    }
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />   
    <link rel="stylesheet" href="compte.css">
    <title>Site Veterinaire</title>
</head>

<body>
 
    <style>
        i {
          color: #000;
          text-shadow: 20px 20px 40px #00ffff;
          font-size: 20px;
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
                        <li><a href="compte.html"><div class="iconUser"><i class="fas fa-user"></div></i></a></li>
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
        <?php 
            $num = $_SESSION['num'];
            $nom = $_SESSION['nom'];
            $prenom = $_SESSION['prenom'];
            $adresse = $_SESSION['adresse'];
            $tel = $_SESSION['tel'];
        ?>
        <section>
            <div>
                <img id="compte" src="img/compte.png" alt="compte">
            </div>

            <div id="info_compte">
                <h1>Votre compte</h1>
                <?php 
                echo '<h2>'.$nom.' '.$prenom.'</h2>';
                echo '<address>tel: '.$tel.'</address>';
                echo '<address>adresse: '.$adresse.'</address>';
                ?> 
            </div>

        </section>

        <section>
            
            <div id="animal">
                <img src="img/animal.PNG" alt="animal">
            </div>
            <div id="info_animal">
                <div id="tableau">
                <?php 
                    $animaux = array();
                    include("connexion.inc.php");

                    echo "<h1>Animaux:<h1>";
                    echo "<table border='1'>";
                    echo "<tr id='ligne'>
                            <td>Nom de l'animal</td><td>Espece</td><td>Race</td><td>Taille (en cm)</td><td>Genre</td><td>Poids (en g)</td><td>Vacciné(e) ?</td><td>Castré(e) ?</td>
                        <tr>"; // on affiche
                    $cnx->query('SET search_path TO projet;');
                    $result=$cnx->query("SELECT * FROM animaux WHERE nump=(SELECT nump FROM proprietaire WHERE nomp='$nom' AND prenomp='$prenom' AND adresse='$adresse' AND telp='$tel');");
                    while( $ligne = $result->fetch(PDO::FETCH_OBJ) ) // un par un
                    {
                        switch($ligne->vaccination){
                            case 1:
                                $vaccination = "Oui";
                                break;
                            case 0:
                                $vaccination = "Non";
                                break;
                        }

                        switch($ligne->castration){
                            case 1:
                                $castration = "Oui";
                                break;
                            case 0:
                                $castration = "Non";
                                break;
                        }

                        echo "<tr id='ligne'>
                            <td>$ligne->noma</td><td>$ligne->espece</td><td>$ligne->race</td><td>$ligne->taille_cm</td><td>$ligne->genre</td><td>$ligne->poids_g</td><td>$vaccination</td><td>$castration</td>
                        <tr>"; // on affiche
                        array_push($animaux, $ligne->noma);
                    }
                    setcookie('animaux', serialize($animaux), time()+60*60*24*30);
                    echo "</table>";
                ?>
                </div>
                <a href="inscrire_animal.php">Ajouter</a>
            </div>
            
        </section >
        <section id='Consultations'>
        <?php 
            include("connexion.inc.php");
            $Consultations = array();

            $cnx->query('SET search_path TO projet;');
            $result=$cnx->query("SELECT datec,lieu,noma,typec FROM consultation JOIN animaux ON animal = numa NATURAL JOIN proprietaire P WHERE P.nump = $num;");
            while( $ligne = $result->fetch(PDO::FETCH_OBJ) ) // un par un
            {
                $consultation = array();
                $type_consultation = $ligne->typec;
                array_push($consultation, $type_consultation);
                $animal = $ligne->noma;
                array_push($consultation, $animal);
                $date = $ligne->datec;
                array_push($consultation, $date);
                $lieu = $ligne->lieu;
                array_push($consultation, $lieu);

                array_push($Consultations,$consultation);
            }

            // Trie les consultations en fonction de la date de consultation dans l'ordre croissant
            usort($Consultations, function($a, $b) {
                return strtotime($a[2]) - strtotime($b[2]);
            });
            echo "<div>";
            echo "<h1> Consultation a venir:</h1>";
            echo "<table border=1>";
            echo "<tr id='ligne'>";
            echo "<td>Date</td><td>Animal</td><td>Type de consultation</td><td>Lieu</td><td>Prix</td>";
            echo "</tr>";
            foreach ($Consultations as $key => $value) {
                $numtype = $value[0];
                if(is_int($numtype)){
                    $request=$cnx->query("SELECT nomtype,tarifs_standard FROM type_consultation WHERE numtype = $numtype LIMIT 1;");
                    if ($ligne = $request->fetch(PDO::FETCH_ASSOC)) {
                        $nomtype = $ligne['nomtype'];
                        $prix = $ligne['tarifs_standard'];
                    }

                    $animal = $value[1];
                    $date = $value[2];
                    $lieu = $value[3];

                    if(strtotime($date) > time()){
                        echo "<tr id='ligne'>";
                        echo "<td>$date</td><td>$animal</td><td>$nomtype</td><td>$lieu</td><td>$prix €</td>";
                        echo "</tr>";
                    }
                }
            }
            echo "</table>";
            echo "</div>";

            echo "<div>";
            echo "<h1> Consultation passées:</h1>";
            echo "<table border=1>";
            echo "<tr id='ligne'>";
            echo "<td>Date</td><td>Animal</td><td>Type de consultation</td><td>Lieu</td><td>Prix</td>";
            echo "</tr>";
            foreach ($Consultations as $key => $value) {
                $numtype = $value[0];
                if(is_int($numtype)){
                    $request=$cnx->query("SELECT nomtype,tarifs_standard FROM type_consultation WHERE numtype = $numtype LIMIT 1;");
                    if ($ligne = $request->fetch(PDO::FETCH_ASSOC)) {
                        $nomtype = $ligne['nomtype'];
                        $prix = $ligne['tarifs_standard'];
                    }

                    $animal = $value[1];
                    $date = $value[2];
                    $lieu = $value[3];

                    if(strtotime($date) <= time()){
                        echo "<tr id='ligne'>";
                        echo "<td>$date</td><td>$animal</td><td>$nomtype</td><td>$lieu</td><td>$prix €</td>";
                        echo "</tr>";
                    }
                }
            }
            echo "</table>";
            echo "</div>";
        ?>
        </section>

        <form method="post">
            <input type="submit" name="logout" value="Déconnexion">
        </form>
    </main>

</body>

    <script src="index.js"></script>

</html>