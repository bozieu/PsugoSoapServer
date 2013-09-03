<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

// ----- YOUR APPLICATION DEFINITIONS

class Birthdate
{
    /**
     * @var integer
     */
    public $year;

    /**
     * @var integer
     */
    public $month;

    /**
     * @var integer
     */
    public $day;
}

class Person
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $email;

    /**
     * @var Birthdate
     */
    public $birthdate;

    /**
     * @var Person[]
     */
    public $children;
}

class PersonService
{
    /**
     * @param  integer
     * @return Person
     */
    public function findById($id){}

    /**
     * @param  string
     * @return Person[]
     */
    public function findByName($name){
    }

    /**
     * @param  Person
     * @return void
     */
    public function save($person){}
}

// ----- USAGE

require '../src/WSDLDocument.php';
$wsdl = new WSDLDocument('PersonService');
header('Content-Type: text/xml');
echo $wsdl->saveXML();
