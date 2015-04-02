<?php  

//http://www.concrete5.org/documentation/how-tos/developers/creating-and-working-with-db-xml-files/

/*
 * http://www.concrete5.org/community/forums/customizing_c5/should-a-package-manually-drop-its-own-table-upon-uninstall
 */

defined('C5_EXECUTE') or die(_("Access Denied."));

class ZpartakovLoginPackage extends Package {

	protected $pkgHandle = 'zpartakov_login';
	protected $appVersionRequired = '5.3.3'; 
	protected $pkgVersion = '1.0.1';
	
	public function getPackageDescription() {
		return t("Add a login box as a block and a modified random password email reminder.");
	}
	
	public function getPackageName() {
		return t("ZpartakovLogin");
	}
	
	public function install() {
		$pkg = parent::install();
		
		// install block		
		BlockType::installBlockTypeFromPackage('zpartakovlogin', $pkg);
		BlockType::installBlockTypeFromPackage('passwordreminder', $pkg);
		
		
		//install database with default values
		  $db = Loader::db();
		  /*
		   * populate the table with default values
		   * 		
		   */
		  $sql="INSERT INTO zpartakovloginconf " .
		  		"(nologin," .
		  		"send_me_a_newpassword," .
		  		"webSiteName," .
		  		"mailSender," .
		  		"pageTitle," .
		  		"formDescription," .
		  		"sorryNoMatchingMail," .
		  		"Sujet," .
		  		"bodyMailBegin," .
		  		"bodyMailEnd," .
		  		"sendingMailFailed," .
		  		"pleaseCheckYourMail) " .
		  		"VALUES " .
		  		"('<p style=\"font-size: smaller; font-style: italic\">Pas encore de login? Demandez à <a href=\"mailto:John.Doe@johndoe.org\">John.Doe@johndoe.org</a>'," .
		  		"'<br/><a href=\"/c5/connexion\">Se faire renvoyer un mot de passe</a>'," .
		  		"'YoupLaBoum, johndoe.org','John Doe <John.Doe@johndoe.org>'," .
		  		"'Mot de passe oublié?'," .
		  		"'Saisissez votre adresse e-mail ci-dessous. Nous vous enverrons les instructions pour vous connecter sur ce site et un nouveau mot de passe.'," .
		  		"'<p>Désolé, ce mail n\'est pas enregistré dans notre base de données. Merci de <a href=\"mailto:John.Doe@johndoe.org\">prendre contact avec un administrateur du site</a></p>'," .
		  		"'Vos informations de connexion pour le site internet johndoe.org'," .
		  		"'Bonjour,
				Voici vos informations de connexion au site internet johndoe.org'," .
				"'Pour vous connecter: <a href=\"http://johndoe.org/login\">connexionUrl</a>
				En cas de problème de connexion, prenez contact avec <a href=\"mailto:John.Doe@johndoe.org\">John.Doe@johndoe.org</a>
				Meilleures salutations,
				Signature
				=======================
				Ceci est un message automatique envoyé par un robot depuis www.xxx'," .
				"'L\'envoi du mail a échoué'," .
				"'<div style=\"margin-top: 1em; padding: 1em; background-color: #FFFFC6\"><p>Veuillez consulter votre email " .$_POST['email'] .", vous aurez reçu vos informations de connexion.</p><p>Si vous ne le voyez pas, vérifiez que le mail ne soit pas passé dans les pourriels \(spam\)</p></div>')";
		  		
		  $db->Execute($sql);	

		  //install dashboard pages
		  SinglePage::add('/dashboard/passwordreminders/edit', $pkg);
		  
	}
	
	
public function uninstall() {
  parent::uninstall();
  $db = Loader::db();
  $db->Execute('drop table if exists zpartakovloginconf');
}

}