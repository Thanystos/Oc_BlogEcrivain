<?php
    class Report {
            protected $id,
                      $idComment,
                      $idUser,
                      $date;
            
              function getId() {
                  return $this->id;
              }

              function getIdComment() {
                  return $this->idComment;
              }

              function getIdUser() {
                  return $this->idUser;
              }

              function getDate() {
                  return $this->date;
              }

              function setId($id) {
                  $this->id = $id;
              }

              function setIdComment($idComment) {
                  $this->idComment = $idComment;
              }

              function setIdUser($idUser) {
                  $this->idUser = $idUser;
              }

              function setDate($date) {
                  $this->date = $date;
              }
    }