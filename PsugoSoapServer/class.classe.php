<?php
class Classe
{
	/**
	 * @var int
	 */
	public $instituionId;

	/**
	 * @var string
	 */
	public $nomClasse;

	/**
	 * @var int
	 */
	public $nombreEleve;

	/**
	 * @var PhotoClasse
	 */
	public $photoClasse;

	/**
	 * @var string
	 */
	 public $nomProfesseur;

 	/**
	 * @var string
	 */
	 public $emailProf;

	/**
	 * @var string
	 */
	 public $phoneProf;
	 
	 /**
	  * @var string
	  */
 	public $cinProf;
 	
	 /**
	  * @var string
	  */
 	public $genreProf ; // Masculin ou Feminin

	/**
	 * @var PhotoProfesseur
	 */
 	public $photoProfesseur;
}

class PhotoClasse
{
	/**
	 * @var string
	 */
	public $photo;

	/**
	 * @var string
	 */
	public $longitude;

	/**
	 * @var string
	 */
	public $latitude;
	
	/**
	 * @var string
	 */
	public $datePhoto;

	/**
	 * @var int
	 */
	public $typePhoto;
}

class Professeur
{
	/**
	 * @var string
	 */
	public $nom;

	/**
	 * @var string
	 */
	public $genre;

	/**
	 * @var string
	 */
	public $email;

	/**
	 * @var string
	 */
	public $telephone;

	/**
	 * @var string
	 */
	public $cin;

	/**
	 * @var PhotoProfesseur
	 */
	public $photo;
}
class PhotoProfesseur
{
	/**
	 * @var string
	 */
	public $photo;

	/**
	 * @var string
	 */
	public $longitude;

	/**
	 * @var string
	 */
	public $latitude;
	
	/**
	 * @var string
	 */
	public $datePhoto;
}