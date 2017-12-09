<?php
    include_once 'DBConnexion.php';
    
    class CommentsManager {
        public static function create(Comment $comment) {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->prepare('INSERT INTO comments (text, id_ticket, id_user, post_date) '
                                     . 'VALUES (:text, :id_ticket, :id_user, NOW())');
           
            $request->execute(array('text'=>$comment->getText(), 'id_ticket'=>$comment->getIdTicket(), 'id_user'=>$comment->getIdUser()));
        }

        public static function read($id_ticket, $page) {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->prepare("SELECT c.id, c.text, u.pseudo, u.image, DATE_FORMAT(c.post_date, '%d/%m/%Y à %Hh%imin%ss') AS post_date "
                                     . 'FROM comments c '
                                     . 'INNER JOIN users u '
                                     . 'ON c.id_user = u.id '
                                     . 'WHERE c.id_ticket = ? '
                                     . 'ORDER BY post_date DESC LIMIT '.(($page - 1) * 5).', 5');
            
            $request->execute(array($id_ticket));
            return $request;
        }
        
        public static function readPseudo($pseudo) {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->prepare('SELECT c.text, c.post_date AS cpost_date, t.title, t.post_date AS tpost_date '
                                     . 'FROM users u '
                                     . 'INNER JOIN comments c '
                                     . 'ON u.id = c.id_user '
                                     . 'INNER JOIN tickets t '
                                     . 'ON c.id_ticket = t.id '
                                     . 'WHERE u.pseudo = ?');
            
            $request->execute(array($pseudo));
            return $request;
        }
        
        public static function readReports() {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->query('SELECT c.id, c.text, t.title, u.pseudo '
                                   . 'FROM comments c '
                                   . 'INNER JOIN tickets t '
                                   . 'ON c.id_ticket = t.id '
                                   . 'INNER JOIN reports s '
                                   . 'ON c.id = s.id_comment '
                                   . 'INNER JOIN users u '
                                   . 'ON c.id_user = u.id '
                                   . 'ORDER BY t.id DESC');
            
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