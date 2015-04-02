<?php
defined('C5_EXECUTE') or die(_("Access Denied."));

/*
 * password reminder / connexion sender
 * adapt to your needs ~lines 109 sq
 * */

function passe_mnemo(){
	#Description :
	#Génère un mot de passe prononçable, pour faciliter sa mémorisation, mais malgré tout assez compliqué.
	#Par exemple :
	#ZbleUrg (prononçable, mais difficile).
	#Auteur : Damien Seguy
	#Url : http://www.nexen.net
	if (func_num_args() == 1){ $nb = func_get_arg(0);} else { $nb = 6;}

	// on utilise certains chiffres : 1 = i, 5 = S, 6=b, 3=E, 9=G, 0=O
	$lettre = array();
	$lettre[0] = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i',
			'j', 'k', 'l', 'm', 'o', 'n', 'p', 'q', 'r',
			's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
	$lettre[1] = array('a', 'e', 'i', 'o', 'u', 'y', 'A', 'E',
			'I', 'O', 'U', 'Y' , '1', '3', '0' );
	$lettre[-1] = array('b', 'c', 'd', 'f', 'g', 'h', 'j', 'k',
			'l', 'm', 'n', 'p', 'q', 'r', 's', 't',
			'v', 'w', 'x', 'z');
	/*
	 * mod radeff: suppressed i, I, 1, o, O and 0
	*
	*/   $lettre[0] = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h',
			'j', 'k', 'm', 'n', 'p', 'q', 'r',
			's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
	$lettre[1] = array('a', 'e', 'o', 'u', 'y');
	$lettre[-1] = array('b', 'c', 'd', 'f', 'g', 'h', 'j', 'k',
			'm', 'n', 'p', 'q', 'r', 's', 't',
			'v', 'w', 'x', 'z');

	$retour = "";
	$prec = 1;
	$precprec = -1;
	srand((double)microtime()*20001107);
	while(strlen($retour) < $nb){
		// pour genere la suite de lettre, on dit : si les deux lettres sonts
		// des consonnes (resp. des voyelles) on affiche des voyelles (resp, des consonnes).
		// si les lettres sont de type differents, on affiche une lettre de l'alphabet
		$type = ($precprec + $prec)/2;
		$r = $lettre[$type][array_rand($lettre[$type], 1)];
		$retour .= $r;
		$precprec = $prec;
		$prec = in_array($r, $lettre[-1]) - in_array($r, $lettre[1]);

	}
	//  if(!preg_match("/i/i",$retour)&&!preg_match("/0/",$retour)&&!preg_match("/o/",$retour)){
	return $retour;
	//  }else{
	//  	passe_mnemo(func_get_arg(0));
	//  }
}

/*
 * 
 * default: display form
 * */

$u = new User();
//display only of user is not registred
if (!$u->isRegistered()){
	$db = Loader::db();
	$passwordreminders = $db->GetAll("SELECT formDescription FROM zpartakovloginconf");
	$message=$passwordreminders[0]['formDescription'];
?>
<div onmouseover="document.getElementById('informations').style.display = 'block'" onmouseout="document.getElementById('informations').style.display = 'none';">
<h2><?php echo t("Reset my password");?></h2>
<p><?php echo t("Email");?></p>
<form method="POST">
<input type="text" name="email">
<input type="submit">
</form>
<div style="display: none; margin-top: 1em; background-color: lightyellow; padding: 15px" id="informations"><?php echo $message; ?></div>
</div>
<?php
}
/*
 * the form has been submitted
 * */
if($_POST['email']) {
defined('C5_EXECUTE') or die(_("Access Denied."));
Loader::library('3rdparty/phpass/PasswordHash');
$db = Loader::db();
$password=passe_mnemo(8);
$hasher = new PasswordHash(PASSWORD_HASH_COST_LOG2, PASSWORD_HASH_PORTABLE);
$hash = $hasher->HashPassword($password);
/*
 * searching for a user with such email
 * */
$sql="SELECT * FROM Users WHERE uEmail LIKE '".$_POST['email']."'";
$sql=mysql_query($sql);
if(mysql_num_rows($sql)!=1) { //there is no matching mail, feedback and exit
	echo $sorryNoMatchingMail;
	exit;
}
$login=mysql_result($sql,0,'uName');

/*
 * change with assigned password
 * */
 
$sql="UPDATE Users SET uPassword='".$hash ."' WHERE uEmail LIKE '".$_POST['email']."'";
$sql=mysql_query($sql);


  $sql="SELECT * FROM zpartakovloginconf LIMIT 0,1";
  $sql=$db->getRow($sql);

$webSiteName=$sql['webSiteName'];
$mailSender=$sql['mailSender'];
$pageTitle=$sql['pageTitle'];
$formDescription=$sql['formDescription'];;
$sorryNoMatchingMail=$sql['sorryNoMatchingMail'];;
$connexionUrl=$sql['connexionUrl'];
$Sujet = $sql['Sujet'];
$bodyMailBegin=$sql['bodyMailBegin'];
$bodyMailEnd=$sql['bodyMailEnd'];
$sendingMailFailed=$sql['sendingMailFailed'];
$pleaseCheckYourMail=$sql['pleaseCheckYourMail'];

$bodyMail= $bodyMailBegin;

$bodyMail .="
<br />" .t(login) .": " .$login;

$bodyMail .="
password: " .$password;

$bodyMail =$bodyMail."<br /><br />".$bodyMailEnd;

/*
 * sending the mail to the user
 * */

$body=nl2br($bodyMail);

/*
echo "<hr>";
echo "<br>".$Sujet ."<br>";
echo $body;
echo "<hr>";
*/
//exit;
//echo $_POST['email']; exit;
$From  = "From: " .$mailSender ."\n";
$From .= "MIME-version: 1.0\n";
$From .= "Content-type: text/html; charset= UTF-8\n";
 
//$body="test";
 
$envoie=mail($_POST['email'],$Sujet,$body,$From);
//$envoie=mail('fradeff@akademia.ch',$Sujet,$body,$From);

	if(!$envoie) { //problem sending mail
		echo $sendingMailFailed; //feedback
		$body="bug sending mail to : " .$_POST['email'];
		$envoie=mail($From,"bug sending mail",$body,$_POST['email']);
		
	}
	echo $pleaseCheckYourMail;
}
?>