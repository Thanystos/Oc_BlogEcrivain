                <?php if($_SESSION['role']!= 2) {
                    header('Location: listebillets.html');
                }
                    include 'nav.php';
                ?>
                <div class="col-sm-9">
                    <h4><small>LISTE DES SIGNALEMENTS</small></h4>
                    <hr>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Billet</th>
                                <th>Commentaire</th>
                                <th>Signalé par</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($comment = $request->fetch()) { ?>
                            <tr>
                                <th><?php echo $comment['title']; ?></th>
                                <th><?php echo $comment['text']; ?></th>
                                <th><?php echo $comment['pseudo']; ?></th>
                                <th>
                                    <form method="post" action="billet_<?php echo $comment['tid']; ?>.html#<?php echo $comment['cid']; ?>">
                                        <input type="submit" class="btn btn-info" value="VOIR PAGE" />
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
                $(".nav li:nth-child(4)").addClass('active');
                $('title').html('Liste des signalements');
            });
        </script>
        
