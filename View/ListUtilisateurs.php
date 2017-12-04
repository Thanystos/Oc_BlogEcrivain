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
                            <?php while ($utilisateur = $requete->fetch()) { ?>
                            <tr>
                                <th><?php echo $utilisateur['pseudo']; ?></th>
                                <th><?php echo $utilisateur['email']; ?></th>
                                <th><?php echo $utilisateur['image']; ?></th>
                                <th><?php if($utilisateur['role'] == 1) {
                                            echo 'Utilisateur';
                                          }
                                          else {
                                            echo 'Administrateur';
                                          } ?>
                                </th>
                                <th><?php echo $utilisateur['nb_signal']; ?> fois</th>
                                <th>
                                <?php if($utilisateur['role'] == 1) { ?>
                                    <form method="post" action="index.php?action=updateStatus&id_utilisateur=<?php echo $utilisateur['id']; ?>">
                                        <?php if(!$utilisateur['ban']) { ?>
                                            <input type="submit" class="btn btn-danger" value="BANNIR" />
                                        <?php } else { ?>
                                            <input type="submit" class="btn btn-success" value="RESTAURER" />
                                        <?php } ?>
                                    </form>
                                <?php } ?>
                                </th>
                                <th>
                                    <form id="supprimer" method="post" action="index.php?action=suppUtilisateur&id=<?php echo $utilisateur['id'] ?>&image=<?php echo $utilisateur['image']; ?>">
                                        <input type="submit" class="btn btn-danger" value="SUPPRIMER" />
                                    </form>
                                </th>
                            </tr>
                            <?php } 
                            $requete->closeCursor(); ?>
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