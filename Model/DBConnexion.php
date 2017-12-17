<?php
include_once 'PDOFactory.php';

class DBConnexion {  // Mon singleton qu'on appelera à chaque connexion
    protected static $instance;
    protected $pdo;
    
    protected function __construct() {  // Impossible à appeler directement
        $this->pdo = PDOFactory::getMysqlConnexion(); // On obtient notre PDO (voir PDOFactory)
    }
    
    public static function getInstance() {  // Cette méthode sera appelée à chaque nouvelle connexion
        if (!self::$instance) {  // Si aucune instance n'existe encore,
            self::$instance = new self();  // On en crée une en entrant dans le constructeur
        }
        return self::$instance;  // Sinon on retourne celle existante
    }
    
    public function query($sql) {
        return $this->pdo->query($sql);
    }
    
    public function prepare($sql) {
        return $this->pdo->prepare($sql);
    }
}