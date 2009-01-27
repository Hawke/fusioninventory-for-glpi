<?php
/*
 * @version $Id$
 ----------------------------------------------------------------------
 GLPI - Gestionnaire Libre de Parc Informatique
 Copynetwork (C) 2003-2006 by the INDEPNET Development Team.

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

// ----------------------------------------------------------------------
// Original Author of file: Nicolas SMOLYNIEC
// Purpose of file:
// ----------------------------------------------------------------------

$NEEDED_ITEMS=array("setup");
if(!defined('GLPI_ROOT')){
	define('GLPI_ROOT', '../../..'); 
}
include (GLPI_ROOT . "/inc/includes.php");

checkRight("profile","w");

useplugin('tracker');

$plugin = new Plugin();
if ($plugin->isInstalled("tracker") && $plugin->isActivated("tracker")) {
	
	commonHeader($LANG['plugin_tracker']["title"][0],$_SERVER["PHP_SELF"],"plugins","tracker");
	plugin_tracker_phpextensions();	
	echo "<div align='center'>";
	echo "<table class='tab_cadre' cellpadding='5'>";
	echo "<tr><th>".$LANG['plugin_tracker']["setup"][3];
	echo "</th></tr>";

	/* Fonctionalities */
	echo "<tr class='tab_bg_1'><td align='center'>";
	echo "<a href=\"./plugin_tracker.functionalities.form.php\">".$LANG['plugin_tracker']["functionalities"][0]."</a>";
	echo "</td></tr>";
	
	/* Instructions / FAQ */
	echo "<tr class='tab_bg_1'><td align='center'>";
	echo "<a href='http://glpi-project.org/wiki/doku.php?id=".substr($_SESSION["glpilanguage"],0,2).":plugins:tracker_use' target='_blank'>".$LANG['plugin_tracker']["setup"][11]."&nbsp;</a>";
	echo "/&nbsp;<a href='http://glpi-project.org/wiki/doku.php?id=".substr($_SESSION["glpilanguage"],0,2).":plugins:tracker_faq' target='_blank'>".$LANG['plugin_tracker']["setup"][12]." </a>";
	echo "</td></tr>";

	/* Models */
	echo "<tr class='tab_bg_1'><td align='center'>";
	echo "<a href='http://glpi-project.org/wiki/doku.php?id=wiki:".substr($_SESSION["glpilanguage"],0,2).":plugins:tracker:models' target='_blank'>".$LANG['plugin_tracker']["profile"][19]."&nbsp;</a>";
	echo "</td></tr>";
	
	echo "</table>";
		
	echo "</div>";	
		
}else{
	commonHeader($LANG["common"][12],$_SERVER['PHP_SELF'],"config","plugins");
	echo "<div align='center'><br><br><img src=\"".$CFG_GLPI["root_doc"]."/pics/warning.png\" alt=\"warning\"><br><br>";
	echo "<b>Please activate the plugin</b></div>";
}

commonFooter();


?>