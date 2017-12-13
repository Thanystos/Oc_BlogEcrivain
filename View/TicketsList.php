                <div class="col-sm-9">
                    <h4><small>DERNIERS BILLETS</small></h4>
                    <hr>
                    <?php while ($ticket = $request->fetch()) { ?>
                    <div class="ticket">
                        <h2><a href="billet_<?php echo $ticket['id']; ?>.html"><?php echo html_entity_decode(htmlspecialchars($ticket['title'])); ?></a></h2>
                        <h5><span class="glyphicon glyphicon-time"></span> Publié par <a href="profil_<?php echo $ticket['pseudo']; ?>.html"><?php echo $ticket['pseudo']; ?></a> le <?php echo $ticket['post_date']; ?>.</h5>
                        <p><?php echo nl2br(html_entity_decode(htmlspecialchars(resume($ticket['text'])))); ?></p>
                        <br><br>
                    </div>
                    <?php }
                    $request->closeCursor(); ?>
                    <div class="navigation text-center">
                        <ul class="pagination pagination-lg">
                        <?php for($i=1; $i<=$_SESSION['nbPageTicket']; $i++) { ?>
                            <li><a href="listebillets_<?php echo $i; ?>.html"><?php echo $i; ?></a></li>
                        <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'footer.php'; ?>
        <script type="text/javascript">
            $(".nav li:nth-child(1)").addClass('active');
            $('title').html('Liste des derniers billets');
        </script>