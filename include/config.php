<?php
define('DB', "psugo3");
define("USE_MYSQL", "true");
define('SERVER', "localhost");
define('USER', "root");

$hostname = gethostname ();

if($hostname == "gandalf")
	define('PW', "sophieee");
else if($hostname == "bombadil")
	define('PW', "canada");
else if($hostname == "wally")
	define('PW', "canada01");
else
	define('PW', "canada2000;");

define('LOGIN_ERROR', "Le client doit s'authentifier avant d'utiliser ce service");