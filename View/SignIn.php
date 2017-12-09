                <?php if(isset($_SESSION['erreur'])) { ?>
                    <script>
                        var session = eval('(<?php echo json_encode($_SESSION) ?>)');
                        alert(session.erreur);
                    </script>
                <?php 
                    unset($_SESSION['erreur']);
                } ?>
                <link rel="stylesheet" href="Public/CSS/Connexion.css">
                <?php include 'nav.php'; ?>
                <div class="col-sm-9">
                    <h4><small>CONNEXION</small></h4>
                    <hr>
                    <div class="imgcontainer">
                        <img src="Public/Images/avatar.png" alt="Avatar" class="avatar">
                    </div>
                    <form method="post" action="index.html">
                        <div class="container">
                            <label><b>Identifiant</b></label>
                            <input type="text" placeholder="Entrez votre identifiant" name="pseudo" required>

                            <label><b>Mot de Passe</b></label>
                            <input type="password" placeholder="Entrez votre mot de passe" name="password" required>

                            <button type="submit" class="submitconnexion">Se connecter</button>
                        </div>
                    </form>

                    <form method="post" action="inscription.html">
                        <div class="container">
                            <button type="submit" class="inscription">Inscription</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php include 'footer.php'; ?>
        <script type="text/javascript">
            $('.nav li:nth-child(2)').addClass('active');
            $('title').html('Page de connexion');
        </script>