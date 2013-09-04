<?php
class Directeur
{
	/**
	 * @var int
	 */
	public $instituionId;

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
	public $typeDirection;

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
	 * @var PhotoDirecteur
	 */
	public $photo;
}
class PhotoDirecteur
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