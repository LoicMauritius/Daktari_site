<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />   
    <link rel="stylesheet" href="contact.css">
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
                        <li><a href="compte.php"><div class="iconUser"><i class="fas fa-user"></div></i></a></li>
                    </ul>

                    <!-- nav-toggler for mobile version only -->
                    <button class="nav-toggler">
                        <span></span>
                    </button>
                </nav>
            </div>
        </div><!-- navbar-area end -->

        <div class="image">
        </div>
        
        <h1 class="title">Contactez nous</h1>
        <h2 class="subtitle">Nos coordonnées</h2>
        <br><br><br>
        <div class="global">
          <i class="fa fa-phone"></i>
          <p>Tél : 01 23 21 68 91</p>
        </div>
        <div class="global">
            <i class="fa fa-map"></i>
            <p>21 Avenue du Chêne, Paris, 75002</p>
          </div>
        <div class="global">
          <i class="fa fa-dog"></i>
          <u><p>Service : Tous nos services</p></u>
        </div>

        <br><br>

        <h2 class="subtitle">Formulaire</h2>
        
        <h4 class="global">
        <ul>
            <li>Vétérinaires, partenaires… Pour toute question relative au groupement, choisissez Siège social Mon Véto dans le formulaire.</li>
            <br>
            <li>Propriétaire d’animaux de compagnie ? Choisissez la clinique concernée pour lui envoyer un message</li>
        </ul>
        </h4>


        <br><br>
        <div class="formulaire">
  <form action="traitement_formulaire.php" method="POST">
    <div class="separation"></div>
    <div class="corps-formulaire">
      <div class="gauche">
        <div class="groupe">
          <label>Votre Nom</label>
          <input type="text" name="nom" autocomplete="off" />
        </div>
        <div class="groupe">
          <label>Votre Prénom</label>
          <input type="text" name="prenom" autocomplete="off" />
        </div>
        <div class="groupe">
          <label>Votre adresse e-mail</label>
          <input type="text" name="email" autocomplete="off" />
        </div>
      </div>

      <div class="droite">
        <div class="groupe">
          <label>Message</label>
          <textarea name="message" placeholder="Saisissez ici..."></textarea>
        </div>
      </div>
    </div>

    <label>
      <input type="checkbox" name="consentement">
      <span>J'accepte que mes données soient enregistrées <br>
        et conservées pour l’usage décrit dans ce formulaire.</span>
    </label>

    <br><br>

    <div class="pied-formulaire" align="center">
      <button type="submit">Envoyer le message</button>
    </div>
  </form>
</div>

<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $email = $_POST["email"];
    $message = $_POST["message"];
    $consentement = isset($_POST["consentement"]) ? "Oui" : "Non";

    $destinataire = "eliaslahlouh@gmail.com";
    $sujet = "Nouveau message depuis le site web";
    $contenu = "Nom: $nom\n";
    $contenu .= "Prénom: $prenom\n";
    $contenu .= "Adresse e-mail: $email\n";
    $contenu .= "Message: $message\n";
    $contenu .= "Consentement: $consentement\n";
    $entetes = "From: $email\r\n";

    // Envoyer l'e-mail
    if (mail($destinataire, $sujet, $contenu, $entetes)) {
        echo "Votre message a été envoyé avec succès.";
    } else {
        echo "Une erreur s'est produite lors de l'envoi du message.";
    }
}
?>



    </header>

</body>

    <script src="index.js"></script>

</html>