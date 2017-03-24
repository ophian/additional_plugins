<?php

@define('PLUGIN_ADDUSER_NAME', 'Auto-enregistrement des utilisateurs');
@define('PLUGIN_ADDUSER_DESC', 'Permettre aux visiteurs du blog de cr�er leur propre compte utilisateur. En conjonction avec le plugin d\'�v�nement (index.php?serendipity[subpage]=adduser), vous pouvez d�cider de n\'autoriser que les utilisateurs enregistr�s � poster des commentaires.');
@define('PLUGIN_ADDUSER_INSTRUCTIONS', 'Instructions compl�mentaires');
@define('PLUGIN_ADDUSER_INSTRUCTIONS_DESC', 'Ajoutez ici quelques instructions qui appara�tront dans le formulaire d\'enregistrement');
@define('PLUGIN_ADDUSER_INSTRUCTIONS_DEFAULT', 'Ici, vous pouvez vous enregistrer comme auteur de ce blog. Entrez simplement les informations demand�es, validez le formulaire et vous recevrez des instructions compl�mentaires par email.');
@define('PLUGIN_ADDUSER_USERLEVEL', 'Niveau d\'acc�s par d�faut');
@define('PLUGIN_ADDUSER_USERLEVEL_DESC', 'Choisissez le Niveau d\'acc�s par d�faut des nouveaux utilisateurs.');
@define('PLUGIN_ADDUSER_USERLEVEL_CHIEF', 'Chef');
@define('PLUGIN_ADDUSER_USERLEVEL_EDITOR', '�diteur');
@define('PLUGIN_ADDUSER_USERLEVEL_ADMIN', 'Administrateur');
@define('PLUGIN_ADDUSER_USERLEVEL_DENY', 'Acc�s refus�');
@define('PLUGIN_SIDEBAR_LOGIN', 'Affiche le formulaire d\'enregistrement dans la barre lat�rale ?');
@define('PLUGIN_SIDEBAR_LOGIN_DESC', 'Si la valeur "oui" est s�lectionn�e, un formulaire d\'enregistrement sera affich� dans la barre lat�rale. Sinon, vos utilisateurs devront s\'enregistrer dans une page sp�ciale d�finie dans le plugin d\'�v�nement correspondant.');

@define('PLUGIN_ADDUSER_EXISTS', 'D�sol�, le nom d\'utilisateur "%s" est d�j� utilis�. Merci d\'en choisir un autre.');
@define('PLUGIN_ADDUSER_MISSING', 'Vous devez saisir tous les champs pour cr�er un compte utilisateur.');
@define('PLUGIN_ADDUSER_SENTMAIL', 'Votre compte a �t� cr��. Vous recevrez prochainement par email toutes les informations compl�mentaires n�cessaires � son utilisation.');
@define('PLUGIN_ADDUSER_WRONG_ACTIVATION', 'L\'URL d\'activation que vous avez utilis�e n\est pas valide !');

@define('PLUGIN_ADDUSER_MAIL_SUBJECT', 'Un nouveau compte utilisateur a �t� cr��.');
@define('PLUGIN_ADDUSER_MAIL_BODY', "Un compte a �t� cr�� pour l'\utilisateur %s sur le Blog %s. Pour activer ce compte, merci de cliquer sur le lien ci-dessous:\n\n%s\n\nUne fois ceci fait, vous pourrez vous connecter en utilisant le mot de passe choisi. Cet email a �t� envoy� au nouvel utilisateur et au propri�taire du blog.");
@define('PLUGIN_ADDUSER_SUCCEED', 'Le compte utilisateur a �t� cr�� avec succ�s. Vous pouvez vous connecter au panneau d\administration de ce blog en cliquant sur le lien fourni dans l\'email d\'activation.');
@define('PLUGIN_ADDUSER_FAILED', 'Le compte utilisateur n\'a pas pu �tre cr��. Peut-�tre n\'avez-vous pas recopi� la bonne URL dans l\'email d\'activation ?');

@define('PLUGIN_ADDUSER_REGISTERED_ONLY', 'Seuls les utilisateurs enregistr�s peuvent poster des commentaires ?');
@define('PLUGIN_ADDUSER_REGISTERED_ONLY_DESC', 'Si la valeur "oui" est s�lectionn�e, seuls les utilisateurs enregistr�s et connect�s pourront poster des commentaires aux billets de ce blog.');
@define('PLUGIN_ADDUSER_REGISTERED_ONLY_REASON', 'Seuls les utilisateurs enregistr�s peuvent poster des commentaires sur ce blog. Cr�ez votre compte <a href="%s">ici</a>, puis <a href="%s">connectez-vous</a>. Votre navigateur doit accepter les cookies.');

@define('PLUGIN_ADDUSER_STRAIGHT', 'Insertion imm�diate ?');
@define('PLUGIN_ADDUSER_STRAIGHT_DESC', 'Si la valeur "oui" est s�lectionn�e, un utilisateur sera imm�diatement enregistr� comme valide. Il est recommand� de n\'utiliser cette option que si aucun serveur d\'email n\'est disponible. Des spammeurs peuvent se servir de cette option. Ne l\'utilisez que si vous savez ce que vous faites !');

@define('PLUGIN_ADDUSER_REGISTERED_CHECK', 'Pr�vention des usurpations d\'identit�');
@define('PLUGIN_ADDUSER_REGISTERED_CHECK_DESC', 'Si la valeur "oui" est s�lectionn�e, les noms d\'utilisateurs enregistr�s ne pourront �tre utilis�s que par ceux qui sont connect�s en tant qu\'utilisateur.');
@define('PLUGIN_ADDUSER_REGISTERED_CHECK_REASON', 'Le nom d\'utilisateur que vous essayez d\'utiliser est r�serv� � un utilisateur enregistr�. Merci de vous <a href="%s" %s>connecter</a> pour poster un commentaire en utilisant ce nom. Si vous n\'�tes pas un utilisateur enregistr�, merci d\'utiliser un nom diff�rent.');

