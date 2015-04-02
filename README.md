Concrete5SendbackPassword, a package for Concrete5
===================================================================

French:

Concrete5SendbackPassword, un alternative lorsque le système de renvoi par mail des mots de passe
pour concrete5 ne fonctionne pas, qui force la création de mots de passe aléatoires.

Pourquoi ce paquet?

Chez certains hébergeurs, pour une obscure raison, lorsqu'un utilisateur concrete5 demande
au système de lui renvoyer son mot de passe (mot de passe oublié), le mail avec les nouvelles
informations de connexion n'arrive pas, même si vous avez réglé correctement les settings SMTP
(fonction mail() php ou SMTP).

Ce paquet est une alternative fonctionnelle selon notre expérience.

Attention: ne pas installer ce package si vous avez déjà le package http://www.concrete5.org/marketplace/addons/login_block/ (désinstaller auparavant)

Package original http://www.concrete5.org/marketplace/addons/login_block/
Changements par zpartakov / zpartakov@akademia.ch

# Instructions pour l'installation

1. Décompresser ce fichier sous votre répertoire packages/.
2. Enregistrez-vous sur votre site comme administrateur.
3. Chercher dans votre interface d'administration "Installer"
4. Chercher le packet "Zpartakov Login".
5. Cliquer sur le bouton "installer".

Important: une fois le paquet installé, modifier dans le dashboard "Passwordreminders"

===================================================================

English:

Concrete5SendbackPassword, an alternative when core send password reminder within concrete5 is bugging, forcing random passwords.

Why this package?

By some ISPs, for a strange reason, the mail when a concrete 5 resets his password 
(forgotten password) never arrives, even if you test with success your SMTP email function 
(either plain php() or SMTP).

This package is an alternative which works well according to our experience.

Caution: conflict with http://www.concrete5.org/marketplace/addons/login_block/ (uninstall first)

Original from http://www.concrete5.org/marketplace/addons/login_block/
Changes from zpartakov / zpartakov@akademia.ch

# Installation Instructions

1. Unzip this file in your site's packages/ directory.
2. Login to your site as an administrator.
3. Find the "Add Functionality" page in your dashboard.
4. Find this package in the list of packages awaiting installation.
5. Click the "install" button.

Changes from zpartakov / zpartakov@akademia.ch

Important: once the package installed, modify configs in the dashboard "Passwordreminders"

===================================================================

Concrete5SendbackPassword is distributed in the hope that it will be useful, 
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.

/**
*
* @package Concrete5SendbackPassword 1.0
* @author Zpartakov <zpartakov@akademia.ch>
* @copyright (c) 2015 Zpartakov, radeff.net
* @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
* @required:
* concrete5 Version 5.6.3.3
*
*/