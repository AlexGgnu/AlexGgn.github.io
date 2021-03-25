<!-- © MyFideal by Alexis Gagneau -->
<!-- © Logos by Timéo Privitera -->

<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=myfideal', 'root', '');

if(isset($_SESSION['mail']))
{
    $requser = $bdd->prepare("SELECT * FROM membres WHERE mail = ?");
    $requser->execute(array($_SESSION['mail']));
    $user = $requser->fetch();

    if(isset($_POST['forminscription']))
    {
        if(!empty($_POST['prenom']) AND !empty($_POST['nom']) AND !empty($_POST['birthday']))
        {

            // Prenom + Pseudo
            $prenom = htmlspecialchars($_POST['prenom']);

            // Pseudo
            $insertpseudo = $bdd->prepare("UPDATE membres SET pseudo = ? WHERE mail = ?");
            $insertpseudo->execute(array($prenom, $_SESSION['mail']));

            // Prenom
            $insertprenom = $bdd->prepare("UPDATE membres SET prenom = ? WHERE mail = ?");
            $insertprenom->execute(array($prenom, $_SESSION['mail']));

            // Nom de famille
            $nom = htmlspecialchars($_POST['nom']);
            $insertnom = $bdd->prepare("UPDATE membres SET nom = ? WHERE mail = ?");
            $insertnom->execute(array($nom, $_SESSION['mail']));

            // Date d'anniversaire
            $birthday = ($_POST['birthday']);
            $insertdate = $bdd->prepare("UPDATE membres SET birthday = ? WHERE mail = ?");
            $insertdate->execute(array($birthday, $_SESSION['mail']));

            header("Location: welcome.php");
        }
        else
        {
            $erreurprincipal = "Tous les champs doivent être complétés !";
        }
    }
?>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/style-register-profil.css" />
	    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
        <!-- <link rel="icon" type="images/png" sizes="16x16" href="#.png" /> -->
	    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
        <title>Inscription</title>
    </head>
    <body>
        <div class="background">
            <div class="outer">
                <div class="loader"></div>
                <div class="text">
                    <span>Chargement</span>
                </div>
            </div>
        </div>
        <script src="js/loader.js"></script>

        <?php require "navbar-register.html"; ?>

        <div class="login-content">
            <form method="POST" action="">
            <p class="step">Étape 2 sur 2</p>
                <h2 class="title">Créer votre profil</h2>
                <p class="subtitle">Suivez ces étapes pour de vos films préféré quand vous le souhaiter.</p>
                <br/>
                <div class="input-div one">
                    <div class="i">
                        <!-- <i class="fas fa-at"></i> -->
                    </div>
                    <div class="div">
                        <h5>Prénom</h5>
                        <input type="text" class="input" name="prenom" />
                    </div>
                </div>
                <div class="input-div two">
                    <div class="i">
                        <!-- <i class="fas fa-at"></i> -->
                    </div>
                    <div class="div">
                        <h5>Nom</h5>
                        <input type="text" class="input" name="nom" />
                    </div>
                </div>
                <div class="input-div pass">
                    <div class="i">
                        <i class="fas fa-birthday-cake"></i>
                    </div>
                    <div class="div">
                        <h6>Date de naissance</h6>
                        <input type="date" id="date" class="input" name="birthday" max=""/>
                    </div>
                </div>
				<input type="submit" class="btn" name="forminscription" value="Terminer mon inscription !"/>
                <div class="erreurprincipal">
                    <?php
				        if(isset($erreurprincipal))
				        {
					        echo $erreurprincipal;
				        }
                    ?>
                </div>
            </form>
        </div>
        <script src='js/date.js' async></script>
        <script type="text/javascript" src="js/main.js"></script>
    </body>
</html>

<?php
}
else{
    header("Location: register.php");
}
?>