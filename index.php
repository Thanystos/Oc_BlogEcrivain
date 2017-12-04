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
    }elseif(filter_input(INPUT_GET, 'action') == 'listBillets') {
        listBillets();
    }elseif(filter_input(INPUT_GET, 'action') == 'unibillet') {
        uniBillet();
    }elseif(filter_input(INPUT_GET, 'action') == 'ajoutCommentaire') {
        addCommentaire();
    }elseif(filter_input(INPUT_GET, 'action') == 'modifCommentaire') {
        modifCommentaire();
    }elseif(filter_input(INPUT_GET, 'action') == 'suppCommentaire') {
        suppCommentaire();    
    }elseif(filter_input(INPUT_GET, 'action') == 'signaler') {
        createSignalement();
    }elseif(filter_input(INPUT_GET, 'action') == 'creerBilletView') {
        include('View/Creerbillet.php');
    }elseif(filter_input(INPUT_GET, 'action') == 'creerBillet') {
        addBillet();
    }elseif(filter_input(INPUT_GET, 'action') == 'modifBillet') {
        modifBillet();
    }elseif(filter_input(INPUT_GET, 'action') == 'suppBillet') {
        suppBillet();
    }elseif(filter_input(INPUT_GET, 'action') == 'listUtilisateurs') {
        listUtilisateurs();
    }elseif(filter_input(INPUT_GET, 'action') == 'listSignalements') {
        listSignalements();
    }elseif(filter_input(INPUT_GET, 'action') == 'updateStatus') {
        updateStatus();
    }elseif(filter_input(INPUT_GET, 'action') == 'suppUtilisateur') {
        suppUtilisateur();
    }
    else {
        listBillets();
    }  