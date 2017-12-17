<?php
    include 'Model/user.php';
    include_once 'Model/UsersManager.php';
    include_once 'View/View.php';
    
    class ControllerInOut {
        private $usersManager;
        private $ticketsList;
        
        public function __construct() {
            $this->usersManager = new UsersManager();
            $this->ticketsList = new ControllerHome();
        }
        
        // Méthode appelée lors de la demande de l'affichage du formulaire d'inscription
        public function signUpView() {
            $signUpView = new View('SignUp');
            $signUpView->generate();
        }
        
        // Méthode appelée lors de la demande de l'affichage du formulaire de connexion
        public function signInView() {
            $signUpView = new View('SignIn');
            $signUpView->generate();
        }
        
        // Méthode appelée lors de la validation du formulaire d'inscription
        public function signUp() {
            if(isset($_FILES['image'])&&($_FILES['image']['error'] == 0)) {  // On vérifie que l'image a été envoyée sans erreurs
                // Vérifications des doublons et de l'image
                if (!$this->usersManager->verify(filter_input(INPUT_POST, 'pseudo'))) {  // On vérifie que le pseudo du nouvel utilisateur n'existe pas déjà
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

                            $this->usersManager->create($user);
                            $request = $this->usersManager->readId($_SESSION['pseudo']);
                            $id = $request->fetch();
                            $_SESSION['id_user'] = $id['id'];

                            // Une fois l'utilisateur créé, on lance la méthode générant la page listant les billets
                            $this->ticketsList->home();
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
        public function signIn() {
            $request = $this->usersManager->read(filter_input(INPUT_POST, 'pseudo'), filter_input(INPUT_POST, 'password'));

            // Mis en place des variables de session liées à l'utilisateur nouvellement connecté
            if($request) {
                $_SESSION['id_user'] = $request['id'];
                $_SESSION['pseudo'] = $request['pseudo'];
                $_SESSION['email'] = $request['email'];
                $_SESSION['image'] = $request['image'];
                $_SESSION['role'] = $request['role'];
                $_SESSION['ban'] = $request['ban'];
                $this->ticketsList->home();
            }
            else {
                $_SESSION['error'] = 'Mauvais identifiant ou mot de passe !';
                header('Location: formulaireconnexion.html');
            }
        }
        
        // Méthode appelée lors de la deconnexion de l'utilisateur
        function signOut() {
            unset($_SESSION['id_user'], $_SESSION['pseudo'], $_SESSION['email'], $_SESSION['image'], $_SESSION['ban'], $_SESSION['role'], $_SESSION['id_ticket'], $_SESSION['page'], $_SESSION['nbPageComment'], $_SESSION['nbPageTicket'], $_SESSION['error'], $_SESSION['success']);
            session_destroy();
            $this->ticketsList->home();
        }
    }