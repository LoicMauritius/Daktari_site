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
    <link rel="stylesheet" href="reservation.css">
    <title>Site Veterinaire</title>
</head>

<body>

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
     
    </header>

    <?php
          if(isset($_GET['L']) && isset($_GET['C'])){
            $lieu = $_GET['L'];
            $consultation = $_GET['C'];
          }else{
            $lieu = "";
            $consultation = "";
            echo "<h1 style='color:red'>Veuiller renseigner des informations valides !!</h1>";
          } 
    ?>

    <h1>Réservation</h1>

    <form action="reservation_effectuer.php" method="POST">
      <label for="animal">Animaux:</label>
      <div>
      <select name="animal" id="pet-select">
        <option value="">--Selectionner votre animal--</option>
        <?php
            $animaux = unserialize($_COOKIE['animaux'], ["allowed_classes" => false]);

            foreach ($animaux as $key => $value) {
              echo "<option value='$value'>$value</option>";
            }
        ?>
      </select>
          
      </div>
    
      <label for="date">Date de réservation (jour/mois/année):</label>
      <input type="date" id="date" name="date" required>
  
      </div>
      
      <label for="adresse">Type de consultation:</label>
      <div id="R">
        <?php
            include("connexion.inc.php");
            $cnx->query('SET search_path TO projet;');

            $result=$cnx->query("SELECT * FROM type_consultation WHERE nomtype NOT LIKE '%_HC';");

            echo "<div>";
            echo "<h2> Cabinet:</h2>";
            while( $ligne = $result->fetch(PDO::FETCH_OBJ) ) // un par un
                {
                    $consultations = $ligne->nomtype;
                    if($consultations == $consultation){
                      
                      echo "<div>";
                      echo "<input type='radio' name='consultation' id='consultation' value='$consultations' checked><h4>$consultations</h4>";
                      echo "</div>";
                    }else{
                      echo "<div>";
                      echo "<input type='radio' name='consultation' id='consultation' value='$consultations'><h4>$consultations</h4>";
                      echo "</div>";
                    }    
                }
                echo "</div>";

                $result=$cnx->query("SELECT * FROM type_consultation WHERE nomtype LIKE '%_HC';");
                echo "<div>";
                echo "<h2> Hors Cabinet:</h2>";

                while( $ligne = $result->fetch(PDO::FETCH_OBJ) ) // un par un
                {
                        $consultations = $ligne->nomtype;
                        if($consultations == $consultation){
                          
                          echo "<div>";
                          echo "<input type='radio' name='consultation' id='consultation' value='$consultations' checked><h4>$consultations</h4>";
                          echo "</div>";
                        }else{
                          echo "<div>";
                          echo "<input type='radio' name='consultation' id='consultation' value='$consultations'><h4>$consultations</h4>";
                          echo "</div>";
                        }    
                }
                
              echo "</div>";
        ?>
      </div>
    
      <label for="motif">Motif consultation:</label>
      <input type="text" id="motif" name="motif" class="large-input" cols="30" required>
    
      <label for="adresse">Adresse (Si hors cabinet):</label>
      <input type="text" id="adresse" name="adresse">

      <input type="submit" value="Réserver">
    </form>                    

</body>

    <script src="index.js"></script>

</html>