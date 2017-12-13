<?php
    class User {
        protected $id,
                  $pseudo,
                  $password,
                  $email,
                  $image,
                  $nbReport,
                  $ban,
                  $role;
        
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
          
          function getNbReport() {
              return $this->nbReport;
          }
          
          function getBan() {
              return $this->ban;
          }
          
          function getRole() {
              return $this->role;
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
          
          function setNbReport($nbReport) {
              $this->nbReport = $nbReport;
          }
          
          function setBan($ban) {
              $this->ban = $ban;
          }
          
          function setRole($role) {
              $this->role = $role;
          }
    }