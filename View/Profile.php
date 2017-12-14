                <?php if(isset($_SESSION['error'])) { ?>
                    <script>
                        var session = eval('(<?php echo json_encode($_SESSION) ?>)');
                        alert(session.error);
                    </script>
                <?php 
                    unset($_SESSION['error']);
                }
                if(isset($_SESSION['success'])) { ?>
                    <script>
                        var session = eval('(<?php echo json_encode($_SESSION) ?>)');
                        alert(session.success);
                    </script>
                <?php 
                    unset($_SESSION['success']);
                }
                ?>
                <link rel="stylesheet" href="Public/CSS/SignIn.css">
                <?php include 'nav.php'; ?>
                <div class="col-sm-8 col-sm-offset-1">
                    <?php if(isset($requestInfos)) {
                        $infos = $requestInfos->fetch(); ?>
                        <h4><small>PAGE DE PROFIL : <?php echo $infos['pseudo']; ?></small></h4>
                        <hr>
                </div>
                        <div class="col-sm-8 col-sm-offset-1" style="background-color: white; padding: 15px;">
                        <h2>Informations de profil :</h2>
                        <div class="infos">
                            <form id="sendemail" method="post" action="modifemail.html">
                                <div class="container">
                                    <label for="email"><b>E-mail</b></label>
                                    <input type="text" placeholder="<?php echo $infos['email']; ?>" id="email" name="email" />

                                    <button type="submit">Changer</button>
                                </div>
                            </form>
                            <form id="sendpassword" method="post" action="modifmdp.html">
                                <div class="container">
                                    <label for="password"><b>Mot de passe</b></label>
                                    <input type="password" placeholder="********" id="password" name="password" />

                                    <button type="submit">Changer</button>
                                </div>
                            </form>
                            <form method="post" action="modifimage.html" enctype="multipart/form-data">
                                <div class="container">
                                    <label for="image"><b>Image de profil</b></label>
                                    <input type="file" placeholder="<?php echo $infos['image']; ?>" name="image" id="image" />
                                    <br>

                                    <button type="submit">Changer</button>
                                </div>
                            </form>
                            <div class="container">
                                Signalé : <?php echo $infos['nb_report']; ?> fois
                            </div>
                        </div>
                    <?php } else { ?>
                        <h4><small>PAGE DE PROFIL</h4>
                        <hr>
                        </div>
                <div class="col-sm-8 col-sm-offset-1" style="background-color: white; padding: 15px;">
                    <?php } ?>
                    <h2 style="margin-bottom: 40px;">Commentaires postés :</h2>
                    <div>
                        <?php $content = null; ?>
                        <?php while ($comment = $requestComments->fetch()) {
                            if($content != $comment['title']) { ?>
                                <h3>
                                    <?php echo html_entity_decode(htmlspecialchars($comment['title'])); ?>
                                    <hr>
                                    <?php $content = $comment['title']; ?>
                                </h3>
                            <?php } ?>
                            <div class="comment container" style="margin-bottom: 20px; border: 3px solid #f1f1f1;">
                                <?php echo nl2br(html_entity_decode(htmlspecialchars($comment['text']))); ?>
                                <h3><small>Posté le <?php echo $comment['cpost_date']; ?></small></h4>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'footer.php'; ?>
        <script src="Public/JS/Profile.js"></script>
        <script type="text/javascript">
            $('title').html('Page de profil');
        </script>