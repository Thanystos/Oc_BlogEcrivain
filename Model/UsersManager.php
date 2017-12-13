<?php
    include 'DBConnexion.php';
    
    class UsersManager {
        
        // Requête permettant de créer un utilisateur (utile lors de la création d'un utilisateur)
        public static function create(User $user) {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->prepare('INSERT INTO users (pseudo, password, email, image) '
                                     . 'VALUES (:pseudo, :password, :email, :image)');
            
            $request->execute(array('pseudo'=>$user->getPseudo(), 'password'=>$user->getPassword(), 'email'=>$user->getEmail(), 'image'=>$user->getImage()));
        }
        
        // Requête permettant de chercher un utilisateur en fonction de son pseudo/mdp (utile lors de la connexion d'un utilisateur)
        public static function read($id_user, $password) {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->prepare('SELECT id, pseudo, password, email, image, role, ban '
                                     . 'FROM users '
                                     . 'WHERE pseudo = ?');
            
            $request->execute(array($id_user));
            $result = $request->fetch();
            if (($result)&&((password_verify($password, $result['password'])))) {
                return $result;
            }
        }
        
        // Requête permettant de récupérer l'id d'un utilisateur (Utile lors de la création d'un utilisateur)
        public static function readId($pseudo) {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->prepare('SELECT id '
                                     . 'FROM users '
                                     . 'WHERE pseudo = ?');
            
            $request->execute(array($pseudo));
            return $request;
        }
        
        // Requête permettant de récupérer la liste des utilisateurs (Utile pour la page 'liste des utilisateurs')
        public static function readall() {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->query('SELECT * '
                                   . 'FROM users '
                                   . 'ORDER BY nb_report DESC');
            
            return $request;
        }
        
        // Requête permettant de récupérer quelques informations inportantes d'un utilisateur donné (Utile pour la page de profil)
        public static function readInfos($pseudo) {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->prepare('SELECT pseudo, password, email, image, nb_report '
                                     . 'FROM users '
                                     . 'WHERE pseudo = ?');
            
            $request->execute(array($pseudo));
            return $request;
        }

        // Requête permettant de mettre à jour le mot de passe d'un utilisateur donné (Utile pour la page de profil)
        public static function updatePassword($password) {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->prepare('UPDATE users '
                                     . 'SET password = ? '
                                     . 'WHERE pseudo = ?');
            
            $request->execute(array($password, $_SESSION['pseudo']));
        }
        
        // Requête permettant de mettre à jour l'email d'un utilisateur donné (Utile pour la page de profil)
        public static function updateEmail($email) {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->prepare('UPDATE users '
                                     . 'SET email = ? '
                                     . 'WHERE pseudo = ?');
            
            $request->execute(array($email, $_SESSION['pseudo']));
        }
        
        // Requête permettant de mettre à jour l'image d'un utilisateur donné (Utile pour la page de profil)
        public static function updateImage($image) {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->prepare('UPDATE users '
                                     . 'SET image = ? '
                                     . 'WHERE pseudo = ?');
            
            $request->execute(array($image, $_SESSION['pseudo']));
        }
        
        // Requête permettant d'incrémenter la colonne nb_report d'un utilisateur donné (Utile pour la page d'un billet unique)
        public static function updateReport($pseudo) {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->prepare('UPDATE users '
                                     . 'SET nb_report = nb_report + 1 '
                                     . 'WHERE pseudo = ?');
            
            $request->execute(array($pseudo));
        }
        
        // Méthode permettant d'inverser la variable booléenne ban d'un utilisateur donné (Utile pour la page 'liste des utilisateurs')
        public static function updateStatus($id_user) {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->prepare('UPDATE users '
                                     . 'SET ban = !ban '
                                     . 'WHERE id = ?');
            
            $request->execute(array($id_user));
        }

        // Méthode permettant de supprimer un utilisateur donné (Utile pour la page 'liste des utilisateurs')
        public static function delete($id_user) {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->prepare('DELETE '
                                     . 'FROM users WHERE id = ?');
            
            $request->execute(array($id_user));
        }
        
        // Méthode permettant de vérifier qu'un utilisateur existe ou non (Utile pour la vérification des pseudos doublons lors de l'inscription)
        public static function verify($pseudo) {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->prepare('SELECT id '
                                     . 'FROM users WHERE pseudo = ?');
            
            $request->execute(array($pseudo));
            $result = $request->fetch();
            return $result;
        }
    }