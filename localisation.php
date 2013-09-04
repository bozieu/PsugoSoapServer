<?php

require_once 'include/config.php';
require_once 'include/ConnectionManager.php';

$telephone = $_REQUEST['t'];
$coordonnees = $_REQUEST['c'];

$query = "insert into GPS values ('', now(),'$telephone', '$coordonnees');";
$conManager = new ConManager();
$db_handle = $conManager->getConnection();
$result = $conManager->query($query);


?>