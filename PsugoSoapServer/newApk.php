<?php
// Bon, je suis paresseux
// J'ai fait 2 cas simple
//
// 		1 - on a le telephone et le nom d'un apk
// 		2 - on a seulement le telephone
//
// Dans le cas 1, j'interprete ca comme un une requet pour dire que le client a mis a jour cette apk.
//
// Dans le cas 2, j'interprete ca comme une demande pour savoir si on a un apk a mettre a jour.
// Dans ce cas on retourne un string avec un nom de service (1 à la fois s'il y en a plusieurs
//
// Bogue: Si la tablette se met à jour et que la communication ne fonctionne pas,
// 		  On ne saura pas que la tablette est mise à jour et le cas 2 sera répété ...

require_once 'include/config.php';
require_once 'include/ConnectionManager.php';

$telephone = $_REQUEST['t'];

if(isset($_REQUEST['a']))


if(isset($telephone)){
	$conManager = new ConManager();
	$db_handle = $conManager->getConnection();

	// Le client est mise à jour
	if(isset($apkName)){
		$query = "update APK set date=now(), installed='O' where telephone = '$telephone' and apk_name = '$apkName';";
		$result = $conManager->query($query);
	}

	// le client veut savoir si il y a une nouvelle version
	else{
		$query = "select apk_name from APK where telephone = '$telephone' and installed = 'N' limit 1;";
		$result = $conManager->query($query);
		$row=$conManager->fetch($result);
		echo $row[0];
	}
}
?>