<?php

        class Conn {

            public function __construct() {
                try {
                    $this->connection = new PDO("mysql:host=localhost;dbname=tallerMec", 'root', 'root',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));  
                }
                catch (PDOException $e) {
                    echo 'Falló la conexión: ' . $e->getMessage();
                } 
            }
        }
?>
