<?php

/**
 *
 */
class Conn
{
    private $conn;
    public function DatabaseConn() {
         // create db connection

         try {
            $this->conn = new PDO('mysql:host=localhost;port=3306;dbname=test',
                'root',
                'root',
                array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                return $this->conn;
             }
         catch(PDOException $e)
             {
             echo "Connection failed: " . $e->getMessage();
             }

    }
}


 ?>
