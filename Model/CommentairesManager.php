<?php
    include_once 'DBConnexion.php';
    
    class CommentairesManager {
        public static function create(Commentaire $commentaire) {
            $pdo = DBConnexion::getInstance();
            $requete = $pdo->prepare('INSERT INTO commentaires (text, id_billet, id_utilisateur, date_post) '
                                     . 'VALUES (:text, :id_billet, :id_utilisateur, NOW())');
           
            $requete->execute(array('text'=>$commentaire->getText(), 'id_billet'=>$commentaire->getIdBillet(), 'id_utilisateur'=>$commentaire->getIdUtilisateur()));
        }

        public static function read($id_billet) {
            $pdo = DBConnexion::getInstance();
            $requete = $pdo->prepare('SELECT c.id, c.text, u.pseudo, u.image, c.date_post '
                                     . 'FROM commentaires c '
                                     . 'INNER JOIN utilisateurs u '
                                     . 'ON c.id_utilisateur = u.id '
                                     . 'WHERE c.id_billet = ? '
                                     . 'ORDER BY date_post DESC');
            
            $requete->execute(array($id_billet));
            return $requete;
        }
		
		public static function readSignal() {
            $pdo = DBConnexion::getInstance();
            $requete = $pdo->query('SELECT c.text, b.id, b.titre, u.pseudo '
                                   . 'FROM commentaires c '
                                   . 'INNER JOIN billets b '
                                   . 'ON c.id_billet = b.id '
                                   . 'INNER JOIN signalements s '
                                   . 'ON c.id = s.id_commentaire '
                                   . 'INNER JOIN utilisateurs u '
                                   . 'ON s.id_utilisateur = u.id');
            
            return $requete;
        }

        public static function update($id_commentaire, $text) {
            $pdo = DBConnexion::getInstance();
            $requete = $pdo->prepare('UPDATE commentaires '
                                     . 'SET text = ?, '
                                     . 'date_post = NOW() '
                                     . 'WHERE id = ?');
            $requete->execute(array($text, $id_commentaire));
        }
        
        public static function delete($id_commentaire) {
            $pdo = DBConnexion::getInstance();
            $requete = $pdo->prepare('DELETE FROM commentaires '
                                     . 'WHERE id = ?');
            
            $requete->execute(array($id_commentaire));
        }
        
        public static function count($id_billet) {
            $pdo = DBConnexion::getInstance();
            $requete = $pdo->prepare('SELECT COUNT(*) FROM commentaires '
                                     . 'WHERE id_billet = ?');
            
            $requete->execute(array($id_billet));
            return $requete;
        }
    }