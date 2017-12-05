<?php
    include 'Controller/Controller.php';
    
    if(filter_input(INPUT_GET, 'action') == 'signUpView') {
        include('View/SignUp.php');
    }elseif(filter_input(INPUT_GET, 'action') == 'signInView') {
        include('View/SignIn.php');
    }elseif(filter_input(INPUT_POST, 'email')) {
        signUp();
    }elseif(filter_input(INPUT_POST, 'pseudo')) {
        signIn();
    }elseif(filter_input(INPUT_GET, 'action') == 'ticketsList') {
        ticketsList();
    }elseif(filter_input(INPUT_GET, 'action') == 'singleTicket') {
        singleTicket();
    }elseif(filter_input(INPUT_GET, 'action') == 'addComment') {
        addComment();
    }elseif(filter_input(INPUT_GET, 'action') == 'updateComment') {
        updateComment();
    }elseif(filter_input(INPUT_GET, 'action') == 'deleteComment') {
        deleteComment();    
    }elseif(filter_input(INPUT_GET, 'action') == 'report') {
        createReport();
    }elseif(filter_input(INPUT_GET, 'action') == 'addTicketView') {
        include('View/AddTicket.php');
    }elseif(filter_input(INPUT_GET, 'action') == 'addTicket') {
        addTicket();
    }elseif(filter_input(INPUT_GET, 'action') == 'updateTicket') {
        updateTicket();
    }elseif(filter_input(INPUT_GET, 'action') == 'deleteTicket') {
        deleteTicket();
    }elseif(filter_input(INPUT_GET, 'action') == 'signOut') {
        signOut();
    }elseif(filter_input(INPUT_GET, 'action') == 'usersList') {
        usersList();
    }elseif(filter_input(INPUT_GET, 'action') == 'reportsList') {
        reportsList();
    }elseif(filter_input(INPUT_GET, 'action') == 'updateStatus') {
        updateStatus();
    }elseif(filter_input(INPUT_GET, 'action') == 'deleteUser') {
        deleteUser();
    }
    else {
        ticketsList();
    }   