<?php
    include_once 'DBConnexion.php';

    class BilletsManager {
       public static function create(Billet $billet) {
           $pdo = DBConnexion::getInstance();
           $requete = $pdo->prepare('INSERT INTO billets (titre, text, id_utilisateur, date_post) '
                                    . 'VALUES (:titre, :text, :id_utilisateur, NOW())');
           
           $requete->execute(array('titre'=>$billet->getTitre(), 'text'=>$billet->getText(), 'id_utilisateur'=>$billet->getIdUtilisateur()));
       }
       
       public static function readAll() {
           $pdo = DBConnexion::getInstance();
           $requete = $pdo->query('SELECT b.id, b.titre, b.text, u.pseudo, b.date_post '
                                  . 'FROM billets b '
                                  . 'INNER JOIN utilisateurs u '
                                  . 'ON b.id_utilisateur = u.id '
                                  . 'ORDER BY date_post DESC LIMIT 0, 5');
           
           return $requete;
       }
    }