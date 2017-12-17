<?php
    include_once 'Model/UsersManager.php';
    include_once 'Model/CommentsManager.php';
    include_once 'View/View.php';
    
    class ControllerProfile {
        private $usersManager;
        private $commentsManager;
        
        public function __construct() {
            $this->usersManager = new UsersManager();
            $this->commentsManager = new CommentsManager();
        }
        
        // Méthode appelée lorsqu'on souhaite accéder à la page de profil d'un utilisateur
        function profilePage() {
            // On affiche les informations sensibles lié à un utilisateur que si nous sommes ce dit utilisateur
            if((isset($_SESSION['pseudo'])) && ($_SESSION['pseudo'] == filter_input(INPUT_GET, 'pseudo'))) {
                $requestInfos = $this->usersManager->readInfos(filter_input(INPUT_GET, 'pseudo'));
            }
            $requestComments = $this->commentsManager->readPseudo(filter_input(INPUT_GET, 'pseudo'));
            $viewUsersList = new View('Profile');
            if(isset($requestInfos)) {
                $viewUsersList->generate(array('requestInfos' => $requestInfos, 'requestComments' => $requestComments));
            }
            else {
                $viewUsersList->generate(array('requestComments' => $requestComments));
            }
        }
    }