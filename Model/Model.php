<?php
    include_once 'DBConnexion.php';
    
    abstract class Model {
        
        protected function executeRequest($sql, $params = null) {
            if($params == null) {
                $result = DBConnexion::getInstance()->query($sql);
            }
            else {
                $result = DBConnexion::getInstance()->prepare($sql);
                $result->execute($params);
            }
            return $result;
        }
    }