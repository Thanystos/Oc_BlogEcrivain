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
    }