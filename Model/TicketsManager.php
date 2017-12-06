<?php
    include_once 'DBConnexion.php';

    class TicketsManager {
        public static function create(Ticket $ticket) {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->prepare('INSERT INTO tickets (title, text, id_user, post_date) '
                                     . 'VALUES (:title, :text, :id_user, NOW())');

            $request->execute(array('title'=>$ticket->getTitle(), 'text'=>$ticket->getText(), 'id_user'=>$ticket->getIdUser()));
        }

        public static function read($id_ticket) {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->prepare('SELECT t.id, t.title, t.text, u.pseudo, t.post_date '
                                     . 'FROM tickets t '
                                     . 'INNER JOIN users u '
                                     . 'ON t.id_user = u.id '
                                     . 'WHERE t.id = ?');

            $request->execute(array($id_ticket));
            return $request;
        }

        public static function readAll($page) {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->query('SELECT t.id, t.title, t.text, u.pseudo, t.post_date '
                                   . 'FROM tickets t '
                                   . 'INNER JOIN users u '
                                   . 'ON t.id_user = u.id '
                                   . 'ORDER BY post_date DESC LIMIT '.(($page - 1) * 5).', 5');

            return $request;
        }

        public static function update($id_ticket, $text) {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->prepare('UPDATE tickets '
                                     . 'SET text = ?, '
                                     . 'post_date = NOW() '
                                     . 'WHERE id = ?');

            $request->execute(array($text, $id_ticket));
        }

        public static function delete($id_ticket) {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->prepare('DELETE FROM tickets '
                                     . 'WHERE id = ?');

            $request->execute(array($id_ticket));
        }
        
        public static function count() {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->query('SELECT COUNT(id) '
                                   . 'FROM tickets');
            
            return $request;
        }
    }