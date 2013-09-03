<?php
#
# server.php
#

require_once 'class.institution.php';
require_once 'class.institution_detail.php';
require_once 'class.sectionr.php';
require_once 'class.classe.php';
require_once 'class.directeur.php';
require_once 'include/config.php';
require_once 'include/ConnectionManager.php';


ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

function trace($msg){
	if($myfile = fopen("debug.log", "a+" )) {
		fputs($myfile, date("Y/m/d H:i:s").":".$msg);
		fputs($myfile, "\n\n");
		fclose($myfile);
	}
}

function get_single_value($query){
	$conManager = new ConManager();
	$db_handle = $conManager->getConnection();
	$result = $conManager->query($query);
	$row=$conManager->fetch($result);
	return $row[0];
}

function get_dept_code($departement)
{
	$query = "select distinct dept_code from GEO_DEPT where nom_departement = '$departement'";
	return get_single_value($query);
}

function get_arrond_code($arrond)
{
	$query = "select distinct arron_code from GEO_ARRONDISSEMENT where nom_arrondissement = '$arrond'";
	return get_single_value($query);
}

function get_commune_code($commune)
{
	$query = "select distinct comm_code from GEO_COMMUNE where nom_commune = '$commune'";
	return get_single_value($query);
}

function get_sectionr_code($section_rurale)
{
	$query = "select distinct sectionr_code from GEO_SECTION_RURAL where nom_section_rurale = '$section_rurale'";
	return get_single_value($query);
}

class Psugo
{
	/**
	 * @param  string
	 * @param  string
	 * @return integer
	 */
	public function SauvegarderCoordonneesGPS($user_name, $coordonnees){
		$query = "insert into GPS values (now(),'$user_name', '$coordonnees'";
		$conManager = new ConManager();
		$db_handle = $conManager->getConnection();
		$result = $conManager->query($query);
		return 1;
	}

	/**
	 * @param  string
	 * @param  string
	 * @return integer
	 */
	public function Login($user_name, $password){
//		trace("Login:".print_r($_SERVER,true));
		$conManager = new ConManager();
		$db_handle = $conManager->getConnection();

		$query = "select name from phpgen_user where name = '$user_name' and password = '$password';";
		$result = $conManager->query($query);
		$row = $conManager->fetch($result);

		if($row[0] != $user_name)
			return new SoapFault("Server", "Nom d'agent ($user_name) ou password invalide");

		session_start();
		$_SESSION['user'] = $user_name;
		return 1;
	}

	/**
	 * @return Institution[]
	 */
	public function ListerInstitution(){
//		trace("ListerInstitution:".print_r($_SERVER,true));
		if(!isset($_SESSION['user']))
			return new SoapFault("Server", LOGIN_ERROR);

		$user = $_SESSION['user'];
		$conManager = new ConManager();
		$db_handle = $conManager->getConnection();
		$conManager = new ConManager();
		$db_handle = $conManager->getConnection();

		$query = "select i.id, nom_institution, nom_departement, nom_arrondissement, nom_commune, nom_section_rurale, adresse, adresse_detail, trouvee, systeme from INSTITUTION i join (GEO_DEPT d, GEO_ARRONDISSEMENT a, GEO_COMMUNE c, GEO_SECTION_RURAL s, INSPECTEUR) on (i.dept_code = d.dept_code and i.arrond_code = a.arron_code and i.commune_code = c.comm_code and i.sectionr_code = s.sectionr_code and institution_id = i.id and (etat = 'F' or etat='V') and nom_inspecteur = '$user');";
		$result = $conManager->query($query);
		$institutions = new Institutions();
		while($row = $conManager->fetch($result)) {
			$institutions[] = new Institution($row['id'], $row['nom_institution'], $row['nom_departement'],$row['nom_arrondissement'],$row['nom_commune'],$row['nom_section_rurale'], $row['adresse'],  $row['adresse_detail'], $row['trouvee'], $row['systeme']);
		}
		return $institutions;
	}

	/**
	 * @return SectionRurale[]
	 */
	public function ListerSectionRurale(){
		if(!isset($_SESSION['user']))
			return new SoapFault("Server", LOGIN_ERROR);

		$user = $_SESSION['user'];
		$conManager = new ConManager();
		$db_handle = $conManager->getConnection();

		$query = "select nom_commune,  nom_section_rurale from INSTITUTION i join  (GEO_COMMUNE c, GEO_SECTION_RURAL s, INSPECTEUR insp) on c.comm_code = s.comm_code and c.comm_code = i.commune_code and i.id = insp.institution_id and (etat = 'F' or etat = 'V') and  nom_inspecteur = '$user';";
		$result = $conManager->query($query);
		$sectionRurales = new SectionRurales();
		while($row = $conManager->fetch($result)) {
			$conManager = new ConManager();
			$db_handle = $conManager->getConnection();
			$sectionRurales[] = new SectionRurale($row['nom_commune'],$row['nom_section_rurale']);
		}
		return $sectionRurales;
	}

	/**
	 * @param  InstitutionDetail
	 * @return int
	 */
	public function EnvoyerInstitution(InstitutionDetail $inst){
		if(!isset($_SESSION['user']))
			return new SoapFault("Server", LOGIN_ERROR);

		$user = $_SESSION['user'];
		$conManager = new ConManager();
		$db_handle = $conManager->getConnection();

		$dept = get_dept_code($inst->departement);
		$arrond = get_arrond_code($inst->arrondissement);
		$commune = get_commune_code($inst->commune);
		$sectionr = get_sectionr_code($inst->section_rurale);

		$nom = mysql_real_escape_string($inst->nom_institution);
		$adr = mysql_real_escape_string($inst->adresse);
		$adr_detail = mysql_real_escape_string($inst->adresse_detail);
		$trouvee = mysql_real_escape_string($inst->trouvee);
		$query = "update INSTITUTION set nom_institution='$nom', etat='V', dept_code=$dept, arrond_code=$arrond, commune_code=$commune, sectionr_code=$sectionr, adresse='$adr', adresse_detail='$adr_detail', telephone='$inst->telephone', trouvee='$trouvee', rec_udp_ts=now(), rec_udp_uid='$user' where id=$inst->id ;";
		$result = $conManager->query($query);

		$conManager->query("delete from PHOTO_INSTITUTION where institution_id = $inst->id");

		foreach($inst->photos as $p){
			$query = "insert into PHOTO_INSTITUTION values ('', $inst->id, '".mysql_real_escape_string(base64_decode($p->photo))."', '$p->localisation_gps', '$p->date_photo', '$p->type_photo', now(), '$user', now(), '$user')";
			$result = $conManager->query($query);
		}
		return 1;
	}
	/**
	 * @param  Classe
	 * @return int
	 */
	public function EnvoyerClasse(Classe $classe){
		if(!isset($_SESSION['user']))
			return new SoapFault("Server", LOGIN_ERROR);

		$user = $_SESSION['user'];
		$conManager = new ConManager();
		$db_handle = $conManager->getConnection();

		$inst_id = $classe->institution_id;
		$nom_classe = mysql_real_escape_string($classe->nom_classe);

		mysql_query("LOCK TABLES CLASSE, PHOTO_CLASSE, PROFESSEUR, PHOTO_PROFESSEUR WRITE;");

		$conManager->query("delete from CLASSE where institution_id = $inst_id and nom = '$nom_classe'");

		$query = "insert into CLASSE values ('', $inst_id, '$nom_classe', '$classe->nombre_eleve',  YEAR(CURDATE()), now(), '$user', now(), '$user')";
		$conManager->query($query);
		$classe_id =   mysql_insert_id();

		foreach($classe->photo as $p){
			$query = "insert into PHOTO_CLASSE values ('', $classe_id, '".mysql_real_escape_string(base64_decode($p->photo))."', '$p->localisation_gps', '$p->date_photo', '$p->type_photo', now(), '$user', now(), '$user')";
			$result = $conManager->query($query);
		}

		$prof = $classe->professeur;
		$query = "insert into PROFESSEUR values ('', $classe_id, '$prof->nom', now(), '$user', now(), '$user')";
		$conManager->query($query);
		$prof_id =   mysql_insert_id();

		$p=$prof->photo;
		$query = "insert into PHOTO_PROFESSEUR values ('', $prof_id, '".mysql_real_escape_string(base64_decode($p->photo))."', '$p->localisation_gps', '$p->date_photo', now(), '$user', now(), '$user')";
		$conManager->query($query);

		mysql_query("UNLOCK TABLES;");
		return 1;
	}
	/**
	 * @param  Directeur
	 * @return int
	 */
	public function EnvoyerDirecteur(Directeur $d){
		if(!isset($_SESSION['user']))
			return new SoapFault("Server", "Le client doit s'authentifier avant d'utiliser ce service");

		$user = $_SESSION['user'];
		$conManager = new ConManager();
		$db_handle = $conManager->getConnection();

		$inst_id = $d->institution_id;
		$nom= $d->nom;

		$conManager->query("delete from DIRECTEUR where institution_id = $inst_id and nom = '$nom'");

		$query = "insert into DIRECTEUR values ('', $inst_id, '$nom', '$d->genre', '$d->type_direction', '$d->email', '$d->telephone', '$d->cin', now(), '$user', now(), '$user')";
		$conManager->query($query);
		$dir_id =   mysql_insert_id();

		$p=$d->photo;
		$query = "insert into PHOTO_DIRECTEUR values ('', $dir_id, '".mysql_real_escape_string(base64_decode($p->photo))."', '$p->localisation_gps', '$p->date_photo', now(), '$p->type_photo', '$user', now(), '$user')";
		$conManager->query($query);

		return 1;
	}
}

	require 'wsdl/src/WSDLDocument.php';
	$wsdl = new WSDLDocument('Psugo');
	header('Content-Type: text/xml');
	echo $wsdl->saveXML();
?>