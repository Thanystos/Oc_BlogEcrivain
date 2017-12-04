<?php
class PDOFactory {  // Notre classe dédiée à la création de PDO
    
    public static function getMysqlConnexion() {
        try {
            $db = new PDO('mysql:host=localhost;dbname=blogecrivain', 'root', '');  // Mes informations permettant de me connecter à ma BDD
        } catch (Exception $ex) {
            die('Error :'.$ex->getMessage());
            echo 'NOT CONNECTED';
        }
        
        return $db;  // L'objet PDO qu'on communiquera à DBConnexion (Voir DBConnexion)
    }
}

