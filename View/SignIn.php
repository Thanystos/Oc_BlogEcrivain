<?php $this->title = 'Page de connexion';
    if(isset($_SESSION['error'])) { ?>
    <script>
        var session = eval('(<?= json_encode($_SESSION) ?>)');
        alert(session.error);
    </script>
    <?php 
        unset($_SESSION['error']);
} ?>
<link rel="stylesheet" href="Public/CSS/SignIn.css">
<div class="col-sm-8 col-sm-offset-1">
    <h4><small>CONNEXION</small></h4>
    <hr>
</div>
<div class="col-sm-8 col-sm-offset-1" style="background-color: white; padding: 15px;">
    <div class="imgcontainer">
        <img src="Public/Images/avatar.png" alt="Avatar" class="avatar">
    </div>
    <form method="post" action="connexion.html">
        <div class="container">
            <label for="pseudo"><b>Identifiant</b></label>
            <input type="text" placeholder="Entrez votre identifiant" id="pseudo" name="pseudo" required>

            <label for="password"><b>Mot de Passe</b></label>
            <input type="password" placeholder="Entrez votre mot de passe" id="password" name="password" required>

            <button type="submit" class="submitconnexion">Se connecter</button>
        </div>
    </form>

    <form method="post" action="formulaireinscription.html">
        <div class="container">
            <button type="submit" class="inscription">Inscription</button>
        </div>
    </form>
</div>
<script type="text/javascript">
    $('.nav li:nth-child(2)').addClass('active');
    $('title').html(<?= json_encode($this->title); ?>);
</script>