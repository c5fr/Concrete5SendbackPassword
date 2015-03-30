<?php
defined('C5_EXECUTE') or die('Access Denied. ');
class PasswordreminderBlockController extends BlockController {
	
public function getBlockTypeDescription() {
	return t("Passwordreminder, send a random password by email");
}
public function getBlockTypeName() {
	return t("PasswordReminder");
}

public function view(){
		
}

}
?>
