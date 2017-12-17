<?php
    include 'Model/Comment.php';
    include_once 'Model/CommentsManager.php';
    include_once 'View/View.php';

    class ControllerComment {
        private $commentsManager;
        
        public function __construct() {
            $this->commentsManager = new CommentsManager();
        }
        
        // Méthode appelée lors de la création d'un nouveau commentaire
        public function addComment() {
            $comment = new Comment();
            $comment->setText(filter_input(INPUT_POST, 'comment'));
            $comment->setIdTicket($_SESSION['id_ticket']);
            $comment->setIdUser($_SESSION['id_user']);
            $this->commentsManager->create($comment);
            header('Location: billet_'.$_SESSION['id_ticket'].'.html');
        }
        
        // Méthode appelée lors de la mise à jour d'un commentaire
        public function updateComment() {
            $this->commentsManager->update(filter_input(INPUT_GET, 'id_comment'), filter_input(INPUT_POST, 'text'));
            header('Location: billet_'.$_SESSION['id_ticket'].'.html');
        }
        
        // Méthode appelée lors de la suppression d'un commentaire
        public function deleteComment() {
            $this->commentsManager->delete(filter_input(INPUT_GET, 'id_comment'));
            if(filter_input(INPUT_GET, 'list') == true) {
                header('Location: listesignalements.html');
            }
            else {
                header('Location: billet_'.$_SESSION['id_ticket'].'.html');
            }
        }
    }