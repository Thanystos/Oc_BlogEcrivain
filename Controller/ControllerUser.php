<?php
    include_once 'Model/UsersManager.php';
    include_once 'View/View.php';
    
    class ControllerUser {
        private $usersManager;
        
        public function __construct() {
            $this->usersManager = new UsersManager();
        }
        
        // Méthode appelée quand on souhaite accéder à la page listant les utilisateurs (ADMIN)
        public function usersList() {
            $request = $this->usersManager->readall();
            $viewUsersList = new View('UsersList');
            $viewUsersList->generate(array('request' => $request));
        }
        
        // Méthode appelée lorsqu'on souhaite modifier notre mot de passe via la page de profil
        public function updatePassword() {
            $password_hash = password_hash(filter_input(INPUT_POST, 'password'), PASSWORD_BCRYPT);
            $this->usersManager->updatePassword($password_hash);
            $_SESSION['success'] = 'Mot de passe mis à jour !';
            header('Location: profil_'.$_SESSION['pseudo'].'.html');
        }
        
        // Méthode appelée lorsqu'on souhaite modifier notre email via la page de profil
        public function updateEmail() {
            $_SESSION['email'] = filter_input(INPUT_POST, 'email');
            $this->usersManager->updateEmail(filter_input(INPUT_POST, 'email'));
            $_SESSION['success'] = 'Email mis à jour !';
            header('Location: profil_'.$_SESSION['pseudo'].'.html');
        }
        
        // Méthode appelée lorsqu'on souhaite modifier notre image via la page de profil
        public function updateImage() {
            if(isset($_FILES['image'])&&($_FILES['image']['error'] == 0)) {
                if(($_FILES['image']['size'] <= 1000000)) {
                    $fileInfos = pathinfo($_FILES['image']['name']);
                    $uploadedExtension = $fileInfos['extension'];
                    $allowedExtensions = array('jpg', 'jpeg', 'gif', 'png');
                    if(in_array($uploadedExtension, $allowedExtensions)) {
                        move_uploaded_file($_FILES['image']['tmp_name'], 'Public/Images/'.$_SESSION['pseudo'].'/'.basename($_FILES['image']['name']));
                        $_SESSION['image'] = $_FILES['image']['name'];
                        $_SESSION['success'] = 'Image mise à jour !';
                        $this->usersManager->updateImage($_FILES['image']['name']);

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
        
        // Méthode appelée lorsqu'on bannit ou qu'on restaure un utilisateur via la page qui les liste (ADMIN)
        public function updateStatus() {
            $this->usersManager->updateStatus(filter_input(INPUT_GET, 'id_user'));
            $this->usersList();
        }
        
        // Méthode appelée lorsqu'on supprime un utilisateur via la page qui les liste (ADMIN)
        public function deleteUser() {
            array_map('unlink', glob('Public/Images/'.filter_input(INPUT_GET, 'pseudo').'/*'));  // On supprime tous les fichiers du dossier de l'utilisateur
            rmdir('Public/Images/'.filter_input(INPUT_GET, 'pseudo'));  // On supprime le dossier de l'utilisateur
            $this->usersManager->delete(filter_input(INPUT_GET, 'id'));
            header('Location: listeutilisateurs.html');
        } 
    }