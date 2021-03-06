<?php $this->title = 'Affichage d\'un billet';
    // Requête contenant les informations liées au billet
    $ticket = $requestTicket->fetch();
    $_SESSION['id_ticket'] = $ticket['id'];

    // Récupération des informations de la requête liée au commentaires signalés par l'utilisateur en cours
    if ($requestReports) {
        $reportsTab = array();
        while ($report = $requestReports->fetch()) {
            array_push($reportsTab, $report['id_comment']);
        }
    }
    //ob_start();
?>
<div class="col-sm-8 col-sm-offset-1">
    <h4><small>BILLET UNIQUE</small></h4>
    <hr>
</div>
<div class="col-sm-8 col-sm-offset-1" style="background-color: white;">
    <div class="billet">
        <h2><?= html_entity_decode(htmlspecialchars($ticket['title'])); ?></h2>
        <h5><span class="glyphicon glyphicon-time"></span> Publié par <a href="profil_<?= $ticket['pseudo']; ?>.html"><?= $ticket['pseudo']; ?></a> le <?= $ticket['post_date']; ?>.</h5>
        <div class="billetcontent">
            <?= nl2br(html_entity_decode((htmlspecialchars($ticket['text'])))); ?>
            <br><br>
            <?php if ((isset($_SESSION['role'])) && ($_SESSION['role'] == 2)) { ?>
                <input type="button" class="btn btn-warning update" value="Modifier" />
                <form method="post" action="suppbillet.html" style="display: inline-block">
                    <input type="submit" class="btn btn-danger" value="Supprimer" />
                </form>
                <br><br>
            <?php } ?>
        </div>
        <div class="edit">
            <form method="post" action="modifbillet.html">
                <textarea name="text"><?= $ticket['text']; ?></textarea>
                <br>
                <input type="submit" class="btn btn-success" value="Modifier" />
                <input type="button" class="btn btn-danger cancel" value="Retour" />
            </form>
        </div>
    </div>
    <?php $requestTicket->closeCursor();
    if(isset($_SESSION['ban']) && ($_SESSION['ban'] == 1)) { ?>
        <h4>Laisser un commentaire :</h4>
        <div class="ban" style="text-align: center">
            <h4>COMPTE BANNI !</h4>

            <img src='Public/Images/ban.jpg' style="width: 10%; height: auto;"/>
            <br><br>
            <p>Il semblerait que vous n'ayez pas respecté les règles d'utilisation de l'espace commentaire.<br>
            De ce fait, et jusqu'à nouvel ordre nous vous retirons la possibilité de poster des commentaires.<br>
            Pour en savoir plus, merci de contacter un administrateur. 
            </p>
        </div>
    <?php } elseif (isset($_SESSION['pseudo'])) { ?>
        <h4>Laisser un commentaire :</h4>
        <form method="post" action="ajoutcommentaire.html">
            <div class="form-group">
                <textarea class="form-control" name="comment"></textarea>
            </div>
            <input type="submit" class="btn btn-success" value="Poster" />
        </form>
    <?php } else { ?>
        <h4>Connectez-vous pour commenter !</h4>
    <?php } ?>
    <br><br>
    <p>
        <span class="badge">
            <?= $nbComments[0]; ?>
        </span> Commentaires :
    </p>
    <br>
    <?php while ($comment = $requestComments->fetch()) { ?>
        <div class="row">
            <div class="col-sm-2 text-center">
                <a href="profil_<?= $comment['pseudo']; ?>.html">
                    <img src="Public/Images/<?= $comment['pseudo']; ?>/<?= $comment['image']; ?>" class="img-circle" height="65" width="65" alt="Avatar">
                </a>
            </div>
            <div class="col-sm-10 colcss">
                <h4><a href="profil_<?= $comment['pseudo']; ?>.html"><?= $comment['pseudo']; ?></a><small> Le <?= $comment['post_date']; ?></small></h4>
                <div class="comm">
                    <?= nl2br(html_entity_decode(htmlspecialchars($comment['text']))); ?>
                    <br><br>
                    <?php if ((isset($_SESSION['pseudo'])) && ($_SESSION['pseudo'] == $comment['pseudo'])) { ?>
                        <input type="button" class="btn btn-warning update" value="Modifier" />
                        <form method="post" action="suppcommentaire_<?= $comment['id']; ?>.html" style="display: inline-block">
                            <input type="submit" class="btn btn-danger" value="Supprimer" />
                        </form>
                </div>
                        <div class="edit">
                            <form method="post" action="modifcommentaire_<?= $comment['id']; ?>.html">
                                <textarea name="text"><?= $comment['text']; ?></textarea>
                                <br>
                                <input type="submit" class="btn btn-success" value="Modifier" />
                                <input type="button" class="btn btn-danger cancel" value="Retour" />
                            </form>
                        </div>
                    <?php } elseif (isset($_SESSION['pseudo']) && ($_SESSION['role'] == 1) && (!in_array($comment['id'], $reportsTab))) { ?>
                        <form method="post" action="signaler_<?= $comment['id']; ?>-<?= $comment['pseudo']; ?>.html">
                            <input type="submit" class="btn btn-danger" value="Signaler" />
                        </form>
            </div>
                    <?php } elseif (isset($_SESSION['pseudo']) && ($_SESSION['role'] == 1) && (in_array($comment['id'], $reportsTab))) { ?>
                        <input type="button" class="btn btn-info" value="Signalé !" disabled="disabled" />
        </div>
                    <?php } elseif (isset($_SESSION['pseudo']) && ($_SESSION['role'] == 2)) { ?>
                        <form method="post" action="suppcommentaire_<?= $comment['id']; ?>.html" style="display: inline-block">
                            <input type="submit" class="btn btn-danger" value="Supprimer" />
                        </form>
</div>
                    <?php } else { ?>
                    </div> <?php } ?>
                            </div>
                    </div>
                    <br><br>
    <?php } ?>
                    <?php $requestComments->closeCursor(); ?>
                    <div class="navigation text-center">
                        <ul class="pagination pagination-lg">
                            <?php for($i=1; $i<=$_SESSION['nbPageComment']; $i++) { ?>
                                <li><a href="billet_<?= $_SESSION['id_ticket']; ?>-<?= $i; ?>.html"><?= $i; ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <script src="Public/JS/tinymce/tinymce.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                tinymce.init({
                     selector: 'textarea', language: 'fr_FR', forced_root_block: false, force_br_newlines: true, force_p_newlines: false, entity_encoding : 'raw', encoding: 'UTF-8'
                });
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('title').html('Affichage d\'un billet');
                $('.update').click(function () {
                    $(this).parent().css('display', 'none');
                    $(this).parent().next().css('display', 'block');
                });

                $('.cancel').click(function () {
                    $(this).parent().parent().css('display', 'none');
                    $(this).parent().parent().prev().css('display', 'block');
                });
            });
        </script>
        
        