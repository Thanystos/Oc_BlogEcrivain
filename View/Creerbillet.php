<?php if($_SESSION['role']!= 2) {
    header('Location: index?action=listBillets='.$_SESSION['id_billet']);
} ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Création d'un nouveau billet</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="Public/CSS/Main.css">
    </head>
    <body>
        <div class="container-fluid">
            <div class="row content">
                <?php include 'nav.php'; ?>
                <div class="col-sm-9">
                    <h4><small>CRÉATION BILLET</small></h4>
                    <hr>
                    <h4>Créer un nouveau billet :</h4>
                    <form id="envoi" method="post" action="index.php?action=creerBillet">
                        <div class="form-group text-center">
                            <label for="titre">Titre du nouveau billet : </label>
                            <br>
                            <input type="text" name="titre" id="titre" />
                            <br><br>
                            <textarea class="form-control" name="text" id="comm"></textarea>
                        </div>
                        <input type="submit" class="btn btn-success" value="Publier" />
                    </form>
                </div>
            </div>
        </div>
        <?php include 'footer.php'; ?>
        <script src="Public/JS/tinymce/tinymce.min.js"></script>
        <script type="text/javascript">
            tinymce.init({
                selector:'textarea', language : 'fr_FR', forced_root_block : false, force_br_newlines : true, force_p_newlines : false
            });
        </script>
        <script type="text/javascript">
            $(".nav li:nth-child(2)").addClass('active');
        </script>
    </body>
</html>