                <?php if(isset($_SESSION['error'])) { ?>
                    <script>
                        var session = eval('(<?php echo json_encode($_SESSION) ?>)');
                        alert(session.error);
                    </script>
                <?php 
                    unset($_SESSION['error']);
                } ?>
                <link rel="stylesheet" href="Public/CSS/SignIn.css">
                <?php include 'nav.php'; ?>
                <div class="col-sm-9">
                    <h4><small>INSCRIPTION</small></h4>
                    <hr>
                    <div class="imgcontainer">
                        <img src="Public/Images/avatar.png" alt="Avatar" class="avatar">
                    </div>
                    <form id="send" method="post" action="inscription.html" enctype="multipart/form-data">
                        <div class="container">
                            <label><b>Identifiant</b></label>
                            <input type="text" placeholder="Entrez votre identifiant" class="field" name="pseudo" required>

                            <label><b>Adresse E-mail</b></label>
                            <input type="text" placeholder="Entrez votre Adreese E-mail" id="email" name="email" required>

                            <label><b>Mot de Passe</b></label>
                            <input type="password" placeholder="Entrez votre mot de passe" class="field" name="password" required>

                            <label for="image"><b>Image de profil</b></label>
                            <input type="file" name="image" id="image" />
                            <br>

                            <button type="submit">Valider inscription</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php include 'footer.php'; ?>
    <script src="Public/JS/SignUp.js"></script>
    <script type="text/javascript">
            $('.nav li:nth-child(2)').addClass('active');
            $('title').html('Page d\'inscription');
    </script>