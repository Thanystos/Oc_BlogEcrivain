
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="Public/CSS/Main.css">
    </head>
    <body>
        <div class="container-fluid">
            <div class="row content">
                <div class="col-sm-3 sidenav">
                    <h4>Le blog de l'écrivain</h4>
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="listebillets.html">Liste des billets</a></li>
                        <?php if((isset($_SESSION['pseudo']))&&($_SESSION['role'] == 2)) { ?>
                        <li><a href="creationbillet.html">Créer billet</a></li>
                        <li><a href="listeutilisateurs.html">Liste utilisateurs</a></li>
                        <li><a href="listesignalements.html">Liste signalements</a></li>
                        <?php } ?>
                        <li><?php if(isset($_SESSION['pseudo'])){ ?>
                                    <a href="deconnexion.html">Se Déconnecter</a>
                                <?php }
                                else { ?>
                                    <a href="formulaireconnexion.html">Se Connecter</a>
                                <?php } ?>
                        </li>       
                    </ul><br>
                    <?php if(isset($_SESSION['pseudo'])){ ?>
                        <div class="text-center">
                            <h3><a href="profil_<?php echo $_SESSION['pseudo']; ?>.html"><?php echo $_SESSION['pseudo']; ?></a></h3>
                            <a href="profil_<?php echo $_SESSION['pseudo']; ?>.html"><img src="Public/Images/<?php echo $_SESSION['pseudo']; ?>/<?php echo $_SESSION['image']; ?>" class="img-circle" height="65" width="65" alt="Avatar"></a>
                        </div>
                    <?php } ?>
                </div>