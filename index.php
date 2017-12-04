<?php
    include 'Controller/Controller.php';
    
    if(filter_input(INPUT_GET, 'action') == 'inscriptionView') {
        include('View/Inscription.php');
    }elseif(filter_input(INPUT_GET, 'action') == 'connexionView') {
        include('View/Connexion.php');
    }elseif(filter_input(INPUT_POST, 'email')) {
        inscription();
    }elseif(filter_input(INPUT_POST, 'pseudo')) {
        connexion();
    }