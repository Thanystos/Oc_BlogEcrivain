                <?php include 'nav.php'; ?>
                <div class="col-sm-9">
                    <?php $infos = $requestInfos->fetch(); ?>
                    <h4><small>Page de profil : <?php $infos['pseudo']; ?></small></h4>
                    <hr>
                    <h4>Informations de profil :</h4>
                    <div class="infos">
                        E-mail : <?php echo $infos['email']; ?>
                        Image : <img src="Public/Images/<?php echo $infos['image']; ?>" class="img-circle" height="65" width="65" alt="Avatar">
                        Signalé : <?php echo $infos['nb_report']; ?> fois
                    </div>
                    <h4>Contributions :</h4>
                    <div class="comment">
                        <?php while ($comment = $requestComments->fetch()) { ?>
                            <h4>BILLET</h4>
                            <h2><?php echo html_entity_decode(htmlspecialchars($comment['title'])); ?></a></h2>
                            <h5><span class="glyphicon glyphicon-time"></span> Publié le <?php echo $comment['tpost_date']; ?>.</h5>
                        <?php }
