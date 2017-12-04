<?php
    class Billet {
        protected $id,
                  $titre,
                  $text,
                  $id_utilisateur,
                  $datePost;
        
        function getId() {
            return $this->id;
        }

        function getTitre() {
            return $this->titre;
        }

        function getText() {
              return $this->text;
        }

        function getIdUtilisateur() {
            return $this->id_utilisateur;
        }

        function getDatePost() {
            return $this->datePost;
        }

        function setId($id) {
            $this->id = $id;
        }

        function setTitre($titre) {
            $this->titre = $titre;
        }

        function setText($text) {
            $this->text = $text;
        }

        function setIdUtilisateur($id_utilisateur) {
            $this->id_utilisateur = $id_utilisateur;
        }
          
        function setDatePost($datePost) {
            $this->datePost = $datePost;
        }
    }