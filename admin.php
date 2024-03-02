<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />   
    <link rel="stylesheet" href="admin.css">
    <title>Site Veterinaire</title>
</head>

<body>
  <?php
    session_start();

    if(isset($_POST['form_ins'])){
      $Columns = $_SESSION['Columns'];
      $infos = array();
      foreach($Columns as $key => $value){
        $v = $_POST[$value];
        array_push($infos, $v);
      }

      $nb_valeurs = count($infos);

      include("connexion.inc.php");

      $table = $_SESSION['table'];

      $cnx->query('SET search_path TO projet;');
      $requete = "INSERT INTO $table VALUES(";
      foreach($infos as $key => $value){
        if(is_string($value)){
          $requete = $requete."'".$value."'";
        }else{
          $requete = $requete.$value;
        }
        $requete = $requete.",";
      }
      $requete = $requete.");";
      
      $result=$cnx->query($requete);
      
      echo "Nous avons bien enregistré votre insertion";
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
      <!-- Choix de l'action à effectuer -->
      <form method="POST">
        <h1>Choississez une action:</h1>
        <select name="action" id="action">
          <option value="Lecture" selected>Lecture de la table</option>
          <option value="Insertion">Insertion dans une table</option>
          <option value="Supprimer">Suppression dans une table</option>
          <option value="Modification">Modifier la valeur d'un champ de la table</option>
        </select>

      <!-- Choix de la table à modifier -->

        <h1>Choississez une table:</h1>
        <select name='table' id='table'>

        <?php
        include("connexion.inc.php");

        $cnx->query('SET search_path TO projet;');
        $result=$cnx->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'projet';");

        while( $ligne = $result->fetch(PDO::FETCH_OBJ) ){
          $table = $ligne->table_name;
          echo "<option value='$table'>$table</option>";
        }
        ?>
        </select>

        <h1>Requete pré-faite:</h1>

        <select name="requete" id="requete">
          <option value="" selected></option>
          <option value="Proprio_Animal">Voir la liste des propriétaire et de leurs animaux</option>
          <option value="Consultations">Avoir la liste de toutes les consultations trié par ordre décroissante de date (de la plus récente à la plus ancienne)</option>
        </select>

        <input type='submit' value='Appliquer le filtre'>
      </form>
  
      <?php
      if(isset($_POST['action']) && isset($_POST['table'])){
        
        if(isset($_POST['requete']) && $_POST['requete'] != ""){
          $requete = $_POST['requete'];
          echo $requete;
        }else{

          include("connexion.inc.php");
          $cnx->query('SET search_path TO projet;');

          echo "<section>";
          $action = $_POST['action'];
          $table = $_POST['table'];

          switch($action){
            case "Lecture":

              echo "<table>";

              $result=$cnx->query("SELECT * FROM $table;");
              $donnees = $result->fetchAll(PDO::FETCH_ASSOC);
              
              foreach($donnees as $ligne){
                echo "<tr>";
                foreach($ligne as $champ => $valeur){
                    echo "<td id='titre'>$champ</td>";
                }
                echo "</tr>";
                break;
              }

              foreach($donnees as $ligne){
                echo "<tr>";
                foreach($ligne as $champ => $valeur){
                    echo "<td>$valeur</td>";
                }
                echo "</tr>";
              }
              
              echo "</table>";
              break;

            case "Insertion":

              $Columns = array();
              echo "$action dans la table $table";
              echo "<form id='apparu' method='POST'>";

              $result=$cnx->query("SELECT column_name, data_type FROM information_schema.columns WHERE table_name = '$table';");

              // Boucle sur les résultats
              while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                  // Affichage du nom et du type de la colonne
                  if($row['data_type'] == "boolean"){
                    $valeur = $row['column_name'];
                    echo "<div>";
                    echo "<label for='$valeur'>$valeur</label>";
                    echo "<select name='bool'>";
                    echo "<option value='true'>Oui</option>";
                    echo "<option value='false'>Non</option>";
                    echo "</select>";
                    echo "</div>";
                    array_push($Columns, $valeur);
                  }else if($row['data_type'] == "integer"){
                    $valeur = $row['column_name'];
                    echo "<div>";
                    echo "<label for='$valeur'>$valeur</label>";
                    echo "<input type='number' name='$valeur'>";
                    echo "</div>";
                    array_push($Columns, $valeur);
                  }else{
                    $valeur = $row['column_name'];
                    echo "<div>";
                    echo "<label for='$valeur'>$valeur</label>";
                    echo "<input type='text' name='$valeur'>";
                    echo "</div>";
                    array_push($Columns, $valeur);
                  } 
              }
              $_SESSION['table'] = $table;
              $_SESSION['Columns'] = $Columns;

              echo "<input type='submit' name='form_ins' value='Valider'>";
              echo "</form>";
              break;

            case "Supprimer":

              echo "<form id='apparu' method='POST'>";

              $result=$cnx->query("SELECT column_name, data_type FROM information_schema.columns WHERE table_name = '$table';");
              echo "<h1>Choisi une information à rentrer pour la suppression:</h1>";
              echo "<div>";
              echo "<select name='supp'>";

              // Boucle sur les résultats
              while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                  $valeur = $row['column_name'];          
                  echo "<option value='$valeur'>$valeur</option>";
              }

              echo "</select>";
              echo "</div>";
              echo "<input type='submit' name='form_supp' value='Valider'>";
              echo "</form>";

              $_SESSION['table'] = $table;
              break;

            case "Modification":
              echo "$action dans la table $table";
              break;
          }
        }
        
        echo "</section>";
      }
      ?>
      <?php
        if(isset($_POST['form_supp'])){
          $table = $_SESSION['table'];
          $supp = $_POST['supp'];
          $_SESSION['supp'] = $supp;

          echo "<section>";
          echo "<form id='apparu' method='POST'>";
          $result=$cnx->query("SELECT column_name, data_type FROM information_schema.columns WHERE table_name = '$table';");
          echo "<h1>Rentre la valeur de $supp que tu veux supprimer:</h1>";
          echo "<div>";

              // Boucle sur les résultats
              while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                  if($row['column_name'] == $supp) {   
                    if($row['data_type'] == "boolean"){
                      $valeur = $row['column_name'];
                      echo "<div>";
                      echo "<label for='$valeur'>$valeur</label>";
                      echo "<select name='valeur'>";
                      echo "<option value='true'>Oui</option>";
                      echo "<option value='false'>Non</option>";
                      echo "</select>";
                      echo "</div>";
                      array_push($Columns, $valeur);
                    }else if($row['data_type'] == "integer"){
                      $valeur = $row['column_name'];
                      echo "<div>";
                      echo "<label for='$valeur'>$valeur</label>";
                      echo "<input type='number' name='valeur'>";
                      echo "</div>";
                    }else{
                      $valeur = $row['column_name'];
                      echo "<div>";
                      echo "<label for='$valeur'>$valeur</label>";
                      echo "<input type='text' name='valeur'>";
                      echo "</div>";
                    } 
                }
            }
            echo "</div>";
            echo "<input type='submit' name='form_supp2' value='Valider'>";
            echo "</form>";  
            echo "</section>";  
        }
      ?>

<?php
        if(isset($_POST['form_supp2'])){
          $table = $_SESSION['table'];
          $supp = $_SESSION['supp'];
          $valeur = $_POST['valeur'];
          
          $requete = "DELETE FROM $table WHERE $supp = ";
          if(is_string($valeur)){
            $requete = $requete."'".$valeur."'";
          }else{
            $requete = $requete.$value;
          }
          $requete = $requete.";";

          echo "$requete";
        
          $result=$cnx->query($requete);
          
          echo "Votre supression a bien été prise en compte.";
        }
      ?>

    </main>

</body>

    <script src="index.js"></script>

</html>