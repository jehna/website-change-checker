<?php

$mysqli = new mysqli("localhost", "pickpool", "i1b5asKphUxS", "pickpool");

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
 
$query = "SELECT name, url FROM companies";
$sites = array();
if ($result = $mysqli->query($query)) {

    /* fetch object array */
    while ($obj = $result->fetch_object()) {
        $sites[$obj->name] = $obj->url;
    }

    /* free result set */
    $result->close();
}

/* close connection */
$mysqli->close();
?>
