                <?php include 'nav.php'; ?>
                <div class="col-sm-9">
                    <h4><small>LISTE DES SIGNALEMENTS</small></h4>
                    <hr>
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
                                <th><?php echo $comment['title']; ?></th>
                                <th><?php echo $comment['text']; ?></th>
                                <th><a href="listeutilisateurs.html#<?php echo $comment['pseudo']; ?>"><?php echo $comment['pseudo']; ?></a></th>
                                <th><a href="listeutilisateurs.html#<?php echo $report['pseudo']; ?>"><?php echo $report['pseudo']; ?></a></th>
                                <th>
                                    <form id="supprimer" method="post" action="suppcommentaire_<?php echo $comment['id']; ?>.html">
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
            </div>
        </div>
        <?php include 'footer.php'; ?>
        <script type="text/javascript">
            $(document).ready(function () {
                $(".nav li:nth-child(4)").addClass('active');
                $('title').html('Liste des signalements');
            });
        </script>
        
