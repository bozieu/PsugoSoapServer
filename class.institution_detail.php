<?php
require_once 'class.photo_institution.php';

class InstitutionDetail
{
	/**
	 * @var integer
	 */
	public $id;

	/**
	 * @var string
	 */
	public $nomInstitution;

	/**
	 * @var string
	 */
	public $departement;

	/**
	 * @var string
	 */
	public $arrondissement;

	/**
	 * @var string
	 */
	public $commune;

	/**
	 * @var string
	 */
	public $sectionRurale;

	/**
	 * @var string
	 */
	public $adresse;

	/**
	 * @var string
	 */
	public $adresseDetail;

	/**
	 * @var string
	 */
	public $telephone;

	/**
	 * @var string
	 */
	public $instTrouvee;

	/**
	 * @var string
	 */
	public $systeme;

	/**
	 * @var PhotoInstitution[]
	 */
	public $photo;

	/**
	 * @var string
	 */
	public $infoBancaire;


	public function __construct($id, $nom_institution, $departement, $arrondissement, $commune, $section_rurale,
								$adresse, $adresse_detail, $telephone, $trouvee, $systeme, $infoBancaire) {
		$this->id = $id;
		$this->nomInstitution = $nom_institution;
		$this->departement = $departement;
		$this->arrondissement = $arrondissement;
		$this->commune = $commune;
		$this->sectionRurale = $section_rurale;
		$this->adresse=$adresse;
		$this->adresseDetail=$adresse_detail;
		$this->telephone=$telephone;
		$this->instTrouvee=$trouvee;
		$this->systeme=$systeme;
		$this->photo=null;
		$this->infoBancaire=$infoBancaire;
	}
}
?>