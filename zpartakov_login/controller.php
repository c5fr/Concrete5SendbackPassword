<?php  
defined('C5_EXECUTE') or die(_("Access Denied."));

class ZpartakovLoginPackage extends Package {

	protected $pkgHandle = 'zpartakov_login';
	protected $appVersionRequired = '5.3.3'; 
	protected $pkgVersion = '1.1.1';
	
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
		
	}

}