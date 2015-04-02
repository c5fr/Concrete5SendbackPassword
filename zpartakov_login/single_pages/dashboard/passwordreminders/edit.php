<!-- 
#nologin,
#send_me_a_newpassword,
#webSiteName,
#mailSender,
#pageTitle,
#formDescription,
#sorryNoMatchingMail,
#Sujet,
#bodyMailBegin,
#bodyMailEnd,
#sendingMailFailed,
#pleaseCheckYourMail
-->
<style>
input[type="text"],
#nologin,
#send_me_a_newpassword,
#pageTitle,
#formDescription,
#sorryNoMatchingMail,
#bodyMailBegin,
#bodyMailEnd,
#pleaseCheckYourMail,
td
 {
width: 600px;
vertical-align: middle;
padding: 15px;
}
#nologin,
#send_me_a_newpassword,
#formDescription,
#sorryNoMatchingMail,
#bodyMailBegin,
#bodyMailEnd,
#pleaseCheckYourMail {
 height: 200px;
 }
.libelle {
width: 230px;
}
td.libelle {
font-weight: bold italic;
}
</style>

<?php $form = Loader::helper('form') ?>
<div class="ccm-ui">
<?php
$dashboard = Loader::helper('concrete/dashboard');
echo $dashboard->getDashboardPaneHeader(t('Modify the options for the email sent by PasswordReminder'));

$db = Loader::db();

$passwordreminders = $db->GetAll("SELECT * FROM zpartakovloginconf");


?>
<form action="<?php echo $this->action('save') ?>" method="POST">
<table style="margin-top:2em">
<tr>
	<td class="libelle">
		nologin
	</td>
	<td>
			<?php 
		echo $form->textarea('nologin', $passwordreminders[0]['nologin']); ?>
	</td>
</tr>

<tr>
	<td class="libelle">
		send_me_a_newpassword
	</td>
	<td>
			<?php 
		echo $form->textarea('send_me_a_newpassword', $passwordreminders[0]['send_me_a_newpassword']); ?>
	</td>
</tr>

<tr>
	<td class="libelle">
		webSiteName
	</td>
	<td>
		<?php echo $form->text('webSiteName', $passwordreminders[0]['webSiteName']); ?>
	</td>
</tr>

<tr>
	<td class="libelle">
		mailSender
	</td>
	<td>
		<?php echo $form->text('mailSender', $passwordreminders[0]['mailSender']); ?>
	</td>
</tr>
<tr>
	<td class="libelle">
		pageTitle
	</td>
	<td>
		<?php echo $form->text('pageTitle', $passwordreminders[0]['pageTitle']); ?>
	</td>
</tr>

<tr>
	<td class="libelle">
		formDescription
	</td>
	<td>
		<?php echo $form->textarea('formDescription', $passwordreminders[0]['formDescription']); 
		//, 'class'=>'advancedEditor ccm-advanced-editor'
		?>
	</td>
</tr>
<tr>
	<td class="libelle">
		sorryNoMatchingMail
	</td>
	<td>
		<?php echo $form->textarea('sorryNoMatchingMail', $passwordreminders[0]['sorryNoMatchingMail']); 
		//, 'class'=>'advancedEditor ccm-advanced-editor'
		?>
	</td>
</tr>
<?php 
/*

`Sujet` varchar(255) DEFAULT NULL,
`bodyMailBegin` text,
`bodyMailEnd` text,
`sendingMailFailed` varchar(255) DEFAULT NULL,
`pleaseCheckYourMail` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `zpartakovloginconf` (
`bID` int(10) unsigned NOT NULL,
`nologin` text,
`send_me_a_newpassword` text,
`webSiteName` varchar(255) DEFAULT NULL,
`mailSender` varchar(255) DEFAULT NULL,
`pageTitle` varchar(255) DEFAULT NULL,
`formDescription` text,
`sorryNoMatchingMail` text,
`Sujet` varchar(255) DEFAULT NULL,
`bodyMailBegin` text,
`bodyMailEnd` text,
`sendingMailFailed` varchar(255) DEFAULT NULL,
`pleaseCheckYourMail` text
)
*/
?>
<tr>
	<td class="libelle">
		Sujet
	</td>
	<td>
		<?php echo $form->text('Sujet', $passwordreminders[0]['Sujet']); ?>
	</td>
</tr>
<tr>
	<td class="libelle">
		bodyMailBegin
	</td>
	<td>
	<?php echo $form->textarea('bodyMailBegin', $passwordreminders[0]['bodyMailBegin']); ?>	
	</td>
</tr>

<tr>
	<td class="libelle">
		bodyMailEnd
	</td>
	<td>
	<?php echo $form->textarea('bodyMailEnd', $passwordreminders[0]['bodyMailEnd']); ?>	
	</td>
</tr>
<tr>
	<td class="libelle">
		sendingMailFailed
	</td>
	<td class="libelle">
			<?php echo $form->text('sendingMailFailed', $passwordreminders[0]['sendingMailFailed']); ?>
	</td>
</tr>


<tr>
	<td class="libelle">
		pleaseCheckYourMail
	</td>
	<td>
	<?php echo $form->textarea('pleaseCheckYourMail', $passwordreminders[0]['pleaseCheckYourMail']); ?>	
	</td>
</tr>

</table>

<?php 
/*
 * display hidden if if we are in edit mode, either don't display it
 * */
echo $form->hidden('bID', $passwordreminders[0]['bID']);

?>

<input class="btn btn-primary" type="submit" value="Save">
<a href="<?php echo $this->url('/dashboard/posts') ?>" class="btn">Cancel</a>