<!DOCTYPE html>
<html>
    <head>
        <title>Derniers billets</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="Public/CSS/Main.css">
    </head>
    <body>
        <div class="container-fluid">
            <div class="row content">
                <div class="col-sm-9">
                    <h4><small>DERNIERS BILLETS</small></h4>
                    <hr>
                    <?php while ($billet = $requete->fetch()) { ?>
                    <div class="billets">
                        <h2><a href="billet_<?php echo $billet['id']; ?>.html"><?php echo htmlspecialchars($billet['titre']); ?></a></h2>
                        <h5><span class="glyphicon glyphicon-time"></span> Publié par <?php echo $billet['pseudo']; ?> le <?php echo $billet['date_post']; ?>.</h5>
                        <p><?php echo nl2br(htmlspecialchars(resume($billet['text']))); ?></p>
                        <br><br>
                    </div>
                    <?php }
                    $requete->closeCursor(); ?>
                </div>
            </div>
        </div>
        <?php include 'footer.php'; ?>
        <script type="text/javascript">
            $(".nav li:nth-child(1)").addClass('active');
        </script>