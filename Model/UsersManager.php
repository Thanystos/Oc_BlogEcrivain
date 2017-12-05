<?php
    include 'DBConnexion.php';
    
    class UsersManager {
        public static function create(User $user) {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->prepare('INSERT INTO users (pseudo, password, email, image) '
                                     . 'VALUES (:pseudo, :password, :email, :image)');
            
            $request->execute(array('pseudo'=>$user->getPseudo(), 'password'=>$user->getPassword(), 'email'=>$user->getEmail(), 'image'=>$user->getImage()));
        }
        
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
        
        public static function readId($pseudo) {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->prepare('SELECT id '
                                     . 'FROM users '
                                     . 'WHERE pseudo = ?');
            
            $request->execute(array($pseudo));
            return $request;
        }
        
        public static function readall() {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->query('SELECT * '
                                   . 'FROM users '
                                   . 'ORDER BY nb_report DESC');
            
            return $request;
        }
        
        public static function updateReport($pseudo) {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->prepare('UPDATE users '
                                     . 'SET nb_report = nb_report + 1 '
                                     . 'WHERE pseudo = ?');
            
            $request->execute(array($pseudo));
        }
        
        public static function updateStatus($id_user) {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->prepare('UPDATE users '
                                     . 'SET ban = !ban '
                                     . 'WHERE id = ?');
            
            $request->execute(array($id_user));
        }


        public static function delete($id_user) {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->prepare('DELETE '
                                     . 'FROM users WHERE id = ?');
            
            $request->execute(array($id_user));
        }
        
        public static function verify($pseudo) {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->prepare('SELECT id '
                                     . 'FROM users WHERE pseudo = ?');
            
            $request->execute(array($pseudo));
            $result = $request->fetch();
            return $result;
        }
    }