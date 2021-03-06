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

if (!defined('GLPI_ROOT')) {
	define('GLPI_ROOT', '../../..');
}

function plugin_fusioninventory_getUniqueObjectfieldsByportID($id) {
	global $DB;
	
	$array = array();
	$query = "SELECT *
             FROM `glpi_networking_ports`
             WHERE `ID`='".$id."';";
	if ($result=$DB->query($query)) {
		$data = $DB->fetch_array($result);
		$array["on_device"] = $data["on_device"];
		$array["device_type"] = $data["device_type"];	
	}
	switch($array["device_type"]) {
		case NETWORKING_TYPE:
			$query = "SELECT *
                   FROM `glpi_networking`
                   WHERE `ID`='".$array["device_type"]."'
                   LIMIT 0,1;";
			if ($result=$DB->query($query)) {
				$data = $DB->fetch_array($result);
				$array["name"] = $data["name"];
			}
			break;
	}
	return($array);
}

?>