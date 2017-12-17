<?php $this->title = 'Liste des derniers billets'; ?>
<div class="col-sm-8 col-sm-offset-1">
    <h4><small>DERNIERS BILLETS</small></h4>
    <hr>
    <?php foreach ($request as $ticket) : ?>
        <div class="ticket" style="background-color: white; padding: 10px; margin-bottom: 20px;">
            <h2><a href="billet_<?= $ticket['id']; ?>.html"><?= html_entity_decode(htmlspecialchars($ticket['title'])); ?></a></h2>
            <h5><span class="glyphicon glyphicon-time"></span> Publié par <a href="profil_<?= $ticket['pseudo']; ?>.html"><?= $ticket['pseudo']; ?></a> le <?= $ticket['post_date']; ?>.</h5>
            <p><?= nl2br(html_entity_decode(htmlspecialchars(resume($ticket['text'])))); ?></p>
            <br><br>
        </div>
    <?php endforeach; ?>
    <div class="navigation text-center">
        <ul class="pagination pagination-lg">
            <?php for($i=1; $i<=$_SESSION['nbPageTicket']; $i++) { ?>
                <li><a href="listebillets_<?= $i; ?>.html"><?= $i; ?></a></li>
            <?php } ?>
        </ul>
    </div>
    
    <?php if(!isset($_SESSION['welcome'])) { ?>
        <div class="container welcome" style="height: 2000px; width: 100%; position: absolute; top: 0px; left:0px; padding-top: 15px; background-color: white; z-index: 10; text-align: center;">
            <h1 style="margin-bottom: 20px;">Bienvenue sur le blog de Jean Forteroche !</h1>
            <img src="Public/Images/livre.png"/><br>
            <div class="presentation" style="margin: 15px 0px 15px 0px;">
                Souhaitant innover, le célèbre ecrivain Jean Forteroche vous propose aujourd'hui de publier périodiquement et 
                chapitre par chapitre, le contenu de son tout dernier roman :<br><br>
                <strong>"Billet simple pour l'Alaska"</strong><br><br>
                Venez le découvrir en avant-première et connectez-vous afin d'en donner votre avis !                   
            </div>
            <form method="post" action="listebillets.html">
                <input type="submit" class="btn btn-success" value="Continuer" />
            </form>
    <?php $_SESSION['welcome'] = true; } ?>
        </div>
</div>
<script type="text/javascript">
    $(".nav li:nth-child(1)").addClass('active');
    $('title').html(<?= json_encode($this->title); ?>);
</script>