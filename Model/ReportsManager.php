<?php
    include_once 'DBConnexion.php';
    
    class ReportsManager {
        
        // Requête permettant de créer un signalement (Utile pour la page d'un billet unique)
        public static function create(Report $report) {
           $pdo = DBConnexion::getInstance();
           $request = $pdo->prepare('INSERT INTO reports(id_comment, id_user, date) '
                                    . 'VALUES(:id_comment, :id_user, NOW())');
           
           $request->execute(array('id_comment' => $report->getIdComment(), 'id_user' => $report->getIdUser()));
        }
        
        // Requête permettant de récupérer tous les signalements d'un utilisateur et d'un billet donnés (Utile pour la page d'un billet unique)
        public static function read($id_ticket, $id_user) {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->prepare('SELECT r.id_comment '
                                     . 'FROM reports r '
                                     . 'INNER JOIN comments c '
                                     . 'ON r.id_comment = c.id '
                                     . 'WHERE c.id_ticket = ? AND r.id_user = ?');
            
            $request->execute(array($id_ticket, $id_user));
            return $request;
        }
        
        // Requête permettant de récupérer le nom de toutes les personnes signalées pour des commentaires (Utile pour la page 'liste des signalements')
        public static function readReports() {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->query('SELECT u.pseudo '
                                   . 'FROM comments c '
                                   . 'INNER JOIN tickets t '
                                   . 'ON c.id_ticket = t.id '
                                   . 'INNER JOIN reports s '
                                   . 'ON c.id = s.id_comment '
                                   . 'INNER JOIN users u '
                                   . 'ON s.id_user = u.id '
                                   . 'ORDER BY t.id DESC');
            
            return $request;
        }
    }