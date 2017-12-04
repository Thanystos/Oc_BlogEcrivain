<?php
    class Signalement {
            protected $id,
                      $idCommentaire,
                      $idUtilisateur,
                      $date;
            
              function getId() {
                  return $this->id;
              }

              function getIdCommentaire() {
                  return $this->idCommentaire;
              }

              function getIdUtilisateur() {
                  return $this->idUtilisateur;
              }

              function getDate() {
                  return $this->date;
              }

              function setId($id) {
                  $this->id = $id;
              }

              function setIdCommentaire($idCommentaire) {
                  $this->idCommentaire = $idCommentaire;
              }

              function setIdUtilisateur($idUtilisateur) {
                  $this->idUtilisateur = $idUtilisateur;
              }

              function setDate($date) {
                  $this->date = $date;
              }
    }