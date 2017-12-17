<?php $this->title = 'Liste des signalements'; ?>
<div class="col-sm-8 col-sm-offset-1">
    <h4><small>LISTE DES SIGNALEMENTS</small></h4>
    <hr>
</div>
<div class="col-sm-8 col-sm-offset-1" style="background-color: white; padding: 15px;">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Billet</th>
                <th>Commentaire</th>
                <th>Écrit par</th>
                <th>Signalé par</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php while (($comment = $requestComments->fetch()) && ($report = $requestReports->fetch())) { ?>
                <tr>
                    <th><?= $comment['title']; ?></th>
                    <th><?= $comment['text']; ?></th>
                    <th><a href="listeutilisateurs.html#<?= $comment['pseudo']; ?>"><?= $comment['pseudo']; ?></a></th>
                    <th><a href="listeutilisateurs.html#<?= $report['pseudo']; ?>"><?= $report['pseudo']; ?></a></th>
                    <th>
                        <form id="supprimer" method="post" action="suppcommentaire_<?= $comment['id']; ?>-list.html">
                            <input type="submit" class="btn btn-danger" value="SUPPRIMER" />
                        </form>
                    </th>
                </tr>
            <?php }
            $requestComments->closeCursor();
            $requestReports->closeCursor(); ?>
        </tbody>
    </table>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".nav li:nth-child(4)").addClass('active');
        $('title').html(<?= json_encode($this->title); ?>);
    });
</script>