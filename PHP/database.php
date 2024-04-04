<?php
class Database{
    private $server = null;
    
    public function __construct($hst, $dbn, $usr, $pwd){
        $dsn = "mysql:host=$hst;dbname=$dbn";
        $user = $usr;
        $password = $pwd;

        $this->server = new PDO($dsn, $user, $password);
    }
}

$connection = new Database("localhost", "gameweb", "root", "root");
?>