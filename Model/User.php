<?php
    class User {
        protected $id,
                  $pseudo,
                  $mdp,
                  $email,
                  $image;
        
          function getId() {
              return $this->id;
          }

          function getPseudo() {
              return $this->pseudo;
          }

          function getMdp() {
              return $this->mdp;
          }

          function getEmail() {
              return $this->email;
          }
          
          function getImage() {
              return $this->image;
          }

          function setId($id) {
              $this->id = $id;
          }

          function setPseudo($pseudo) {
              $this->pseudo = $pseudo;
          }

          function setMdp($mdp) {
              $this->mdp = $mdp;
          }

          function setEmail($email) {
              $this->email = $email;
          }
          
          function setImage($image) {
              $this->image = $image;
          }
    }