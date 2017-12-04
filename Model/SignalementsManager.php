<?php
    include_once 'DBConnexion.php';
    
    class SignalementsManager {
        public static function create(Signalement $signalement) {
           $pdo = DBConnexion::getInstance();
           $requete = $pdo->prepare('INSERT INTO signalements(id_commentaire, id_utilisateur, date) '
                                    . 'VALUES(:id_commentaire, :id_utilisateur, NOW())');
           
           $requete->execute(array('id_commentaire' => $signalement->getIdCommentaire(), 'id_utilisateur' => $signalement->getIdUtilisateur()));
        }
        
        public static function read($id_billet, $id_utilisateur) {
            $pdo = DBConnexion::getInstance();
            $requete = $pdo->prepare('SELECT s.id_commentaire '
                                     . 'FROM signalements s '
                                     . 'INNER JOIN commentaires c '
                                     . 'ON s.id_commentaire = c.id '
                                     . 'WHERE c.id_billet = ? AND s.id_utilisateur = ?');
            
            $requete->execute(array($id_billet, $id_utilisateur));
            return $requete;
        }
    }