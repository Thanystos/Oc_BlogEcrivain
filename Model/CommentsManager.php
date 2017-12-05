<?php
    include_once 'DBConnexion.php';
    
    class CommentsManager {
        public static function create(Comment $comment) {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->prepare('INSERT INTO comments (text, id_ticket, id_user, post_date) '
                                     . 'VALUES (:text, :id_ticket, :id_user, NOW())');
           
            $request->execute(array('text'=>$comment->getText(), 'id_ticket'=>$comment->getIdTicket(), 'id_user'=>$comment->getIdUser()));
        }

        public static function read($id_ticket) {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->prepare('SELECT c.id, c.text, u.pseudo, u.image, c.post_date '
                                     . 'FROM comments c '
                                     . 'INNER JOIN users u '
                                     . 'ON c.id_user = u.id '
                                     . 'WHERE c.id_ticket = ? '
                                     . 'ORDER BY post_date DESC');
            
            $request->execute(array($id_ticket));
            return $request;
        }
        
        public static function readReports() {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->query('SELECT c.text, t.id, t.title, u.pseudo '
                                   . 'FROM comments c '
                                   . 'INNER JOIN tickets t '
                                   . 'ON c.id_ticket = t.id '
                                   . 'INNER JOIN reports s '
                                   . 'ON c.id = s.id_comment '
                                   . 'INNER JOIN users u '
                                   . 'ON s.id_user = u.id');
            
            return $request;
        }

        public static function update($id_comment, $text) {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->prepare('UPDATE comments '
                                     . 'SET text = ?, '
                                     . 'post_date = NOW() '
                                     . 'WHERE id = ?');
            $request->execute(array($text, $id_comment));
        }
        
        public static function delete($id_comment) {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->prepare('DELETE FROM comments '
                                     . 'WHERE id = ?');
            
            $request->execute(array($id_comment));
        }
        
        public static function count($id_ticket) {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->prepare('SELECT COUNT(*) FROM comments '
                                     . 'WHERE id_ticket = ?');
            
            $request->execute(array($id_ticket));
            return $request;
        }
    }