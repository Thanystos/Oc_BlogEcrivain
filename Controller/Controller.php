<?php
session_start();
    include 'Model/User.php';
    include 'Model/UsersManager.php';
    include 'Model/Ticket.php';
    include 'Model/TicketsManager.php';
    include 'Model/Comment.php';
    include 'Model/CommentsManager.php';
    include 'Model/Report.php';
    include 'Model/ReportsManager.php';
    
    function signUp() {
        if(isset($_FILES['image'])&&($_FILES['image']['error'] == 0)) {  // Erreur d'envoi
            // Vérifications des doublons et de l'image
            if (!UsersManager::verify(filter_input(INPUT_POST, 'pseudo'))) {  // Doublon de pseudo
                if(($_FILES['image']['size'] <= 1000000)) {  // Taille excessive
                    $fileInfos = pathinfo($_FILES['image']['name']);
                    $uploadedExtension = $fileInfos['extension'];
                    $allowedExtensions = array('jpg', 'jpeg', 'gif', 'png');
                    if(in_array($uploadedExtension, $allowedExtensions)) {  // Extension non autorisée
                        move_uploaded_file($_FILES['image']['tmp_name'], 'Public/Images/' . basename($_FILES['image']['name']));
                        
                        $_SESSION['pseudo'] = filter_input(INPUT_POST, 'pseudo');
                        $password_hash = password_hash(filter_input(INPUT_POST, 'password'), PASSWORD_BCRYPT);

                        $user = new User();
                        $user->setPseudo(filter_input(INPUT_POST, 'pseudo'));
                        $user->setEmail(filter_input(INPUT_POST, 'email'));
                        $user->setPassword($password_hash);
                        $user->setImage($_FILES['image']['name']);
                        
                        $_SESSION['pseudo'] = filter_input(INPUT_POST, 'pseudo');
                        $_SESSION['email'] = filter_input(INPUT_POST, 'email');
                        $_SESSION['image'] = $_FILES['image']['name'];
                        $_SESSION['role'] = 1;
                        $_SESSION['ban'] = 0;

                        UsersManager::create($user);
                        $request = UsersManager::readId($_SESSION['pseudo']);
                        $id = $request->fetch();
                        $_SESSION['id_user'] = $id['id'];
                        ticketsList();
                    }
                    else {
                        $_SESSION['erreur'] = 'Format image incorrect !';
                        header('Location: inscription.html');
                    }
                }
                else {
                    $_SESSION['erreur'] = 'Taille image excessive !';
                    header('Location: inscription.html');
                }
                
            }
            else {
                $_SESSION['erreur'] = 'Pseudo déjà existant !';
                header('Location: inscription.html');
            }
        }
        else {
            $_SESSION['erreur'] = 'Erreur envoi !';
            header('Location: inscription.html');
        }
    }
    
    function signIn() {
        $request = UsersManager::read(filter_input(INPUT_POST, 'pseudo'), filter_input(INPUT_POST, 'password'));
        if($request) {
            $_SESSION['id_user'] = $request['id'];
            $_SESSION['pseudo'] = $request['pseudo'];
            $_SESSION['email'] = $request['email'];
            $_SESSION['image'] = $request['image'];
            $_SESSION['role'] = $request['role'];
            $_SESSION['ban'] = $request['ban'];
            ticketsList();
        }
        else {
            $_SESSION['erreur'] = 'Mauvais identifiant ou mot de passe !';
            header('Location: connexion.html');
        }
    }
    
    function ticketsList() {
        $cache = 'View/Cache/TicketsList.php';
        $expire = time() - 5;

        if((file_exists($cache)) && (filemtime($cache) > $expire) && (filter_input(INPUT_GET, 'page') == 1 )) {
            echo '1';
            include 'View/nav.php';
            readfile($cache);
        }
        else {
            $requestNbTickets = TicketsManager::count();
            $nbTickets = $requestNbTickets->fetch();
            $_SESSION['nbPageTicket'] = ceil($nbTickets[0] / 5);
            if(filter_input(INPUT_GET, 'page')&&(filter_input(INPUT_GET, 'page') > 0)&&(filter_input(INPUT_GET, 'page') <= $_SESSION['nbPageTicket'])) {
                $request = TicketsManager::readAll(filter_input(INPUT_GET, 'page'));
            }
            else {
                $request = TicketsManager::readAll(1);
            }
            function resume($string) {
                if(strlen($string) >= 200) {
                    $string = substr($string, 0, 200);
                    $space = strrpos($string, ' ');
                    return $string = substr($string, 0, $space)."...";
                }
                else {
                    return $string;
                }
            }
            if(filter_input(INPUT_GET, 'page') == 1) {
                include 'View/nav.php';
                ob_start();
                include 'View/TicketsList.php';
                $page = ob_get_contents();
                file_put_contents($cache, $page);
            }
            else {
                include 'View/nav.php';
                include 'View/TicketsList.php';
            }
        }
    }

    function singleTicket() {
        $requestTicket = TicketsManager::read(filter_input(INPUT_GET, 'id_ticket'));
        $requestNbComments = CommentsManager::count(filter_input(INPUT_GET, 'id_ticket'));
        $nbComments = $requestNbComments->fetch();
        $_SESSION['nbPageComment'] = ceil($nbComments[0] / 5);
        if(filter_input(INPUT_GET, 'page')&&(filter_input(INPUT_GET, 'page') > 0)&&(filter_input(INPUT_GET, 'page') <= $_SESSION['nbPageComment'])) {
            $requestComments = CommentsManager::read(filter_input(INPUT_GET, 'id_ticket'), filter_input(INPUT_GET, 'page'));
            $_SESSION['page'] = filter_input(INPUT_GET, 'page');
        }
        else {
            $requestComments = CommentsManager::read(filter_input(INPUT_GET, 'id_ticket'), 1);
            $_SESSION['page'] = 1;
        }
        $requestReports = null;
        if(isset($_SESSION['id_user'])) {
            $requestReports = ReportsManager::read(filter_input(INPUT_GET, 'id_ticket'), $_SESSION['id_user']);
        }
        include 'View/SingleTicket.php';
    }
    
    function addComment() {
        $comment = new Comment();
        $comment->setText(filter_input(INPUT_POST, 'comment'));
        $comment->setIdTicket($_SESSION['id_ticket']);
        $comment->setIdUser($_SESSION['id_user']);
        CommentsManager::create($comment);
        header('Location: billet_'.$_SESSION['id_ticket'].'.html');
    }
    
    function updateComment() {
        CommentsManager::update(filter_input(INPUT_GET, 'id_comment'), filter_input(INPUT_POST, 'text'));
        header('Location: billet_'.$_SESSION['id_ticket'].'.html');
    }
    
    function deleteComment() {
        CommentsManager::delete(filter_input(INPUT_GET, 'id_comment'));
        header('Location: billet_'.$_SESSION['id_ticket'].'.html');
    }
    
    function createReport() {
        $report = new Report();
        $report->setIdComment(filter_input(INPUT_GET, 'id_comment'));
        $report->setIdUser($_SESSION['id_user']);
        
        ReportsManager::create($report);
        UsersManager::updateReport(filter_input(INPUT_GET, 'pseudo'));
        
        header('Location: billet_'.$_SESSION['id_ticket'].'-'.$_SESSION['page'].'.html');
    }
    
    function addTicket() {
        $ticket = new Ticket();
        $ticket->setTitre(filter_input(INPUT_POST, 'titre'));
        $ticket->setText(filter_input(INPUT_POST, 'text'));
        $ticket->setIdUtilisateur($_SESSION['id_user']);
        
        TicketsManager::create($ticket);
        header('Location: listebillets.html');
    }
    
    function updateTicket() {
        TicketsManager::update(($_SESSION['id_ticket']), filter_input(INPUT_POST, 'text'));
        header('Location: billet_'.$_SESSION['id_ticket'].'.html');
    }
    
    function deleteTicket() {
        echo $_SESSION['id_ticket'];
        TicketsManager::delete($_SESSION['id_ticket']);
        header('Location: listebillets.html');
    }
    
    function signOut() {
        unset($_SESSION['id_user'], $_SESSION['pseudo'], $_SESSION['email'], $_SESSION['image'], $_SESSION['role'], $_SESSION['id_ticket']);
        session_destroy();
        ticketsList();
    }
    
    function usersList() {
        $request = UsersManager::readall();
        include 'View/UsersList.php';
    }
    
    function reportsList() {
       $requestComments = CommentsManager::readReports();
       $requestReports = ReportsManager::readReports();
       include 'View/ReportsList.php';
    }
    
    function updateStatus() {
        UsersManager::updateStatus(filter_input(INPUT_GET, 'id_user'));
        usersList();
    }
    
    function deleteUser() {
        unlink('Public/Images/'.filter_input(INPUT_GET, 'image'));
        UsersManager::delete(filter_input(INPUT_GET, 'id'));
        header('Location: listeutilisateurs.html');
    }
    
    function profilePage() {
        $requestInfos = UsersManager::readInfos(filter_input(INPUT_GET, 'pseudo'));
        $requestComments = CommentsManager::readPseudo(filter_input(INPUT_GET, 'pseudo'));
        include 'View/Profile.php';
    }