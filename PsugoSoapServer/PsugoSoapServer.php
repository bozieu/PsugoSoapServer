<?php

if(basename($_SERVER['SCRIPT_FILENAME'])==basename(__FILE__))
	exit;

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

/**
 * This webservice send and receive information from the Psugo tablet
 *
 * @service PsugoSoapServer
 */
class PsugoSoapServer{

	/**
	 * Hello
	 *
	 * @param string $someone
	 * @return string Response string
	 */
	public function Hello($someone) {
		return "Hello Hello " . $someone . "!";
	}

	/**
	 * Login
	 *
	 * @param string $user_name User Name
	 * @param string $password Password
	 * @return string Response string ("False" - Login denied, "True" - Login accepted)
	 */
	public function Login($user_name, $password){
		$name=utf8_decode($name);// Because a string parameter may be UTF-8 encoded...
		$password=utf8_decode($password);// Because a string parameter may be UTF-8 encoded...
		return "True";
	}
}

require 'qq/src/WSDLDocument.php';
$wsdl = new WSDLDocument('PsugoSoapServer');
header('Content-Type: text/xml');
echo $wsdl->saveXML();

$server = new SoapServer(null, array('uri' => "urn://www.herong.home/res"));
$server->setClass("PsugoSoapServer");
$server->handle();


