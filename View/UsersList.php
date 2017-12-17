<?php $this->title = 'Création d`\'un nouveau billet'; ?>
<div class="col-sm-8 col-sm-offset-1">
    <h4><small>LISTE DES UTILISATEURS</small></h4>
    <hr>
</div>
<div class="col-sm-8 col-sm-offset-1" style="background-color: white; padding: 15px;">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Pseudo</th>
                <th>Email</th>
                <th>Image</th>
                <th>Rôle</th>
                <th>Signalé</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php while ($user = $request->fetch()) { ?>
                <tr>
                    <th id="<?= $user['pseudo']; ?>"><a href="profil_<?= $user['pseudo']; ?>.html"><?= $user['pseudo']; ?></a></th>
                    <th><?= $user['email']; ?></th>
                    <th><?= $user['image']; ?></th>
                    <th><?php if($user['role'] == 1) {
                        echo 'Utilisateur';
                    }
                    else {
                        echo 'Administrateur';
                    } ?>
                    </th>
                    <th><?= $user['nb_report']; ?> fois</th>
                    <th>
                        <?php if($user['role'] == 1) { ?>
                            <form method="post" action="changestatut_<?= $user['id']; ?>.html">
                                <?php if(!$user['ban']) { ?>
                                    <input type="submit" class="btn btn-danger" value="BANNIR" />
                                <?php } else { ?>
                                    <input type="submit" class="btn btn-success" value="RESTAURER" />
                                <?php } ?>
                            </form>
                        <?php } ?>
                    </th>
                    <th>
                        <form id="supprimer" method="post" action="supputilisateur_<?= $user['id'] ?>-<?= $user['pseudo']; ?>.html">
                            <input type="submit" class="btn btn-danger" value="SUPPRIMER" />
                        </form>
                    </th>
                </tr>
            <?php } 
            $request->closeCursor(); ?>
        </tbody>
    </table>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".nav li:nth-child(3)").addClass('active');
        $('title').html(<?= json_encode($this->title); ?>);
    });
</script>