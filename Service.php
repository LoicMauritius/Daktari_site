<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />   
    <link rel="stylesheet" href="service.css">
    <title>Site Veterinaire</title>
</head>

<body>
    <?php
        session_start();
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


        <div class="accompagnement">
            <h1>Service de visite</h1>

            <!-- Consultation cabinet -->
            <?php
                include("connexion.inc.php");
                $cnx->query('SET search_path TO projet;');

                echo "<h2>Cabinet</h2>";
                echo "<div class='col-3'>";

                $result=$cnx->query("SELECT * FROM type_consultation WHERE nomtype NOT LIKE '%_HC';");

                while( $ligne = $result->fetch(PDO::FETCH_OBJ) ) // un par un
                    {
                        $consultation = $ligne->nomtype;
                        $prix = $ligne->tarifs_standard;
                        echo "<div class='bloc-accompagnement'>";
                        echo "<div class='circle-img'></div>";
                        echo "<h3>Consultation $ligne->nomtype:<br>$ligne->tarifs_standard €</h3>"; // on affiche
                        echo "<a href='reservation.php?prix=$prix&amp;L=cabinet&amp;C=$consultation'>Réserver</a>
                        </div>";
                    }

                echo "</div>";
            ?>
  
          <br><br><br>
          
          <!-- Consultation hors cabinet -->

          <?php
                include("connexion.inc.php");
                $cnx->query('SET search_path TO projet;');

                echo "<h2>Hors Cabinet</h2>";
                echo "<div class='col-3'>";

                $result=$cnx->query("SELECT * FROM type_consultation WHERE nomtype LIKE '%_HC';");

                while( $ligne = $result->fetch(PDO::FETCH_OBJ) ) // un par un
                    {
                        $consultation = $ligne->nomtype;
                        $prix = $ligne->tarifs_standard;
                        echo "<div class='bloc-accompagnement'>";
                        echo "<div class='circle-img'></div>";
                        echo "<h3>Consultation $ligne->nomtype:<br>$ligne->tarifs_standard €</h3>"; // on affiche
                        echo "<a href='reservation.php?prix=$prix&amp;L=Hcabinet&amp;C=$consultation'>Réserver</a>
                        </div>";
                    }

                echo "</div>";
            ?>
      </div>
       
    </header>

</body>

    <script src="index.js"></script>

</html>