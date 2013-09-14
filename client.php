<?php
#
# client.php
#

require_once 'class.institution_detail.php';
require_once 'class.classe.php';
require_once 'class.directeur.php';
$client = new SoapClient(null, array(
		'location' => "http://localhost/PsugoSoapServer/server.php",
		'uri'      => "http://localhost/PsugoSoapServer/server",
		'trace'    => 1 ));

//   $return = $client->__soapCall("Hello",array("world"));
//   echo("\nReturning value of __soapCall() call: ".$return);

//   echo("\nDumping request headers:\n"
//      .$client->__getLastRequestHeaders());

//   echo("\nDumping request:\n".$client->__getLastRequest());

//   echo("\nDumping response headers:\n"
//      .$client->__getLastResponseHeaders());

//   echo("\nHello: Dumping response:\n".$client->__getLastResponse());


// Login
$return = $client->__soapCall("Login",array("agent01", "5304240"));
echo("\nLogin: Dumping response:\n".$client->__getLastResponse());


// ListerInstitution
$return = $client->__soapCall("ListerInstitution",array(""));
echo("\nListerInstitution: Dumping response:\n".$client->__getLastResponse());

// ListerSectionRurale
$return = $client->__soapCall("ListerSectionRurale",array(""));
echo("\nListerSectionRurale: Dumping response:\n".$client->__getLastResponse());

// EnvoyerInstitution
$inst = new InstitutionDetail(1, "Nom Ecole", "Artibonite", "Dessalines", "Desdunes", "1ER SECT. DE DESDUNES", "adresse", "adresse détail", "514 607-9375", "O", "U", 'BNQ-123456');

$handle = fopen("./qq.jpg", "r");
$contents = fread($handle, filesize("./qq.jpg"));
fclose($handle);

$inst->photo[] = new PhotoInstitution(base64_encode($contents), "12.1234", "40.1234", "2013-08-10 12:12:12", "D");
$inst->photo[] = new PhotoInstitution(base64_encode($contents), "12.1235", "40.1235", "2013-08-10 13:13:13", "1");
$inst->photo[] = new PhotoInstitution(base64_encode($contents), "12.1235", "40.1235", "2013-08-10 13:13:13", "2");

try {
	$return = $client->__soapCall("EnvoyerInstitution", array($inst));
}
catch (SoapFault $exception)
{
	echo 'EXCEPTION='.$exception;
}
echo("\nEnvoyerInstitution: Dumping response:\n".$client->__getLastResponse());

// EnvoyerClasse
$classe = new Classe();
$classe->institutionId = 1;
$classe->nomClasse = '1A';
$classe->nombreEleve = 100;

$classe->photoClasse = new PhotoClasse();
$classe->photoClasse->photo=base64_encode($contents);
$classe->photoClasse->longitude = "12.1235";
$classe->photoClasse->latitude = "40.1235";
$classe->photoClasse->datePhoto = "2013-08-10 13:13:13";
$classe->photoClasse->typePhoto = "1";

$classe->nomProfesseur = "Nom prof";
$classe->genreProf = "F";
$classe->emailProf = "email prof";
$classe->phoneProf = "telephone prof";
$classe->cinProf = "CIN prof";

$classe->photoProfesseur = new PhotoProfesseur();
$classe->photoProfesseur->photo=base64_encode($contents);
$classe->photoProfesseur->longitude = "12.1235";
$classe->photoProfesseur->latitude = "40.1235";
$classe->photoProfesseur->datePhoto = "2013-08-10 13:13:13";

$return = $client->__soapCall("EnvoyerClasse", array($classe));
echo("\nEnvoyerClasse: Dumping response:\n".$client->__getLastResponse());

// EnvoyerDirecteur
$d = new Directeur();
$d->institutionId = 1;
$d->nom = "Nom Directeur A";
$d->genre = "M";
$d->typeDirection = "A";
$d->email = "qq@qq.com";
$d->telephone = "514 238-7510";
$d->cin= "123456";
$d->photo = new PhotoDirecteur();

$d->photo->photo=base64_encode($contents);
$d->photo->longitude = "12.1235";
$d->photo->latitude = "40.1235";
$d->photo->datePhoto = "2013-08-10 13:13:13";
$d->photo->typePhoto = "1";

$return = $client->__soapCall("EnvoyerDirecteur", array($d));
echo("\nEnvoyerClasse: Dumping response:\n".$client->__getLastResponse());

?>
