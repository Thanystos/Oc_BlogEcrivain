<!DOCTYPE html>
<html>
    <head>
        <title>Liste des utilisateurs</title>
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
                    <h4><small>LISTE DES UTILISATEURS</small></h4>
                    <hr>
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
                                <th><?php echo $user['pseudo']; ?></th>
                                <th><?php echo $user['email']; ?></th>
                                <th><?php echo $user['image']; ?></th>
                                <th><?php if($user['role'] == 1) {
                                            echo 'Utilisateur';
                                          }
                                          else {
                                            echo 'Administrateur';
                                          } ?>
                                </th>
                                <th><?php echo $user['nb_report']; ?> fois</th>
                                <th>
                                <?php if($user['role'] == 1) { ?>
                                    <form method="post" action="changestatut_<?php echo $user['id']; ?>.html">
                                        <?php if(!$user['ban']) { ?>
                                            <input type="submit" class="btn btn-danger" value="BANNIR" />
                                        <?php } else { ?>
                                            <input type="submit" class="btn btn-success" value="RESTAURER" />
                                        <?php } ?>
                                    </form>
                                <?php } ?>
                                </th>
                                <th>
                                    <form id="supprimer" method="post" action="supputilisateur_<?php echo $user['id'] ?>-<?php echo $user['image']; ?>.html">
                                        <input type="submit" class="btn btn-danger" value="SUPPRIMER" />
                                    </form>
                                </th>
                            </tr>
                            <?php } 
                            $request->closeCursor(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php include 'footer.php'; ?>
        <script type="text/javascript">
            $(document).ready(function () {
                $(".nav li:nth-child(3)").addClass('active');   
            });
        </script>