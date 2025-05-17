<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $conn = new mysqli('localhost', 'root', '', 'travel');
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }
}
?>