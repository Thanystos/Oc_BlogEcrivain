<?php
    include_once 'DBConnexion.php';
    
    class ReportsManager {
        public static function create(Report $report) {
           $pdo = DBConnexion::getInstance();
           $request = $pdo->prepare('INSERT INTO reports(id_comment, id_user, date) '
                                    . 'VALUES(:id_comment, :id_user, NOW())');
           
           $request->execute(array('id_comment' => $report->getIdComment(), 'id_user' => $report->getIdUser()));
        }
        
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
    }