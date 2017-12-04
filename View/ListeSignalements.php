<!DOCTYPE html>
<html>
    <head>
        <title>Liste des signalements</title>
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
                    <h4><small>LISTE DES SIGNALEMENTS</small></h4>
                    <hr>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Billet</th>
                                <th>Commentaire</th>
                                <th>Signalé par</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($commentaire = $requete->fetch()) { ?>
                            <tr>
                                <th><?php echo $commentaire['titre']; ?></th>
                                <th><?php echo $commentaire['text']; ?></th>
                                <th><?php echo $commentaire['pseudo']; ?></th>
                                <th>
                                    <form method="post" action="index.php?action=unibillet&id_billet=<?php echo $commentaire['id']; ?>">
                                        <input type="submit" class="btn btn-info" value="VOIR PAGE" />
                                    </form>
                                </th>
                            </tr>
                            <?php } 
                            $requete->closeCursor(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php include 'footer.php'; ?>
        <script type="text/javascript">
            $(document).ready(function () {
                $(".nav li:nth-child(4)").addClass('active');   
            });
        </script>
        