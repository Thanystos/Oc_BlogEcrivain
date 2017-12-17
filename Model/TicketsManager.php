<?php
    include_once 'Model.php';

    class TicketsManager extends Model {
        
        // Requête permettant de créer un billet (utile lors de la création d'un billet)
        public function create(Ticket $ticket) {
            $sql = 'INSERT INTO tickets (title, text, id_user, post_date) '
                        . 'VALUES (:title, :text, :id_user, NOW())';

            $request = $this->executeRequest($sql, array('title'=>$ticket->getTitle(), 'text'=>$ticket->getText(), 'id_user'=>$ticket->getIdUser()));
            return $request;
        }
        
        // Requête permettant de récupérer les informations d'un billet donné (Utile pour la page d'un billet unique)
        public function read($id_ticket) {
            $sql = "SELECT t.id, t.title, t.text, u.pseudo, DATE_FORMAT(t.post_date, '%d/%m/%Y') AS post_date "
                        . 'FROM tickets t '
                        . 'INNER JOIN users u '
                        . 'ON t.id_user = u.id '
                        . 'WHERE t.id = ?';

            $request = $this->executeRequest($sql, array($id_ticket));
            return $request;
        }

        // Requête permettant de récupérer l'ensemble des billets (Utile pour la page liste des billets)
        public function readAll($page) {
            $sql = "SELECT t.id, t.title, t.text, u.pseudo, DATE_FORMAT(t.post_date, '%d/%m/%Y à %Hh%imin%ss') AS post_date "
                        . 'FROM tickets t '
                        . 'INNER JOIN users u '
                        . 'ON t.id_user = u.id '
                        . 'ORDER BY post_date DESC LIMIT '.(($page - 1) * 5).', 5';

            $request = $this->executeRequest($sql);
            return $request;
        }

        // Requête permettant de mettre à jour le contenu d'un billet (Utile pour la page d'un billet unique)
        public function update($id_ticket, $text) {
            $sql = 'UPDATE tickets '
                        . 'SET text = ?, '
                        . 'post_date = NOW() '
                        . 'WHERE id = ?';

            $request = $this->executeRequest($sql, array($text, $id_ticket));
            return $request;
        }

        // Requête permettant de supprimer un billet (Utile pour la page d'un billet unique)
        public function delete($id_ticket) {
            $sql = 'DELETE FROM tickets '
                        . 'WHERE id = ?';

            $request = $this->executeRequest($sql, (array($id_ticket)));
            return $request;
        }
        
        // Requête permettant de compter le nombre de billets (Utile pour la pagination de la page liste des billets)
        public function count() {
            $sql = 'SELECT COUNT(id) '
                            . 'FROM tickets';
            
            $request = $this->executeRequest($sql);
            return $request;
        }
    }