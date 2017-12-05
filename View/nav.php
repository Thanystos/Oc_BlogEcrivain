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
                    <a href="connexion.html">Se Connecter</a>
                <?php } ?>
        </li>       
    </ul><br>
    <?php if(isset($_SESSION['pseudo'])){ ?>
        <div class="text-center">
            <h3><?php echo $_SESSION['pseudo']; ?></h3>
            <img src="Public/Images/<?php echo $_SESSION['image']; ?>" class="img-circle" height="65" width="65" alt="Avatar">
        </div>
    <?php } ?>
</div>

