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

define('GLPI_ROOT', '../../..'); 

include (GLPI_ROOT."/inc/includes.php");

if ( isset($_GET['type']) ) {
	if ( $_GET['type'] == COMPUTER_TYPE )
		checkRight("computer","r");
	else // $_GET['type'] == COMPUTER_TYPE
		checkRight("user","r");
}
else
	plugin_tracker_noRight();

plugin_tracker_checkRight("computers_history","r");

$computer_history = new plugin_tracker_computers_history();

if ( (isset($_POST['delete'])) ) {
	
	plugin_tracker_checkRight("computers_history","w");
	
	if ( isset($_POST['limit']) ) {
		for ($i=0; $i<$_POST['limit']; $i++) {
			if ( ( isset($_POST["checked_$i"]) ) && ( $_POST["checked_$i"] == 1 ) ) {
				if ( isset($_POST["ID_$i"]) )
				$input['ID'] = $_POST["ID_$i"];

				$computer_history->delete($input);
			}
		}
	}
	
}

glpi_header($_SERVER['HTTP_REFERER']);

?>