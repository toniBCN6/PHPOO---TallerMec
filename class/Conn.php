<?php

class Database {

    private $connection = null;
    private static $_instance = null;

    //Original
    private function __construct() {
        $this->connection = new PDO('mysql:host=localhost;dbname=tallerMec', 'root', 'root');
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    //metodo magico que evitar la clonación singletone.
    private function __clone(){}

    //instanceof es usado para instanciar una clase, en este caso Database
    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    // Realización de consultas 
    public function getQuery($sql) {
    return $this->connection->prepare($sql);
    }
}

?>