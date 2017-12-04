<?php
// Requête contenant les informations liées au billet
$billet = $requeteBillet->fetch();
$_SESSION['id_billet'] = $billet['id'];

// Récupération des informations de la requête liée au commentaires signalés par l'utilisateur en cours
if ($requeteSignalement) {
    $sigtab = array();
    while ($signalement = $requeteSignalement->fetch()) {
        array_push($sigtab, $signalement['id_commentaire']);
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Affichage de l'article <?php $billet['titre']; ?></title>
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
                    <h4><small>BILLET UNIQUE</small></h4>
                    <hr>
                    <div class="billet">
                        <h2><?php echo htmlspecialchars($billet['titre']); ?></h2>
                        <h5><span class="glyphicon glyphicon-time"></span> Publié par <?php echo $billet['pseudo']; ?> le <?php echo $billet['date_post']; ?>.</h5>
                        <div class="billetcontent">
                            <?php echo nl2br(htmlspecialchars($billet['text'])); ?>
                            <br><br>
                            <?php if ((isset($_SESSION['role'])) && ($_SESSION['role'] == 2)) { ?>
                                <input type="button" class="btn btn-warning modifier" value="Modifier" />
                                <form method="post" action="index.php?action=suppBillet" style="display: inline-block">
                                    <input type="submit" class="btn btn-danger supprimerbillet" value="Supprimer" />
                                </form>
                                <br><br>
                            <?php } ?>
                        </div>
                        <div class="edit">
                            <form method="post" action="index.php?action=modifBillet">
                                <textarea name="text"><?php echo $billet['text']; ?></textarea>
                                <br>
                                <input type="submit" class="btn btn-success" value="Modifier" />
                                <input type="button" class="btn btn-danger annuler" value="Retour" />
                            </form>
                        </div>
                    </div>
                    <?php $requeteBillet->closeCursor();
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
                        <form method="post" action="index.php?action=ajoutCommentaire">
                            <div class="form-group">
                                <textarea class="form-control" name="comm"></textarea>
                            </div>
                            <input type="submit" class="btn btn-success" value="Poster" />
                        </form>
                    <?php } else { ?>
                        <h4>Connectez-vous pour commenter !</h4>
                    <?php } ?>
                    <br><br>
                    <p>
                        <span class="badge">
                            <?php $nbcomm = $requeteNbCommentaire->fetch();
                            echo $nbcomm[0]; ?>
                        </span> Commentaires :
                    </p>
                    <br>
                    
                    <?php while ($commentaire = $requeteCommentaire->fetch()) { ?>
                        <div class="row">
                            <div class="col-sm-2 text-center">
                                <img src="Public/Images/<?php echo $commentaire['image']; ?>" class="img-circle" height="65" width="65" alt="Avatar">
                            </div>
                            <div class="col-sm-10">
                                <h4><?php echo $commentaire['pseudo']; ?><small> <?php echo $commentaire['date_post']; ?></small></h4>
                                <div class="comm">
                                    <?php echo nl2br(htmlspecialchars($commentaire['text'])); ?>
                                    <br><br>
                                    <?php if ((isset($_SESSION['pseudo'])) && ($_SESSION['pseudo'] == $commentaire['pseudo'])) { ?>
                                        <input type="button" class="btn btn-warning modifier" value="Modifier" />
                                        <form method="post" action="index.php?action=suppCommentaire&id_commentaire=<?php echo $commentaire['id']; ?>" style="display: inline-block">
                                            <input type="submit" class="btn btn-danger supprimercomm" value="Supprimer" />
                                        </form>
                                    </div>
                                    <div class="edit">
                                        <form method="post" action="index.php?action=modifCommentaire&id_commentaire=<?php echo $commentaire['id']; ?>">
                                            <textarea name="text"><?php echo $commentaire['text']; ?></textarea>
                                            <br>
                                            <input type="submit" class="btn btn-success" value="Modifier" />
                                            <input type="button" class="btn btn-danger annuler" value="Retour" />
                                        </form>
                                    </div>
                                <?php } elseif (isset($_SESSION['pseudo']) && ($_SESSION['role'] == 1) && (!in_array($commentaire['id'], $sigtab))) { ?>
                                    <form method="post" action="index.php?action=signaler&id_commentaire=<?php echo $commentaire['id']; ?>&pseudo=<?php echo $commentaire['pseudo']; ?>">
                                        <input type="submit" class="btn btn-danger" value="Signaler" />
                                    </form>
                                </div>
                                <?php } elseif (isset($_SESSION['pseudo']) && ($_SESSION['role'] == 1) && (in_array($commentaire['id'], $sigtab))) { ?>
                                    <input type="button" class="btn btn-info" value="Signalé !" disabled="disabled" />
                                </div>
                                <?php } elseif (isset($_SESSION['pseudo']) && ($_SESSION['role'] == 2)) { ?>
                                    <form method="post" action="index.php?action=suppCommentaire&id_commentaire=<?php echo $commentaire['id']; ?>" style="display: inline-block">
                                        <input type="submit" class="btn btn-danger supprimercomm" value="Supprimer" />
                                    </form>
                                </div>
                                <?php } else { ?>
                                </div> <?php } ?>
                            </div>
                        </div>
                        <br><br>
                    <?php } ?>
                    <?php $requeteCommentaire->closeCursor(); ?>
                </div>
            </div>
        </div>
        <?php include 'footer.php'; ?>
        <script src="Public/JS/tinymce/tinymce.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                tinymce.init({
                    selector: 'textarea', language: 'fr_FR', forced_root_block: false, force_br_newlines: true, force_p_newlines: false
                });
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('.modifier').click(function () {
                    $(this).parent().css('display', 'none');
                    $(this).parent().next().css('display', 'block');
                });

                $('.annuler').click(function () {
                    $(this).parent().parent().css('display', 'none');
                    $(this).parent().parent().prev().css('display', 'block');
                });
            });
        </script>