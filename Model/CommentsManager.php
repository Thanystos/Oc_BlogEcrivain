<?php
    include_once 'Model.php';
    
    class CommentsManager extends Model {
        
        // Méthode permettant de créer un commentaire (Utile pour la page d'un billet unique)
        public function create(Comment $comment) {
            $sql = 'INSERT INTO comments (text, id_ticket, id_user, post_date) '
                        . 'VALUES (:text, :id_ticket, :id_user, NOW())';
           
            $request = $this->executeRequest($sql, array('text'=>$comment->getText(), 'id_ticket'=>$comment->getIdTicket(), 'id_user'=>$comment->getIdUser()));
            return $request;
        }

        // Requête permettant de récuperer les commentaires pour un billet et sa pagination de commentaire donnés (Utile pour la page d'un billet unique) 
        public function read($id_ticket, $page) {
            $sql = "SELECT c.id, c.text, u.pseudo, u.image, DATE_FORMAT(c.post_date, '%d/%m/%Y à %Hh%imin%ss') AS post_date "
                        . 'FROM comments c '
                        . 'INNER JOIN users u '
                        . 'ON c.id_user = u.id '
                        . 'WHERE c.id_ticket = ? '
                        . 'ORDER BY post_date DESC LIMIT '.(($page - 1) * 5).', 5';
            
            $request = $this->executeRequest($sql, array($id_ticket));
            return $request;
        }
        
        // Requête permettant de récupérer les commentaires d'un utilisateur donné (Utile pour la page de profil)
        public function readPseudo($pseudo) {
            $sql = 'SELECT c.text, c.post_date AS cpost_date, t.title, t.post_date AS tpost_date '
                        . 'FROM users u '
                        . 'INNER JOIN comments c '
                        . 'ON u.id = c.id_user '
                        . 'INNER JOIN tickets t '
                        . 'ON c.id_ticket = t.id '
                        . 'WHERE u.pseudo = ? '
                        . 'ORDER BY tpost_date DESC LIMIT 0, 5';
            
            $request = $this->executeRequest($sql, array($pseudo));
            return $request;
        }
        
        // Requête permettant de récupérer les commentaires signalés (Utile pour la page 'liste des signalements')
        public function readReports() {
            $sql = 'SELECT c.id, c.text, t.title, u.pseudo '
                        . 'FROM comments c '
                        . 'INNER JOIN tickets t '
                        . 'ON c.id_ticket = t.id '
                        . 'INNER JOIN reports s '
                        . 'ON c.id = s.id_comment '
                        . 'INNER JOIN users u '
                        . 'ON c.id_user = u.id '
                        . 'ORDER BY t.id DESC';
            
            $request = $this->executeRequest($sql);
            return $request;
        }

        // Requête permettant de mettre à jour un commentaire (Utile pour la page d'un billet unique)
        public function update($id_comment, $text) {
            $sql = 'UPDATE comments '
                        . 'SET text = ?, '
                        . 'post_date = NOW() '
                        . 'WHERE id = ?';
            
            $request = $this->executeRequest($sql, array($text, $id_comment));
            return $request;
        }
        
        // Méthode permettant de supprimer un commentaire (Utile pour la page d'un billet unique)
        public function delete($id_comment) {
            $sql = 'DELETE FROM comments '
                        . 'WHERE id = ?';
            
            $request = $this->executeRequest($sql, array($id_comment));
            return $request;
        }
        
        // Méthode permettant de compter le nombre de commentaires pour un billet donné (Utile pour la pagination de la page liste des billets)
        public function count($id_ticket) {
            $sql = 'SELECT COUNT(*) FROM comments '
                        . 'WHERE id_ticket = ?';
            
            $request = $this->executeRequest($sql, array($id_ticket));
            return $request;
        }
    }