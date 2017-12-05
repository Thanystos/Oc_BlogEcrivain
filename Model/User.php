<?php
    class User {
        protected $id,
                  $pseudo,
                  $password,
                  $email,
                  $image;
        
          function getId() {
              return $this->id;
          }

          function getPseudo() {
              return $this->pseudo;
          }

          function getPassword() {
              return $this->password;
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

          function setPassword($password) {
              $this->password = $password;
          }

          function setEmail($email) {
              $this->email = $email;
          }
          
          function setImage($image) {
              $this->image = $image;
          }
    }