<?php
    class Commentaire {
        protected $id,
                  $text,
                  $idBillet,
                  $idUtilisateur,
                  $datePost;

        function getId() {
            return $this->id;
        }

        function getText() {
            return $this->text;
        }

        function getIdBillet() {
            return $this->idBillet;
        }

        function getIdUtilisateur() {
            return $this->idUtilisateur;
        }

        function getDatePost() {
            return $this->datePost;
        }

        function setId($id) {
            $this->id = $id;
        }

        function setText($text) {
            $this->text = $text;
        }

        function setIdBillet($idBillet) {
            $this->idBillet = $idBillet;
        }

        function setIdUtilisateur($idUtilisateur) {
            $this->idUtilisateur = $idUtilisateur;
        }

        function setDatePost($datePost) {
            $this->datePost = $datePost;
        }
    }