<?php
    include_once 'Model.php';
    
    class UsersManager extends Model {
        
        // Requête permettant de créer un utilisateur (utile lors de la création d'un utilisateur)
        public function create(User $user) {
            $sql = 'INSERT INTO users (pseudo, password, email, image) '
                        . 'VALUES (:pseudo, :password, :email, :image)';
            
            $request = $this->executeRequest($sql, array('pseudo'=>$user->getPseudo(), 'password'=>$user->getPassword(), 'email'=>$user->getEmail(), 'image'=>$user->getImage()));
            return $request;
        }
        
        // Requête permettant de chercher un utilisateur en fonction de son pseudo/mdp (utile lors de la connexion d'un utilisateur)
        public function read($id_user, $password) {
            $sql = 'SELECT id, pseudo, password, email, image, role, ban '
                            . 'FROM users '
                            . 'WHERE pseudo = ?';
            
            $request = $this->executeRequest($sql, array($id_user));
            $result = $request->fetch();
            if (($result)&&((password_verify($password, $result['password'])))) {
                return $result;
            }
        }
        
        // Requête permettant de récupérer l'id d'un utilisateur (Utile lors de la création d'un utilisateur)
        public function readId($pseudo) {
            $sql = 'SELECT id '
                            . 'FROM users '
                            . 'WHERE pseudo = ?';
            
            $request = $this->executeRequest($sql, array($pseudo));
            return $request;
        }
        
        // Requête permettant de récupérer la liste des utilisateurs (Utile pour la page 'liste des utilisateurs')
        public function readall() {
            $sql = 'SELECT * '
                        . 'FROM users '
                        . 'ORDER BY nb_report DESC';
            
            $request = $this->executeRequest($sql);
            return $request;
        }
        
        // Requête permettant de récupérer quelques informations inportantes d'un utilisateur donné (Utile pour la page de profil)
        public function readInfos($pseudo) {
            $sql = 'SELECT pseudo, password, email, image, nb_report '
                        . 'FROM users '
                        . 'WHERE pseudo = ?';
            
            $request = $this->executeRequest($sql, array($pseudo));
            return $request;
        }

        // Requête permettant de mettre à jour le mot de passe d'un utilisateur donné (Utile pour la page de profil)
        public function updatePassword($password) {
            $sql = 'UPDATE users '
                        . 'SET password = ? '
                        . 'WHERE pseudo = ?';
            
            $request = $this->executeRequest($sql, array($password, $_SESSION['pseudo']));
            return $request;
        }
        
        // Requête permettant de mettre à jour l'email d'un utilisateur donné (Utile pour la page de profil)
        public function updateEmail($email) {
            $sql = 'UPDATE users '
                        . 'SET email = ? '
                        . 'WHERE pseudo = ?';
            
            $request = $this->executeRequest($sql, array($email, $_SESSION['pseudo']));
            return $request;
        }
        
        // Requête permettant de mettre à jour l'image d'un utilisateur donné (Utile pour la page de profil)
        public function updateImage($image) {
            $sql = 'UPDATE users '
                        . 'SET image = ? '
                        . 'WHERE pseudo = ?';
            
            $request = $this->executeRequest($sql, array($image, $_SESSION['pseudo']));
            return $request;
        }
        
        // Requête permettant d'incrémenter la colonne nb_report d'un utilisateur donné (Utile pour la page d'un billet unique)
        public function updateReport($pseudo) {
            $sql = 'UPDATE users '
                        . 'SET nb_report = nb_report + 1 '
                        . 'WHERE pseudo = ?';
            
            $request = $this->executeRequest($sql, array($pseudo));
            return $request;
        }
        
        // Méthode permettant d'inverser la variable booléenne ban d'un utilisateur donné (Utile pour la page 'liste des utilisateurs')
        public function updateStatus($id_user) {
            $sql = 'UPDATE users '
                        . 'SET ban = !ban '
                        . 'WHERE id = ?';
            
            $request = $this->executeRequest($sql, array($id_user));
            return $request;
        }

        // Méthode permettant de supprimer un utilisateur donné (Utile pour la page 'liste des utilisateurs')
        public function delete($id_user) {
            $sql = 'DELETE '
                        . 'FROM users WHERE id = ?';
            
            $request = $this->executeRequest($sql, array($id_user));
            return $request;
        }
        
        // Méthode permettant de vérifier qu'un utilisateur existe ou non (Utile pour la vérification des pseudos doublons lors de l'inscription)
        public function verify($pseudo) {
            $sql = 'SELECT id '
                        . 'FROM users WHERE pseudo = ?';
            
            $request = $this->executeRequest($sql, array($pseudo));
            $result = $request->fetch();
            return $result;
        }
    }