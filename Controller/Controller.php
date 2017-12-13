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
    
    // Méthode empêchant l'accès aux pages administrateur pour les utilisateurs lambda
    function authorized() {
        if($_SESSION['role']!= 2) {
            header('Location: listebillets.html');
            return false;
        }
        return true;
    }
    
    // Méthode appelée lors de la validation du formulaire d'inscription
    function signUp() {
        if(isset($_FILES['image'])&&($_FILES['image']['error'] == 0)) {  // On vérifie que l'image a été envoyée sans erreurs
            // Vérifications des doublons et de l'image
            if (!UsersManager::verify(filter_input(INPUT_POST, 'pseudo'))) {  // On vérifie que le pseudo du nouvel utilisateur n'existe pas déjà
                if(($_FILES['image']['size'] <= 1000000)) {  // On vérifie que la taille de l'image ne soit pas excessive
                    $fileInfos = pathinfo($_FILES['image']['name']);
                    $uploadedExtension = $fileInfos['extension'];
                    $allowedExtensions = array('jpg', 'jpeg', 'gif', 'png');
                    if(in_array($uploadedExtension, $allowedExtensions)) {  // On vérifie que l'extension de l'image soit autorisée
                        mkdir('Public/Images/'.filter_input(INPUT_POST, 'pseudo'), 0777);
                        move_uploaded_file($_FILES['image']['tmp_name'], 'Public/Images/'.filter_input(INPUT_POST, 'pseudo').'/'.basename($_FILES['image']['name']));
                        
                        $_SESSION['pseudo'] = filter_input(INPUT_POST, 'pseudo');
                        $password_hash = password_hash(filter_input(INPUT_POST, 'password'), PASSWORD_BCRYPT); // Conversion du mdp en mdp sécurisé

                        // Création d'une instance user qu'on passera au modèle
                        $user = new User();
                        $user->setPseudo(filter_input(INPUT_POST, 'pseudo'));
                        $user->setEmail(filter_input(INPUT_POST, 'email'));
                        $user->setPassword($password_hash);
                        $user->setImage($_FILES['image']['name']);
                        
                        // Mis en place des variables de session liées à l'utilisateur nouvellement créé
                        $_SESSION['pseudo'] = filter_input(INPUT_POST, 'pseudo');
                        $_SESSION['email'] = filter_input(INPUT_POST, 'email');
                        $_SESSION['image'] = $_FILES['image']['name'];
                        $_SESSION['role'] = 1;
                        $_SESSION['ban'] = 0;

                        UsersManager::create($user);
                        $request = UsersManager::readId($_SESSION['pseudo']);
                        $id = $request->fetch();
                        $_SESSION['id_user'] = $id['id'];
                        
                        // Une fois l'utilisateur créé, on lance la méthode générant la page listant les billets
                        ticketsList();
                    }
                    else {
                        $_SESSION['error'] = 'Format image incorrect !';
                        header('Location: formulaireinscription.html');
                    }
                }
                else {
                    $_SESSION['error'] = 'Taille image excessive !';
                    header('Location: formulaireinscription.html');
                }
                
            }
            else {
                $_SESSION['error'] = 'Pseudo déjà existant !';
                header('Location: formulaireinscription.html');
            }
        }
        else {
            $_SESSION['error'] = 'Erreur envoi !';
            header('Location: formulaireinscription.html');
        }
    }
    
    // Méthode appelée lors de la validation du formulaire de connexion
    function signIn() {
        $request = UsersManager::read(filter_input(INPUT_POST, 'pseudo'), filter_input(INPUT_POST, 'password'));
        
        // Mis en place des variables de session liées à l'utilisateur nouvellement connecté
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
            $_SESSION['error'] = 'Mauvais identifiant ou mot de passe !';
            header('Location: formulaireconnexion.html');
        }
    }
    
    function ticketsList() {
        $cache = 'View/Cache/TicketsList.php';
        $expire = time() - 5;

        // Vérification de la validité du cache
        if((file_exists($cache)) && (filemtime($cache) > $expire) && (filter_input(INPUT_GET, 'page') == 1 )) {
            include 'View/nav.php';
            readfile($cache);
        }
        // On n'effectue la requête permettant de récupérer les informations liées à la liste des tickets que si le cache n'existe pas ou est expiré
        else {
            // Variables nécessaires à la pagination de la liste des billets
            $requestNbTickets = TicketsManager::count();
            $nbTickets = $requestNbTickets->fetch();
            $_SESSION['nbPageTicket'] = ceil($nbTickets[0] / 5);
            
            // Si la page demandée est possible, on affiche son contenu
            if(filter_input(INPUT_GET, 'page')&&(filter_input(INPUT_GET, 'page') > 0)&&(filter_input(INPUT_GET, 'page') <= $_SESSION['nbPageTicket'])) {
                $request = TicketsManager::readAll(filter_input(INPUT_GET, 'page'));
            }
            else {
                // Sinon on affiche le contenu de la première
                $request = TicketsManager::readAll(1);
            }
            
            // Méthode permettant de n'avoir qu'un résumé des billets
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
            
            // Si la page demandée est la première on demarre sa mise en cache
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
    
    // Méthode appelée lorsque l'on veut accéder à la page présentant un billet précis
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
            // Va permettre d'interdire les multiples signalements sur un même commentaire
            $requestReports = ReportsManager::read(filter_input(INPUT_GET, 'id_ticket'), $_SESSION['id_user']);
        }
        include 'View/SingleTicket.php';
    }
    
    // Méthode appelée lors de la création d'un nouveau commentaire
    function addComment() {
        $comment = new Comment();
        $comment->setText(filter_input(INPUT_POST, 'comment'));
        $comment->setIdTicket($_SESSION['id_ticket']);
        $comment->setIdUser($_SESSION['id_user']);
        CommentsManager::create($comment);
        header('Location: billet_'.$_SESSION['id_ticket'].'.html');
    }
    
    
    // Méthode appelée lors de la mise à jour d'un commentaire
    function updateComment() {
        CommentsManager::update(filter_input(INPUT_GET, 'id_comment'), filter_input(INPUT_POST, 'text'));
        header('Location: billet_'.$_SESSION['id_ticket'].'.html');
    }
    
    // Méthode appelée lors de la suppression d'un commentaire
    function deleteComment() {
        CommentsManager::delete(filter_input(INPUT_GET, 'id_comment'));
        header('Location: billet_'.$_SESSION['id_ticket'].'.html');
    }
    
    // Méthode appelée lors d'un signalement de commentaire
    function createReport() {
        $report = new Report();
        $report->setIdComment(filter_input(INPUT_GET, 'id_comment'));
        $report->setIdUser($_SESSION['id_user']);
        
        ReportsManager::create($report);
        
        // Incrémentation du nombre de fois qu'un utilisateur a été signalé
        UsersManager::updateReport(filter_input(INPUT_GET, 'pseudo'));      
        header('Location: billet_'.$_SESSION['id_ticket'].'-'.$_SESSION['page'].'.html');
    }
    
    // Méthode appelée lorsqu'un nouveau billet sera soumis après validation du formulaire présent sur la page de création d'un nouveau billet (ADMIN)
    function addTicket() {
        $ticket = new Ticket();
        $ticket->setTitre(filter_input(INPUT_POST, 'titre'));
        $ticket->setText(filter_input(INPUT_POST, 'text'));
        $ticket->setIdUtilisateur($_SESSION['id_user']);

        TicketsManager::create($ticket);
        header('Location: listebillets.html');
    }
    
    // Méthode appelée lors de la mise à jour d'un billet (ADMIN)
    function updateTicket() {
        TicketsManager::update(($_SESSION['id_ticket']), filter_input(INPUT_POST, 'text'));
        header('Location: billet_'.$_SESSION['id_ticket'].'.html');
    }
    
    // Méthode appelée lors de la suppression d'un billet (ADMIN)
    function deleteTicket() {
        TicketsManager::delete($_SESSION['id_ticket']);
        header('Location: listebillets.html');
    }
    
    // Méthode appelée lors de la déconnexion d'un utilisateur
    function signOut() {
        unset($_SESSION['id_user'], $_SESSION['pseudo'], $_SESSION['email'], $_SESSION['image'], $_SESSION['ban'], $_SESSION['role'], $_SESSION['id_ticket'], $_SESSION['page'], $_SESSION['nbPageComment'], $_SESSION['nbPageTicket'], $_SESSION['error'], $_SESSION['success']);
        session_destroy();
        ticketsList();
    }
    
    // Méthode appelée quand on souhaite accéder à la page listant les utilisateurs (ADMIN)
    function usersList() {
        $request = UsersManager::readall();
        include 'View/UsersList.php';
    }
    
    // Méthode appelée quand on souhaite accéder à la page listant les signalements (ADMIN)
    function reportsList() {
        $requestComments = CommentsManager::readReports();
        $requestReports = ReportsManager::readReports();
        include 'View/ReportsList.php';
    }
    
    // Méthode appelée lorsqu'on bannit ou qu'on restaure un utilisateur via la page qui les liste (ADMIN)
    function updateStatus() {
        UsersManager::updateStatus(filter_input(INPUT_GET, 'id_user'));
        usersList();
    }
    
    // Méthode appelée lorsqu'on supprime un utilisateur via la page qui les liste (ADMIN)
    function deleteUser() {
        array_map('unlink', glob('Public/Images/'.filter_input(INPUT_GET, 'pseudo').'/*'));  // On supprime tous les fichiers du dossier de l'utilisateur
        rmdir('Public/Images/'.filter_input(INPUT_GET, 'pseudo'));  // On supprime le dossier de l'utilisateur
        UsersManager::delete(filter_input(INPUT_GET, 'id'));
        header('Location: listeutilisateurs.html');
    }
    
    // Méthode appelée lorsqu'on souhaite accéder à la page de profil d'un utilisateur
    function profilePage() {
        
        // On affiche les informations sensibles lié à un utilisateur que si nous sommes ce dit utilisateur
        if((isset($_SESSION['pseudo'])) && ($_SESSION['pseudo'] == filter_input(INPUT_GET, 'pseudo'))) {
            $requestInfos = UsersManager::readInfos(filter_input(INPUT_GET, 'pseudo'));
        }
        $requestComments = CommentsManager::readPseudo(filter_input(INPUT_GET, 'pseudo'));
        include 'View/Profile.php';
    }
    
    // Méthode appelée lorsqu'on souhaite modifier notre mot de passe via la page de profil
    function updatePassword() {
        $password_hash = password_hash(filter_input(INPUT_POST, 'password'), PASSWORD_BCRYPT);
        UsersManager::updatePassword($password_hash);
        $_SESSION['success'] = 'Mot de passe mis à jour !';
        header('Location: profil_'.$_SESSION['pseudo'].'.html');
    }
    
    // Méthode appelée lorsqu'on souhaite modifier notre email via la page de profil
    function updateEmail() {
        $_SESSION['email'] = filter_input(INPUT_POST, 'email');
        UsersManager::updateEmail(filter_input(INPUT_POST, 'email'));
        $_SESSION['success'] = 'Email mis à jour !';
        header('Location: profil_'.$_SESSION['pseudo'].'.html');
    }
    
    // Méthode appelée lorsqu'on souhaite modifier notre image via la page de profil
    function updateImage() {
        if(isset($_FILES['image'])&&($_FILES['image']['error'] == 0)) {
            if(($_FILES['image']['size'] <= 1000000)) {
                $fileInfos = pathinfo($_FILES['image']['name']);
                $uploadedExtension = $fileInfos['extension'];
                $allowedExtensions = array('jpg', 'jpeg', 'gif', 'png');
                if(in_array($uploadedExtension, $allowedExtensions)) {
                    move_uploaded_file($_FILES['image']['tmp_name'], 'Public/Images/'.$_SESSION['pseudo'].'/'.basename($_FILES['image']['name']));
                    $_SESSION['image'] = $_FILES['image']['name'];
                    $_SESSION['success'] = 'Image mise à jour !';
                    UsersManager::updateImage($_FILES['image']['name']);
                    
                }
                else {
                    $_SESSION['error'] = 'Format image incorrect !';
                }   
            }
            else {
                $_SESSION['error'] = 'Taille image excessive !';
            }
        }
        else {
            $_SESSION['error'] = 'Erreur envoi !';
        }
        header('Location: profil_'.$_SESSION['pseudo'].'.html');
    }
    
    // Méthode appelée lorsqu'on tente d'accéder, sur le domaine, à un document inexistant
    function error404() {
        include 'View/error/404.html';
    }