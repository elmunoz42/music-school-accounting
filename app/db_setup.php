<?php

$server = 'mysql:host=localhost:8889;dbname=crm_music';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);
$GLOBALS['DB']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// for postgresql
// $dbopts = parse_url(getenv('DATABASE_URL'));
// $app->register(new Herrera\Pdo\PdoServiceProvider(),
// array(
//     'pdo.dsn' => 'pgsql:dbname='.ltrim($dbopts["path"],'/').';host='.$dbopts["host"] . ';port=' . $dbopts["port"],
//     'pdo.username' => $dbopts["user"],
//     'pdo.password' => $dbopts["pass"]
//     )
// );
// $DB = $app['pdo'];
