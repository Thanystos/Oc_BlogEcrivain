<!DOCTYPE html>
<html>
    <head>
        <title>Page d'inscription</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="Public/CSS/Main.css">
        <link rel="stylesheet" href="Public/CSS/Inscription.css" />
        <link rel="stylesheet" href="Public/CSS/Connexion.css">
    </head>
<body>
        <div class="container-fluid">
            <div class="row content">
                <?php include 'nav.php'; ?>
                <div class="col-sm-9">
                    <h4><small>INSCRIPTION</small></h4>

                    <div class="imgcontainer">
                        <img src="Public/Images/avatar.png" alt="Avatar" class="avatar">
                    </div>
                    <form method="post" action="index.html" enctype="multipart/form-data">
                        <div class="container">
                            <label><b>Identifiant</b></label>
                            <input type="text" placeholder="Entrez votre identifiant" class="champ" name="pseudo" required>

                            <label><b>Adresse E-mail</b></label>
                            <input type="text" placeholder="Entrez votre Adreese E-mail" id="email" name="email" required>

                            <label><b>Mot de Passe</b></label>
                            <input type="password" placeholder="Entrez votre mot de passe" class="champ" name="password" required>

                            <label for="image"><b>Image de profil</b></label>
                            <input type="file" name="image" id="image" />

                            <button type="submit">Valider inscription</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php include 'footer.php'; ?>
    <script src="Public/JS/Inscription.js"></script>
