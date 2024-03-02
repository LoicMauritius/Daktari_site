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
        include("connexion.inc.php");
        $cnx->query('SET search_path TO projet;');

        if(isset($_POST['animal']) && isset($_POST['date'])){

          if(strtotime($_POST['date']) <= time()){
            header("Location: reservation.php");
            exit;
          }
          $consultation = $_POST['consultation'];
          if(substr($consultation, -3) == "_HC"){
            $lieu = "Hors_cabinet";
          }else{
            $lieu = "cabinet";
          }
          $animal = $_POST['animal'];
          $proprietaire = $_SESSION['num'];
          $date = $_POST['date'];
          $PremiereLettre = substr(strtoupper($consultation), 0, 1);
          $result=$cnx->query("SELECT codec FROM consultation;");

          $Codes = array();

          while( $ligne = $result->fetch(PDO::FETCH_OBJ) ){
            $code = $ligne->codec;
            if(substr($code, 0, 1) == $PremiereLettre){
              $number = (int) preg_replace('/[^0-9]/', '', $code);
              array_push($Codes,$number);
            }   
          }
          if(empty($Codes)){
            $nombre = 1;
          }else{
            $nombre = max($Codes)+1;
          }
          
          $nombre= strval($nombre);

          if (strlen($nombre) == 1) {
            $nb_final = "000".$nombre;
          } elseif(strlen($nombre) == 2) {
            $nb_final = "00".$nombre;
          } elseif(strlen($nombre) == 3) {
            $nb_final = "0".$nombre;
          }elseif(strlen($nombre) == 4) {
            $nb_final = $nombre;
          }else{
            echo "Erreur : Nous ne pouvons pas stocker plus de consultations. Veillez patientez le temps que nous résolvions ce petit problème";
          }

          $code_final = $PremiereLettre.$nb_final;

          $result=$cnx->query("INSERT INTO consultation VALUES ('$code_final','$date','$lieu',NULL,NULL,NULL,NULL,NULL,NULL,NULL,
          (SELECT numa FROM animaux WHERE noma = '$animal' AND nump = $proprietaire LIMIT 1),(SELECT numtype FROM type_consultation WHERE nomtype='$consultation'));");

          $request=$cnx->query("SELECT tarifs_standard FROM type_consultation WHERE nomtype='$consultation' LIMIT 1;");
          $prix = $request->fetchColumn();

          echo "<h1>Votre consultation a bien été prise en compte :</h1>";
          $Date = date("d/m/Y", strtotime($date));
          echo "<div>Votre animal $animal a un rendez-vous $consultation le $Date. Le rendez-vous se fera en $lieu.<br>
          Votre consultation vous coûtera $prix euros.<br>
          Merci de votre confiance et à bientôt</div>";
        }else{
            header("Location: reservation.php");
        }
    ?>                  

</body>
</html>
