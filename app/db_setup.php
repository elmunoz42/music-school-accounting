<?php

$server = 'mysql:host=localhost:8889;dbname=crm_music';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);
$GLOBALS['DB']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
