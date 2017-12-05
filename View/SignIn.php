<!DOCTYPE html>
<html>
    <head>
        <title>Page de Connexion</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="Public/CSS/Main.css">
        <link rel="stylesheet" href="Public/CSS/Connexion.css">
    </head>
    
    <body>
        <div class="container-fluid">
            <div class="row content">
                <?php include 'nav.php'; ?>
                <div class="col-sm-9">
                    <h4><small>CONNEXION</small></h4>
                    <hr>
                    <div class="imgcontainer">
                        <img src="Public/Images/avatar.png" alt="Avatar" class="avatar">
                    </div>
                    <form method="post" action="index.html">
                        <div class="container">
                            <label><b>Identifiant</b></label>
                            <input type="text" placeholder="Entrez votre identifiant" name="pseudo" required>

                            <label><b>Mot de Passe</b></label>
                            <input type="password" placeholder="Entrez votre mot de passe" name="password" required>

                            <button type="submit" class="submitconnexion">Se connecter</button>
                        </div>
                    </form>

                    <form method="post" action="inscription.html">
                        <div class="container">
                            <button type="submit" class="inscription">Inscription</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php include 'footer.php';