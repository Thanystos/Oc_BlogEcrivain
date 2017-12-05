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
                    <?php while ($ticket = $request->fetch()) { ?>
                    <div class="ticket">
                        <h2><a href="billet_<?php echo $ticket['id']; ?>.html"><?php echo htmlspecialchars($ticket['title']); ?></a></h2>
                        <h5><span class="glyphicon glyphicon-time"></span> Publié par <?php echo $ticket['pseudo']; ?> le <?php echo $ticket['post_date']; ?>.</h5>
                        <p><?php echo nl2br(htmlspecialchars(resume($ticket['text']))); ?></p>
                        <br><br>
                    </div>
                    <?php }
                    $request->closeCursor(); ?>
                </div>
            </div>
        </div>
        <?php include 'footer.php'; ?>
        <script type="text/javascript">
            $(".nav li:nth-child(1)").addClass('active');
        </script>