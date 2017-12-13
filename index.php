<?php
    include 'Controller/Controller.php';
    
    if(filter_input(INPUT_GET, 'action') == 'signUpView') {
        include('View/SignUp.php');
    }elseif(filter_input(INPUT_GET, 'action') == 'signInView') {
        include('View/SignIn.php');
    }elseif(filter_input(INPUT_GET, 'action') == 'signUp') {
        signUp();
    }elseif(filter_input(INPUT_GET, 'action') == 'signIn') {
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
        if(authorized()) {
            include('View/AddTicket.php');
        }
    }elseif(filter_input(INPUT_GET, 'action') == 'addTicket') {
        addTicket();
    }elseif(filter_input(INPUT_GET, 'action') == 'updateTicket') {
        updateTicket();
    }elseif(filter_input(INPUT_GET, 'action') == 'deleteTicket') {
        if(authorized()) {
            deleteTicket();
        }
    }elseif(filter_input(INPUT_GET, 'action') == 'signOut') {
        signOut();
    }elseif(filter_input(INPUT_GET, 'action') == 'usersList') {
        if(authorized()) {
            usersList();
        }
    }elseif(filter_input(INPUT_GET, 'action') == 'reportsList') {
        if(authorized()) {
            reportsList();
        }
    }elseif(filter_input(INPUT_GET, 'action') == 'updateStatus') {
        if(authorized()) {
            updateStatus();
        }
    }elseif(filter_input(INPUT_GET, 'action') == 'deleteUser') {
        if(authorized()) {
            deleteUser();
        }
    }elseif(filter_input(INPUT_GET, 'action') == 'profilePage') {
        profilePage();
    }elseif(filter_input(INPUT_GET, 'action') == 'updateEmail') {
        updateEmail();
    }elseif(filter_input(INPUT_GET, 'action') == 'updatePassword') {
        updatePassword();
    }elseif(filter_input(INPUT_GET, 'action') == 'updateImage') {
        updateImage();
    }
    elseif(filter_input(INPUT_GET, 'action') == '404') {
        error404();
    }
    else {
        ticketsList();
    }