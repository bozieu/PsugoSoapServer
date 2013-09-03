<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

// ----- YOUR APPLICATION DEFINITIONS

class Math
{
    /**
     * @param  float
     * @param  float
     * @return float
     */
    public function sum($num0, $num1){}

    /**
     * @param  float
     * @param  float
     * @return float
     */
    public function mult($num0, $num1){}
}

// ----- USAGE

require '../src/WSDLDocument.php';
$wsdl = new WSDLDocument('Math');
header('Content-Type: text/xml');
echo $wsdl->saveXML();
