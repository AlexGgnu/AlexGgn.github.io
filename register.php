<!-- © MyFideal by Alexis Gagneau -->
<!-- © Logos by Timéo Privitera -->

<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=myfideal', 'root', '');

if(isset($_POST['forminscription']))
{
    $mail = htmlspecialchars($_POST['mail']);
    $mdp = ($_POST['mdp']);

    if(!empty($_POST['mail']) AND !empty($_POST['mdp']))
    {
        if(filter_var($mail, FILTER_VALIDATE_EMAIL))
        {
            $reqmail = $bdd->prepare("SELECT * FROM membres WHERE mail = ?");
            $reqmail->execute(array($mail));
            $mailexist = $reqmail->rowCount();

            if($mailexist == 0)
            {
                $mdplenght = strlen($mdp);

                if($mdplenght >= 8)
                {
                    $mdp = sha1($_POST['mdp']);
                    $_SESSION ['mdp'] = $mdp;
                    $_SESSION['mail'] = $mail;
                    $insertmbr = $bdd->prepare("INSERT INTO membres(pseudo, prenom, nom, birthday, mail, motdepasse) VALUES(?, ?, ?, ?, ?, ?)");
                    $insertmbr->execute(array("", "", "", "2006-01-10", $mail, $mdp));

                    header("Location: register-profil.php");
                }
                else
                {
                    $erreurmdp = "Votre mot de passe doit contenir plus de 8 caractères !";
                }
            }
            else
            {
                $erreurmail = "Cette adresse mail est déjà utilisée !";
            }
        }
        else
        {
            $erreurmail = "Votre adresse mail n'est pas valide !";
        }
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
        <link rel="stylesheet" href="css/style-register.css" />
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
            <p class="step">Étape 1 sur 2</p>
            <br/>
                <h2 class="title">L'inscription ne prendra que quelques minutes.</h2>
                <p class="subtitle">Suivez ces étape pour ensuite profiter de vos film préféré quand vous le souhaiter.</p>
                <br/><br/>
                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-at"></i>
                    </div>
                    <div class="div">
                        <h5>E-mail</h5>
                        <input type="email" class="input" name="mail" />
                    </div>
                </div>
                <div class="erreur">
                    <?php
                        if(isset($erreurmail))
                        {
                            echo $erreurmail;
                        }
                    ?>
                </div>
           		<div class="input-div pass">
           		   <div class="i"> 
           		    	<i class="fas fa-lock"></i>
           		   </div>
           		   <div class="div">
           		    	<h5>Mot de passe</h5>
						<input type="password" class="input" name="mdp"/>
                        <div class="password-icon">
                            <i data-feather="eye"></i>
                            <i data-feather="eye-off"></i>
                        </div>
            	   </div>
            	</div>
                <div class="erreur">
                    <?php
				        if(isset($erreurmdp))
				        {
					        echo $erreurmdp;
				        }
				    ?>
                </div>
				<input type="submit" class="btn" name="forminscription" value="Suivant"/>
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
        <script src="https://unpkg.com/feather-icons"></script>
        <script>
            feather.replace();
        </script>
        <script type="text/javascript" src="js/eyes-mdp.js"></script>
        <script type="text/javascript" src="js/main.js"></script>          
    </body>
</html>