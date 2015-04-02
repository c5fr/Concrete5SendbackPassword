<?php
class DashboardPasswordremindersEditController extends Controller {
	public function save() {
		$zpartakovloginconf=$_POST;//get datas
		$vals = array();//create array
		while (list($key, $val) = each($zpartakovloginconf)) { //push datas into array
			$vals[$key]=$val;
		}
		$db = Loader::db(); //load db
		$db->AutoExecute("zpartakovloginconf", $vals, "UPDATE", "bID = 0"); //do the sanitize query
		$this->redirect('/dashboard/passwordreminders/edit');//redirect to edit
	}
}
?>