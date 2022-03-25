<?php
spl_autoload_register(function ($class_name){
    include 'classes/' . $class_name . '.class.php';
});

/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'root');
define('DB_USERNAME', '....');
define('DB_PASSWORD', '-password');
define('DB_NAME', 'write-db-name');
 
/* Attempt to connect to MySQL database */
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}
?>
