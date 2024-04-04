<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S</title>
</head>
<body>
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

$conn = new Database("localhost", "gameweb", "root", "root");
?>
</body>
</html>