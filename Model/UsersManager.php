<?php
    include 'DBConnexion.php';
    
    class UsersManager {
        public static function create(User $user) {
            $pdo = DBConnexion::getInstance();
            $requete = $pdo->prepare('INSERT INTO utilisateurs (pseudo, mdp, email, image) '
                                     . 'VALUES (:pseudo, :mdp, :email, :image)');
            
            $requete->execute(array('pseudo'=>$user->getPseudo(), 'mdp'=>$user->getMdp(), 'email'=>$user->getEmail(), 'image'=>$user->getImage()));
        }
        
        public static function read($identifiant, $mdp) {
            $pdo = DBConnexion::getInstance();
            $requete = $pdo->prepare('SELECT id, pseudo, mdp, email, image, role, ban '
                                     . 'FROM utilisateurs '
                                     . 'WHERE pseudo = ?');
            
            $requete->execute(array($identifiant));
            $resultat = $requete->fetch();
            if (($resultat)&&((password_verify($mdp, $resultat['mdp'])))) {
                return $resultat;
            }
        }
        
        public static function readId($pseudo) {
            $pdo = DBConnexion::getInstance();
            $requete = $pdo->prepare('SELECT id '
                                     . 'FROM utilisateurs '
                                     . 'WHERE pseudo = ?');
            
            $requete->execute(array($pseudo));
            return $requete;
        }
		
		public static function readall() {
            $pdo = DBConnexion::getInstance();
            $requete = $pdo->query('SELECT * '
                                   . 'FROM utilisateurs '
                                   . 'ORDER BY nb_signal DESC');
            
            return $requete;
        }
		
		public static function updateSignal($pseudo) {
            $pdo = DBConnexion::getInstance();
            $requete = $pdo->prepare('UPDATE utilisateurs '
                                     . 'SET nb_signal = nb_signal + 1 '
                                     . 'WHERE pseudo = ?');
            
            $requete->execute(array($pseudo));
        }
        
        public static function updateStatut($id_utilisateur) {
            $pdo = DBConnexion::getInstance();
            $requete = $pdo->prepare('UPDATE utilisateurs '
                                     . 'SET ban = !ban '
                                     . 'WHERE id = ?');
            
            $requete->execute(array($id_utilisateur));
        }


        public static function delete($id) {
            $pdo = DBConnexion::getInstance();
            $requete = $pdo->prepare('DELETE '
                                     . 'FROM utilisateurs WHERE id = ?');
            
            $requete->execute(array($id));
        }
        
        public static function verify($pseudo) {
            $pdo = DBConnexion::getInstance();
            $requete = $pdo->prepare('SELECT id '
                                     . 'FROM utilisateurs WHERE pseudo = ?');
            
            $requete->execute(array($pseudo));
            $resultat = $requete->fetch();
            return $resultat;
        }
    }