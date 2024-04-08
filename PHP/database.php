<?php
class Database{
    private $server = null;

    public function __construct($hst, $dbn, $usr, $pwd){
        $dsn = "mysql:host=$hst;dbname=$dbn";
        $user = $usr;
        $password = $pwd;

        try {
            $this->server = new PDO($dsn, $user, $password);

            $this->server->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            exit();
        }
    }

    public function getConnection() {
        return $this->server;
    }

}

