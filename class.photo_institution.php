<?php
class PhotoInstitution
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

	public function __construct($photo, $longitude, $latitude, $date, $type){
		$this->photo = $photo;
		$this->longitude = $longitude;
		$this->latitude = $latitude;
		$this->datePhoto = $date;
		$this->typePhoto = $type;
	}
}
?>