<?php
    class Ticket {
        protected $id,
                  $title,
                  $text,
                  $idUser,
                  $postDate;
        
        function getId() {
            return $this->id;
        }

        function getTitle() {
            return $this->title;
        }

        function getText() {
              return $this->text;
        }

        function getIdUser() {
            return $this->idUser;
        }

        function getPostDate() {
            return $this->postDate;
        }

        function setId($id) {
            $this->id = $id;
        }

        function setTitre($title) {
            $this->title = $title;
        }

        function setText($text) {
            $this->text = $text;
        }

        function setIdUtilisateur($idUser) {
            $this->idUser = $idUser;
        }
          
        function setPostDate($postDate) {
            $this->postDate = $postDate;
        }
    }