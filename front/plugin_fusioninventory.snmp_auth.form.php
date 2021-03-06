<?php

/*
   ----------------------------------------------------------------------
   GLPI - Gestionnaire Libre de Parc Informatique
   Copyright (C) 2003-2008 by the INDEPNET Development Team.

   http://indepnet.net/   http://glpi-project.org/
   ----------------------------------------------------------------------

   LICENSE

   This file is part of GLPI.

   GLPI is free software; you can redistribute it and/or modify
   it under the terms of the GNU General Public License as published by
   the Free Software Foundation; either version 2 of the License, or
   (at your option) any later version.

   GLPI is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.

   You should have received a copy of the GNU General Public License
   along with GLPI; if not, write to the Free Software
   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
   ------------------------------------------------------------------------
 */

// Original Author of file: David DURIEUX
// Purpose of file:
// ----------------------------------------------------------------------

$NEEDED_ITEMS = array (
	"setup",
	"rulesengine",
	"fusioninventory",
	"search"
);

define('GLPI_ROOT', '../../..');

include (GLPI_ROOT . "/inc/includes.php");

plugin_fusioninventory_checkRight("snmp_authentification","r");

$plugin_fusioninventory_snmp_auth = new PluginFusionInventorySNMPAuth;
$config = new PluginFusionInventoryConfig;

commonHeader($LANG['plugin_fusioninventory']["title"][0],$_SERVER["PHP_SELF"],"plugins","fusioninventory","snmp_auth");

plugin_fusioninventory_mini_menu();


if (isset ($_POST["add"])) {
	plugin_fusioninventory_checkRight("snmp_authentification","w");
	if ($config->getValue("authsnmp") == "file") {
		$new_ID = $plugin_fusioninventory_snmp_auth->add_xml();
   } else if ($config->getValue("authsnmp") == "DB") {
		$new_ID = $plugin_fusioninventory_snmp_auth->add($_POST);
   }
	
	$_SESSION["MESSAGE_AFTER_REDIRECT"] = "Import effectué avec succès : <a href='plugin_fusioninventory.snmp_auth.php?ID=".$new_ID."'>".$_POST["name"]."</a>";
	glpi_header($_SERVER['HTTP_REFERER']);
} else if (isset ($_POST["update"])) {
	plugin_fusioninventory_checkRight("snmp_authentification","w");
	$plugin_fusioninventory_snmp_auth->update($_POST);
	glpi_header($_SERVER['HTTP_REFERER']);
}

$ID = "";
if (isset($_GET["ID"])) {
	$ID = $_GET["ID"];
}
if(plugin_fusioninventory_HaveRight("snmp_authentification","r")) {
   $plugin_fusioninventory_snmp_auth->showForm($_SERVER["PHP_SELF"], $ID);
}
commonFooter();

?>