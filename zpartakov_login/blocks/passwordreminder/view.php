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
?>
<h2><?php echo $pageTitle;?></h2>
<p><?php echo $formDescription;?></p>
<p><?php echo t("Email");?></p>
<form method="POST">
<input type="text" name="email">
<input type="submit">
</form>
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

/*
 * français (valeurs par défaut)
* changer les valeurs selon vos besoins
###############################################################################
*/

$webSiteName="YoupLaBoum, johndoe.org";
$mailSender="John Doe <John.Doe@johndoe.org>"; //l'émetteur du mail
$pageTitle="Mot de passe oublié?";
$formDescription="Saisissez votre adresse e-mail ci-dessous. Nous vous enverrons les instructions pour vous connecter sur ce site et un nouveau mot de passe.";
$sorryNoMatchingMail="<p>Désolé, ce mail n'est pas enregistré dans notre base de données. Merci de <a href=\"mailto:xxx@xxx.xx\">prendre contact avec un administrateur du site</a></p>";
$connexionUrl="";//url pour la connexion des utilisateurs
$Sujet = "Vos informations de connexion pour le site internet " .$webSiteName;

$bodyMail="Bonjour,

Voici vos informations de connexion au site internet " .$webSiteName .":

identifiant: " .$login ."
mot de passe: " .$password ."

Pour vous connecter: <a href=\"".$connexionUrl."\">".$connexionUrl."</a>

En cas de problème de connexion, prenez contact avec <a href=\"mailto:".$mailSender."\">".$mailSender."</a>

Meilleures salutations,
".$webSiteName ."
=======================
Ceci est un message automatique envoyé par un robot depuis www.xxx
";

$sendingMailFailed="L'envoi du mail a échoué";
$pleaseCheckYourMail="<div style=\"margin-top: 1em; padding: 1em; background-color: #FFFFC6\"><p>Veuillez consulter votre email " .$_POST['email'] .", vous aurez reçu vos informations de connexion.</p><p>Si vous ne le voyez pas, vérifiez que le mail ne soit pas passé dans les pourriels (spam)</p></div>";

/*
 * Fin des modifications
###############################################################################
*/
/*
 * english (activate by uncommenting following lines)
change Values for your needs
*/

/*
 *
$webSiteName="YoupLaBoum, johndoe.org";"
$pageTitle="Forgotten password?";
$formDescription="Fill this form with your email. This website will send you back a new secure random password.";
$sorryNoMatchingMail="Sorry, this email is not in our database. Please <a href=\"mailto:xxx@xxx.xx\">contact an administrator of this website</a>.</p>";
$Sujet = "Your connection infos for the website "" .$webSiteName;
$bodyMail="Hello,

Here are you informations for connecting to the internet website xxx:

login: " .$login ."
password: " .$password ."

Connection: <a href=\"".$connexionUrl."\">".$connexionUrl."</a>

In case of a connecion problem, please <a href=\"mailto:xxx@xxx.xx\">contact an administrator of this website</a>

Best regards,

=======================
This is an automatic mail send by a robot from
";
$sendingMailFailed="Email sending failed";
$pleaseCheckYourMail="<div style=\"margin-top: 1em; padding: 1em; background-color: #FFFFC6\"><p>xxxPlease read your email" .$_POST['email'] .", you have received your connection informations.</p><p>If you can't find it, please check that the email is not marked as spam.</p></div>";

*/


/*
 * end change values
	###############################################################################
*/


/*
 * sending the mail to the user
 * */

$body=nl2br($bodyMail);
$From  = "From: " .$mailSender ."\n";
$From .= "MIME-version: 1.0\n";
$From .= "Content-type: text/html; charset= UTF-8\n";
 
$envoie=mail($_POST['email'],$Sujet,$body,$From);

	if(!$envoie) { //problem sending mail
		echo $sendingMailFailed; //feedback
	}
	echo $pleaseCheckYourMail;
}
?>