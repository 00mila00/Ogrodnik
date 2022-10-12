<?php

function connect() {
    $host = "localhost";
    $database = "ogrodnik";
    $user = "root";
    $password = "";

    $con = mysqli_connect($host, $user, $password, $database);

    if (!$con) {
        die("No connection to server!");
    } else {
        return $con;
    }
}
