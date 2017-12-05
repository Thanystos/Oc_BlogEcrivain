<?php
    class Comment {
        protected $id,
                  $text,
                  $idTicket,
                  $idUser,
                  $postDate;

        function getId() {
            return $this->id;
        }

        function getText() {
            return $this->text;
        }

        function getIdTicket() {
            return $this->idTicket;
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

        function setText($text) {
            $this->text = $text;
        }

        function setIdTicket($idTicket) {
            $this->idTicket = $idTicket;
        }

        function setIdUser($idUser) {
            $this->idUser = $idUser;
        }

        function setPostDate($postDate) {
            $this->postDate = $postDate;
        }
    }