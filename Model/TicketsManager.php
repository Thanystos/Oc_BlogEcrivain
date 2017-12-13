<?php
    include_once 'DBConnexion.php';

    class TicketsManager {
        
        // Requête permettant de créer un billet (utile lors de la création d'un billet)
        public static function create(Ticket $ticket) {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->prepare('INSERT INTO tickets (title, text, id_user, post_date) '
                                     . 'VALUES (:title, :text, :id_user, NOW())');

            $request->execute(array('title'=>$ticket->getTitle(), 'text'=>$ticket->getText(), 'id_user'=>$ticket->getIdUser()));
        }
        
        // Requête permettant de récupérer les informations d'un billet donné (Utile pour la page d'un billet unique)
        public static function read($id_ticket) {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->prepare("SELECT t.id, t.title, t.text, u.pseudo, DATE_FORMAT(t.post_date, '%d/%m/%Y') AS post_date "
                                     . 'FROM tickets t '
                                     . 'INNER JOIN users u '
                                     . 'ON t.id_user = u.id '
                                     . 'WHERE t.id = ?');

            $request->execute(array($id_ticket));
            return $request;
        }

        // Requête permettant de récupérer l'ensemble des billets (Utile pour la page liste des billets)
        public static function readAll($page) {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->query("SELECT t.id, t.title, t.text, u.pseudo, DATE_FORMAT(t.post_date, '%d/%m/%Y à %Hh%imin%ss') AS post_date "
                                   . 'FROM tickets t '
                                   . 'INNER JOIN users u '
                                   . 'ON t.id_user = u.id '
                                   . 'ORDER BY post_date DESC LIMIT '.(($page - 1) * 5).', 5');

            return $request;
        }

        // Requête permettant de mettre à jour le contenu d'un billet (Utile pour la page d'un billet unique)
        public static function update($id_ticket, $text) {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->prepare('UPDATE tickets '
                                     . 'SET text = ?, '
                                     . 'post_date = NOW() '
                                     . 'WHERE id = ?');

            $request->execute(array($text, $id_ticket));
        }

        // Requête permettant de supprimer un billet (Utile pour la page d'un billet unique)
        public static function delete($id_ticket) {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->prepare('DELETE FROM tickets '
                                     . 'WHERE id = ?');

            $request->execute(array($id_ticket));
        }
        
        // Requête permettant de compter le nombre de billets (Utile pour la pagination de la page liste des billets)
        public static function count() {
            $pdo = DBConnexion::getInstance();
            $request = $pdo->query('SELECT COUNT(id) '
                                   . 'FROM tickets');
            
            return $request;
        }
    }