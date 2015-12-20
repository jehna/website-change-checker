<?php

$site = $_GET['site'];

include 'sites.php';

$aa = $sites[$site];

if(empty($aa)) throw(new Exception("lol"));

$newData = file_get_contents($aa);
file_put_contents("/home/jehna/thejunkland.com/itala/tmp/" . $site, $newData);
file_put_contents("/home/jehna/thejunkland.com/itala/tmp_recent/" . $site, $newData);