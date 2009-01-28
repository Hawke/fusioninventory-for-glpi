<?php

/*
 * @version $Id: connection.function.php 6975 2008-06-13 15:43:18Z remi $
 -------------------------------------------------------------------------
 GLPI - Gestionnaire Libre de Parc Informatique
 Copyright (C) 2003-2008 by the INDEPNET Development Team.

 http://indepnet.net/   http://glpi-project.org
 -------------------------------------------------------------------------

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
 --------------------------------------------------------------------------
 */

// ----------------------------------------------------------------------
// Original Author of file: DURIEUX David
// Purpose of file:
// ----------------------------------------------------------------------

function plugin_tracker_getSearchOption() {
	global $LANG;
	$sopt = array ();

	// Part header
	$sopt[PLUGIN_TRACKER_ERROR_TYPE]['common'] = $LANG['plugin_tracker']["errors"][0];

	$sopt[PLUGIN_TRACKER_ERROR_TYPE][1]['table'] = 'glpi_plugin_tracker_errors';
	$sopt[PLUGIN_TRACKER_ERROR_TYPE][1]['field'] = 'ifaddr';
	$sopt[PLUGIN_TRACKER_ERROR_TYPE][1]['linkfield'] = 'ifaddr';
	$sopt[PLUGIN_TRACKER_ERROR_TYPE][1]['name'] = $LANG['plugin_tracker']["errors"][1];

	$sopt[PLUGIN_TRACKER_ERROR_TYPE][2]['table'] = 'glpi_plugin_tracker_errors';
	$sopt[PLUGIN_TRACKER_ERROR_TYPE][2]['field'] = 'ID';
	$sopt[PLUGIN_TRACKER_ERROR_TYPE][2]['linkfield'] = 'ID';
	$sopt[PLUGIN_TRACKER_ERROR_TYPE][2]['name'] = $LANG["common"][2];

	$sopt[PLUGIN_TRACKER_ERROR_TYPE][3]['table'] = 'glpi_plugin_tracker_errors';
	$sopt[PLUGIN_TRACKER_ERROR_TYPE][3]['field'] = 'device_type';
	$sopt[PLUGIN_TRACKER_ERROR_TYPE][3]['linkfield'] = 'device_type';
	$sopt[PLUGIN_TRACKER_ERROR_TYPE][3]['name'] = $LANG["common"][1];

	$sopt[PLUGIN_TRACKER_ERROR_TYPE][4]['table'] = 'glpi_plugin_tracker_errors';
	$sopt[PLUGIN_TRACKER_ERROR_TYPE][4]['field'] = 'device_id';
	$sopt[PLUGIN_TRACKER_ERROR_TYPE][4]['linkfield'] = 'device_id';
	$sopt[PLUGIN_TRACKER_ERROR_TYPE][4]['name'] = $LANG["common"][16];

	$sopt[PLUGIN_TRACKER_ERROR_TYPE][6]['table'] = 'glpi_plugin_tracker_errors';
	$sopt[PLUGIN_TRACKER_ERROR_TYPE][6]['field'] = 'description';
	$sopt[PLUGIN_TRACKER_ERROR_TYPE][6]['linkfield'] = 'description';
	$sopt[PLUGIN_TRACKER_ERROR_TYPE][6]['name'] = $LANG['plugin_tracker']["errors"][2];

	$sopt[PLUGIN_TRACKER_ERROR_TYPE][7]['table'] = 'glpi_plugin_tracker_errors';
	$sopt[PLUGIN_TRACKER_ERROR_TYPE][7]['field'] = 'first_pb_date';
	$sopt[PLUGIN_TRACKER_ERROR_TYPE][7]['linkfield'] = 'first_pb_date';
	$sopt[PLUGIN_TRACKER_ERROR_TYPE][7]['name'] = $LANG['plugin_tracker']["errors"][3];

	$sopt[PLUGIN_TRACKER_ERROR_TYPE][8]['table'] = 'glpi_plugin_tracker_errors';
	$sopt[PLUGIN_TRACKER_ERROR_TYPE][8]['field'] = 'last_pb_date';
	$sopt[PLUGIN_TRACKER_ERROR_TYPE][8]['linkfield'] = 'last_pb_date';
	$sopt[PLUGIN_TRACKER_ERROR_TYPE][8]['name'] = $LANG['plugin_tracker']["errors"][4];

	$sopt[PLUGIN_TRACKER_ERROR_TYPE][80]['table'] = 'glpi_entities';
	$sopt[PLUGIN_TRACKER_ERROR_TYPE][80]['field'] = 'completename';
	$sopt[PLUGIN_TRACKER_ERROR_TYPE][80]['linkfield'] = 'FK_entities';
	$sopt[PLUGIN_TRACKER_ERROR_TYPE][80]['name'] = $LANG["entity"][0];

	$sopt[PLUGIN_TRACKER_MODEL]['common'] = $LANG['plugin_tracker']["errors"][0];

	$sopt[PLUGIN_TRACKER_MODEL][1]['table'] = 'glpi_plugin_tracker_model_infos';
	$sopt[PLUGIN_TRACKER_MODEL][1]['field'] = 'ID';
	$sopt[PLUGIN_TRACKER_MODEL][1]['linkfield'] = 'ID';
	$sopt[PLUGIN_TRACKER_MODEL][1]['name'] = $LANG["common"][2];

	$sopt[PLUGIN_TRACKER_MODEL][2]['table'] = 'glpi_plugin_tracker_model_infos';
	$sopt[PLUGIN_TRACKER_MODEL][2]['field'] = 'name';
	$sopt[PLUGIN_TRACKER_MODEL][2]['linkfield'] = 'name';
	$sopt[PLUGIN_TRACKER_MODEL][2]['name'] = $LANG["common"][16];

	$sopt[PLUGIN_TRACKER_MODEL][3]['table'] = 'glpi_plugin_tracker_model_infos';
	$sopt[PLUGIN_TRACKER_MODEL][3]['field'] = 'device_type';
	$sopt[PLUGIN_TRACKER_MODEL][3]['linkfield'] = 'device_type';
	$sopt[PLUGIN_TRACKER_MODEL][3]['name'] = $LANG["common"][17];

	$sopt[PLUGIN_TRACKER_MODEL][5]['table'] = 'glpi_plugin_tracker_model_infos';
	$sopt[PLUGIN_TRACKER_MODEL][5]['field'] = 'ID';
	$sopt[PLUGIN_TRACKER_MODEL][5]['linkfield'] = 'EXPORT';
	$sopt[PLUGIN_TRACKER_MODEL][5]['name'] = $LANG["buttons"][31];

	$sopt[PLUGIN_TRACKER_SNMP_AUTH]['common'] = $LANG['plugin_tracker']["errors"][0];

	$sopt[PLUGIN_TRACKER_SNMP_AUTH][1]['table'] = 'glpi_plugin_tracker_snmp_connection';
	$sopt[PLUGIN_TRACKER_SNMP_AUTH][1]['field'] = 'ID';
	$sopt[PLUGIN_TRACKER_SNMP_AUTH][1]['linkfield'] = 'ID';
	$sopt[PLUGIN_TRACKER_SNMP_AUTH][1]['name'] = $LANG["common"][2];

	$sopt[PLUGIN_TRACKER_SNMP_AUTH][2]['table'] = 'glpi_plugin_tracker_snmp_connection';
	$sopt[PLUGIN_TRACKER_SNMP_AUTH][2]['field'] = 'name';
	$sopt[PLUGIN_TRACKER_SNMP_AUTH][2]['linkfield'] = 'name';
	$sopt[PLUGIN_TRACKER_SNMP_AUTH][2]['name'] = $LANG["common"][16];

	$sopt[PLUGIN_TRACKER_SNMP_AUTH][3]['table'] = 'glpi_dropdown_plugin_tracker_snmp_version';
	$sopt[PLUGIN_TRACKER_SNMP_AUTH][3]['field'] = 'name';
	$sopt[PLUGIN_TRACKER_SNMP_AUTH][3]['linkfield'] = 'FK_snmp_version';
	$sopt[PLUGIN_TRACKER_SNMP_AUTH][3]['name'] = $LANG['plugin_tracker']["model_info"][2];

	$sopt[PLUGIN_TRACKER_SNMP_AUTH][4]['table'] = 'glpi_plugin_tracker_snmp_connection';
	$sopt[PLUGIN_TRACKER_SNMP_AUTH][4]['field'] = 'community';
	$sopt[PLUGIN_TRACKER_SNMP_AUTH][4]['linkfield'] = 'community';
	$sopt[PLUGIN_TRACKER_SNMP_AUTH][4]['name'] = $LANG['plugin_tracker']["snmpauth"][1];

	$sopt[PLUGIN_TRACKER_SNMP_AUTH][5]['table'] = 'glpi_plugin_tracker_snmp_connection';
	$sopt[PLUGIN_TRACKER_SNMP_AUTH][5]['field'] = 'sec_name';
	$sopt[PLUGIN_TRACKER_SNMP_AUTH][5]['linkfield'] = 'sec_name';
	$sopt[PLUGIN_TRACKER_SNMP_AUTH][5]['name'] = $LANG['plugin_tracker']["snmpauth"][2];

	$sopt[PLUGIN_TRACKER_SNMP_AUTH][6]['table'] = 'glpi_dropdown_plugin_tracker_snmp_auth_sec_level';
	$sopt[PLUGIN_TRACKER_SNMP_AUTH][6]['field'] = 'name';
	$sopt[PLUGIN_TRACKER_SNMP_AUTH][6]['linkfield'] = 'sec_level';
	$sopt[PLUGIN_TRACKER_SNMP_AUTH][6]['name'] = $LANG['plugin_tracker']["snmpauth"][3];

	$sopt[PLUGIN_TRACKER_SNMP_AUTH][7]['table'] = 'glpi_dropdown_plugin_tracker_snmp_auth_auth_protocol';
	$sopt[PLUGIN_TRACKER_SNMP_AUTH][7]['field'] = 'name';
	$sopt[PLUGIN_TRACKER_SNMP_AUTH][7]['linkfield'] = 'auth_protocol';
	$sopt[PLUGIN_TRACKER_SNMP_AUTH][7]['name'] = $LANG['plugin_tracker']["snmpauth"][4];

	$sopt[PLUGIN_TRACKER_SNMP_AUTH][8]['table'] = 'glpi_plugin_tracker_snmp_connection';
	$sopt[PLUGIN_TRACKER_SNMP_AUTH][8]['field'] = 'auth_passphrase';
	$sopt[PLUGIN_TRACKER_SNMP_AUTH][8]['linkfield'] = 'auth_passphrase';
	$sopt[PLUGIN_TRACKER_SNMP_AUTH][8]['name'] = $LANG['plugin_tracker']["snmpauth"][5];

	$sopt[PLUGIN_TRACKER_SNMP_AUTH][9]['table'] = 'glpi_dropdown_plugin_tracker_snmp_auth_priv_protocol';
	$sopt[PLUGIN_TRACKER_SNMP_AUTH][9]['field'] = 'name';
	$sopt[PLUGIN_TRACKER_SNMP_AUTH][9]['linkfield'] = 'priv_protocol';
	$sopt[PLUGIN_TRACKER_SNMP_AUTH][9]['name'] = $LANG['plugin_tracker']["snmpauth"][6];

	$sopt[PLUGIN_TRACKER_SNMP_AUTH][10]['table'] = 'glpi_plugin_tracker_snmp_connection';
	$sopt[PLUGIN_TRACKER_SNMP_AUTH][10]['field'] = 'priv_passphrase';
	$sopt[PLUGIN_TRACKER_SNMP_AUTH][10]['linkfield'] = 'priv_passphrase';
	$sopt[PLUGIN_TRACKER_SNMP_AUTH][10]['name'] = $LANG['plugin_tracker']["snmpauth"][7];

	$sopt[PLUGIN_TRACKER_MAC_UNKNOW]['common'] = $LANG['plugin_tracker']["errors"][0];

	$sopt[PLUGIN_TRACKER_MAC_UNKNOW][1]['table'] = 'glpi_plugin_tracker_unknown_mac';
	$sopt[PLUGIN_TRACKER_MAC_UNKNOW][1]['field'] = 'start_FK_processes';
	$sopt[PLUGIN_TRACKER_MAC_UNKNOW][1]['linkfield'] = 'start_FK_processes';
	$sopt[PLUGIN_TRACKER_MAC_UNKNOW][1]['name'] = $LANG['plugin_tracker']["processes"][15];

	$sopt[PLUGIN_TRACKER_MAC_UNKNOW][2]['table'] = 'glpi_plugin_tracker_unknown_mac';
	$sopt[PLUGIN_TRACKER_MAC_UNKNOW][2]['field'] = 'end_FK_processes';
	$sopt[PLUGIN_TRACKER_MAC_UNKNOW][2]['linkfield'] = 'end_FK_processes';
	$sopt[PLUGIN_TRACKER_MAC_UNKNOW][2]['name'] = $LANG['plugin_tracker']["processes"][16];

	$sopt[PLUGIN_TRACKER_MAC_UNKNOW][3]['table'] = 'glpi_plugin_tracker_unknown_mac';
	$sopt[PLUGIN_TRACKER_MAC_UNKNOW][3]['field'] = 'ID';
	$sopt[PLUGIN_TRACKER_MAC_UNKNOW][3]['linkfield'] = 'ID';
	$sopt[PLUGIN_TRACKER_MAC_UNKNOW][3]['name'] = $LANG["common"][2];

	$sopt[PLUGIN_TRACKER_MAC_UNKNOW][4]['table'] = 'glpi_plugin_tracker_unknown_mac';
	$sopt[PLUGIN_TRACKER_MAC_UNKNOW][4]['field'] = 'port';
	$sopt[PLUGIN_TRACKER_MAC_UNKNOW][4]['linkfield'] = 'port';
	$sopt[PLUGIN_TRACKER_MAC_UNKNOW][4]['name'] = $LANG["common"][1];

	$sopt[PLUGIN_TRACKER_MAC_UNKNOW][5]['table'] = 'glpi_plugin_tracker_unknown_mac';
	$sopt[PLUGIN_TRACKER_MAC_UNKNOW][5]['field'] = 'unknow_mac';
	$sopt[PLUGIN_TRACKER_MAC_UNKNOW][5]['linkfield'] = 'unknow_mac';
	$sopt[PLUGIN_TRACKER_MAC_UNKNOW][5]['name'] = $LANG["networking"][15];

	$sopt[PLUGIN_TRACKER_MAC_UNKNOW][6]['table'] = 'glpi_plugin_tracker_unknown_mac';
	$sopt[PLUGIN_TRACKER_MAC_UNKNOW][6]['field'] = 'start_time';
	$sopt[PLUGIN_TRACKER_MAC_UNKNOW][6]['linkfield'] = 'start_time';
	$sopt[PLUGIN_TRACKER_MAC_UNKNOW][6]['name'] = $LANG['plugin_tracker']["processes"][17];

	$sopt[PLUGIN_TRACKER_MAC_UNKNOW][7]['table'] = 'glpi_plugin_tracker_unknown_mac';
	$sopt[PLUGIN_TRACKER_MAC_UNKNOW][7]['field'] = 'end_time';
	$sopt[PLUGIN_TRACKER_MAC_UNKNOW][7]['linkfield'] = 'end_time';
	$sopt[PLUGIN_TRACKER_MAC_UNKNOW][7]['name'] = $LANG['plugin_tracker']["processes"][18];

	$sopt[PLUGIN_TRACKER_SNMP_NETWORKING_PORTS]['common'] = $LANG['plugin_tracker']["errors"][0];

	$sopt[PLUGIN_TRACKER_SNMP_NETWORKING_PORTS][1]['name'] = $LANG["common"][16];
	
	$sopt[PLUGIN_TRACKER_SNMP_NETWORKING_PORTS][2]['name'] = $LANG['plugin_tracker']["snmp"][42];	

	$sopt[PLUGIN_TRACKER_SNMP_NETWORKING_PORTS][3]['name'] = $LANG['plugin_tracker']["snmp"][43];

	$sopt[PLUGIN_TRACKER_SNMP_NETWORKING_PORTS][4]['name'] = $LANG['plugin_tracker']["snmp"][44];
	
	$sopt[PLUGIN_TRACKER_SNMP_NETWORKING_PORTS][5]['name'] = $LANG['plugin_tracker']["snmp"][45];
	
	$sopt[PLUGIN_TRACKER_SNMP_NETWORKING_PORTS][6]['name'] = $LANG['plugin_tracker']["snmp"][46];
	
	$sopt[PLUGIN_TRACKER_SNMP_NETWORKING_PORTS][7]['name'] = $LANG['plugin_tracker']["snmp"][47];
	
	$sopt[PLUGIN_TRACKER_SNMP_NETWORKING_PORTS][8]['name'] = $LANG['plugin_tracker']["snmp"][48];
	
	$sopt[PLUGIN_TRACKER_SNMP_NETWORKING_PORTS][9]['name'] = $LANG['plugin_tracker']["snmp"][49];
	
	$sopt[PLUGIN_TRACKER_SNMP_NETWORKING_PORTS][10]['name'] = $LANG['plugin_tracker']["snmp"][51];
	
	$sopt[PLUGIN_TRACKER_SNMP_NETWORKING_PORTS][11]['name'] = $LANG['plugin_tracker']["mapping"][115];
	
	$sopt[PLUGIN_TRACKER_SNMP_NETWORKING_PORTS][12]['name'] = $LANG["networking"][17];
	
	$sopt[PLUGIN_TRACKER_SNMP_NETWORKING_PORTS][13]['name'] = $LANG['plugin_tracker']["snmp"][50];

	return $sopt;
}

function plugin_tracker_giveItem($type,$ID,$data,$num){
	global $CFG_GLPI, $DB, $INFOFORM_PAGES, $LINK_ID_TABLE,$LANG,$SEARCH_OPTION;

	$table=$SEARCH_OPTION[$type][$ID]["table"];
	$field=$SEARCH_OPTION[$type][$ID]["field"];
	$linkfield=$SEARCH_OPTION[$type][$ID]["linkfield"];

	switch ($table.'.'.$field){

		case "glpi_plugin_tracker_model_infos.name" :
			$out = "<a href=\"" . $CFG_GLPI["root_doc"] . "/" . $INFOFORM_PAGES[$type] . "?ID=" . $data['ID'] . "\">";
			$out .= $data["ITEM_$num"];
			if ($CFG_GLPI["view_ID"] || empty ($data["ITEM_$num"]))
				$out .= " (" . $data["ID"] . ")";
			$out .= "</a>";
			return $out;
			break;
		case "glpi_plugin_tracker_model_infos.device_type" :
			$out = '<center> ';
			switch ($data["ITEM_$num"])
			{
				case COMPUTER_TYPE:
					$out .= $LANG["Menu"][0];
					break;
				case NETWORKING_TYPE:
					$out .= $LANG["Menu"][1];
					break;
				case PRINTER_TYPE:
					$out .= $LANG["Menu"][2];
					break;	
				case PERIPHERAL_TYPE:
					$out .= $LANG["Menu"][16];
					break;	
				case PHONE_TYPE:
					$out .= $LANG["Menu"][34];
					break;	
			}
			$out .= '</center>';			
			return $out;
			break;		
		case "glpi_dropdown_plugin_tracker_snmp_version.FK_snmp_version" :
			$out = getDropdownName("glpi_dropdown_plugin_tracker_snmp_version", $data["ITEM_$num"], 0);
			return $out;
		case "glpi_plugin_tracker_snmp_connection.FK_snmp_connection" :
			$out = getDropdownName("glpi_plugin_tracker_snmp_connection", $data["ITEM_$num"], 0);
			return $out;
		case "glpi_plugin_tracker_errors.device_type" :
			switch ($data["ITEM_$num"]) {
				case COMPUTER_TYPE :
					$out = $LANG['plugin_tracker']["type"][1];
					break;
				case NETWORKING_TYPE :
					$out = $LANG['plugin_tracker']["type"][2];
					break;
				case PRINTER_TYPE :
					$out = $LANG['plugin_tracker']["type"][3];
					break;
			}
			return $out;
			break;
		case "glpi_plugin_tracker_snmp_connection.name" :
			$out = "<a href=\"" . $CFG_GLPI["root_doc"] . "/" . $INFOFORM_PAGES[$type] . "?ID=" . $data['ID'] . "\">";
			$out .= $data["ITEM_$num"];
			if ($CFG_GLPI["view_ID"] || empty ($data["ITEM_$num"]))
				$out .= " (" . $data["ID"] . ")";
			$out .= "</a>";
			return $out;
			break;

		case "glpi_plugin_tracker_errors.device_id" :
			$device_type = $data["ITEM_1"];
			$ID = $data["ITEM_$num"];
			$name = plugin_tracker_getDeviceFieldFromId($device_type, $ID, "name", NULL);

			$out = "<a href=\"" . $CFG_GLPI["root_doc"] . "/" . $INFOFORM_PAGES["$device_type"] . "?ID=" . $ID . "\">";
			$out .= $name;
			if (empty ($name) || $CFG_GLPI["view_ID"])
				$out .= " ($ID)";
			$out .= "</a>";
			return $out;
			break;

		case "glpi_plugin_tracker_errors.first_pb_date" :
			$out = convDateTime($data["ITEM_$num"]);
			return $out;
			break;

		case "glpi_plugin_tracker_errors.last_pb_date" :
			$out = convDateTime($data["ITEM_$num"]);
			return $out;
			break;
		case "glpi_plugin_tracker_networking.FK_networking" :
			if ($num == "9") {
				$plugin_tracker_snmp = new plugin_tracker_snmp;
				$FK_model_DB = $plugin_tracker_snmp->GetSNMPModel($data["ID"],NETWORKING_TYPE);
				$out = "<div align='center'>" . getDropdownName("glpi_plugin_tracker_model_infos", $FK_model_DB, 0) . "</div>";
				return $out;
				break;
			} else
				if ($num == "10") {
					$plugin_tracker_snmp_auth = new plugin_tracker_snmp_auth;
					$FK_snmp_DB = $plugin_tracker_snmp_auth->GetInfos($data["ID"], GLPI_ROOT . "/plugins/tracker/scripts/",NETWORKING_TYPE);
					$out = "<div align='center'>" . $FK_snmp_DB["Name"] . "</div>";
					return $out;
					break;
				}
		case "glpi_plugin_tracker_unknown_mac.port" :
			$Array_device = getUniqueObjectfieldsByportID($data["ITEM_$num"]);
			$CommonItem = new CommonItem;
			$CommonItem->getFromDB($Array_device["device_type"], $Array_device["on_device"]);
			$out = "<div align='center'>" . $CommonItem->getLink(1);

			$query = "SELECT * FROM glpi_networking_ports 
			WHERE ID='" . $data["ITEM_$num"] . "' ";
			$result = $DB->query($query);

			if ($DB->numrows($result) != "0")
				$out .= "<br/><a href='".GLPI_ROOT."/front/networking.port.php?ID=".$data["ITEM_$num"]."'>".$DB->result($result, 0, "name")."</a>";

			$out .= "</td>";
			return $out;
			break;
	}

	if (($type == PLUGIN_TRACKER_MODEL) AND ($linkfield == "EXPORT")) {
		$out = "<div align='center'><form></form><form method='get' action='" . GLPI_ROOT . "/plugins/tracker/front/plugin_tracker.models.export.php' target='_blank'>
					<input type='hidden' name='model' value='" . $data["ID"] . "' />
					<input name='export' src='" . GLPI_ROOT . "/pics/right.png' title='Exporter' value='Exporter' type='image'>
					</form></div>";
		return $out;

	}

	return "";
}
// Define Dropdown tables to be manage in GLPI :
function plugin_tracker_getDropdown() {
	// Table => Name
	global $LANG;
	if (isset ($_SESSION["glpi_plugin_tracker_installed"]) && $_SESSION["glpi_plugin_tracker_installed"] == 1)
		return array (
			"glpi_dropdown_plugin_tracker_snmp_version" => "SNMP version",
			"glpi_dropdown_plugin_tracker_mib_oid" => "OID MIB",
			"glpi_dropdown_plugin_tracker_mib_object" => "Objet MIB",
			"glpi_dropdown_plugin_tracker_mib_label" => "Label MIB"
		);
	else
		return array ();

}

/* Cron for cleaning and printing counters */
function cron_plugin_tracker() {
	plugin_tracker_printingCounters();
	plugin_tracker_cleaningHistory();
}

// Define headings added by the plugin //
function plugin_get_headings_tracker($type,$withtemplate){
	global $LANG;
	$config = new plugin_tracker_config();	

	if (in_array($type,array(NETWORKING_TYPE))){
		// template case
		if ($withtemplate)
			return array();
		// Non template case
		else {
			if ((plugin_tracker_haveRight("snmp_networking", "r")) AND ($config->getValue("activation_snmp_networking") == "1")) {
				return array(
					1 => $LANG['plugin_tracker']["title"][1]
				);
			}
		}
	}else if (in_array($type,array(PRINTER_TYPE))){
		// template case
		if ($withtemplate)
			return array();
		// Non template case
		else {
				if ((plugin_tracker_haveRight("snmp_printers", "r")) AND ($config->getValue("activation_snmp_printer") == "1")) {
				return array(
					1 => $LANG['plugin_tracker']["title"][1]
				);
			}
		}
	}else	if (in_array($type,array(TRACKING_TYPE,PROFILE_TYPE))){
		// template case
		if ($withtemplate)
			return array();
		// Non template case
		else 
			return array(
					1 => $LANG['plugin_tracker']["title"][1],
					);
	}else
		return false;	
}
/*
function plugin_get_headings_tracker($type, $withtemplate) {

	global $LANG;
	$config = new plugin_tracker_config();

	switch ($type) {

		case COMPUTER_TYPE :
			$array = array();
			// template case
			if ($withtemplate)
				return array ();
			// Non template case
			else {
				$array = array ();

				if (plugin_tracker_haveRight("printers_info", "r")) {
					$array = array (
						2 => $LANG['plugin_tracker']["title"][1]
					);
				}
				if ((plugin_tracker_haveRight("computers_history", "r")) && (($config->isActivated('computers_history')) == true)) {
					$array = array (
						1 => $LANG['plugin_tracker']["title"][2]
					);
				}
				return $array;
			}

			break;

		case USER_TYPE :
			$array = array();
			// template case
			if ($withtemplate)
				return array ();
			// Non template case
			else {
				if ((plugin_tracker_haveRight("computers_history", "r")) && (($config->isActivated('computers_history')) == true)) {
					return array (
						1 => $LANG['plugin_tracker']["title"][2]
					);
				}
			}

			break;

	}
	return false;
}
*/

// Define headings actions added by the plugin	 
function plugin_headings_actions_tracker($type) {

	$config = new plugin_tracker_config();

	switch ($type) {
		case COMPUTER_TYPE :

			$array = array ();
			if (plugin_tracker_haveRight("printers_info", "r")) {
				$array = array (
					2 => "plugin_headings_tracker_computersInfo"
				);
			}
			if ((plugin_tracker_haveRight("computers_history", "r")) && (($config->isActivated('computers_history')) == true)) {
				$array = array (
					1 => "plugin_headings_tracker_computerHistory"
				);
			}

			return $array;

			break;

		case PRINTER_TYPE :

			$array = array ();

			if (plugin_tracker_haveRight("snmp_printers", "r")) {
				$array = array (
					1 => "plugin_headings_tracker_printerInfo"
				);
			}

			return $array;

			break;

		case NETWORKING_TYPE :

			if (plugin_tracker_haveRight("snmp_networking", "r")) {
				$array = array (
					1 => "plugin_headings_tracker_networkingInfo"
				);
			}

			return $array;

			break;

		case USER_TYPE :

			break;
		case PROFILE_TYPE :
			return array(
				1 => "plugin_headings_tracker",
				);
			break;

	}
	return false;
}


function plugin_headings_tracker_computerHistory($type, $ID) {

	$computer_history = new plugin_tracker_computers_history();
	$computer_history->showForm(COMPUTER_TYPE, GLPI_ROOT . '/plugins/tracker/front/plugin_tracker.computer_history.form.php', $_GET["ID"]);
}

function plugin_headings_tracker_computerErrors($type, $ID) {

	$errors = new plugin_tracker_errors();
	$errors->showForm(COMPUTER_TYPE, GLPI_ROOT . '/plugins/tracker/front/plugin_tracker.errors.form.php', $_GET["ID"]);
}

function plugin_headings_tracker_computerInfo($type, $ID) {
//	$plugin_tracker_printers = new plugin_tracker_printers();
//	$plugin_tracker_printers->showFormPrinter(GLPI_ROOT . '/plugins/tracker/front/plugin_tracker.printer_info.form.php', $_GET["ID"]);
}

function plugin_headings_tracker_printerInfo($type, $ID) {
	include_once(GLPI_ROOT."/inc/stat.function.php");
	$plugin_tracker_printers = new plugin_tracker_printers();
	$plugin_tracker_printers->showFormPrinter(GLPI_ROOT . '/plugins/tracker/front/plugin_tracker.printer_info.form.php', $ID);
	$plugin_tracker_printers->showFormPrinter_pagescounter(GLPI_ROOT . '/plugins/tracker/front/plugin_tracker.printer_info.form.php', $ID);
}

function plugin_headings_tracker_printerHistory($type, $ID) {

	$print_history = new plugin_tracker_printers_history();
	$print_history->showForm(GLPI_ROOT . '/plugins/tracker/front/plugin_tracker.printer_history.form.php', $_GET["ID"]);
}

function plugin_headings_tracker_printerErrors($type, $ID) {

	$errors = new plugin_tracker_errors();
	$errors->showForm(PRINTER_TYPE, GLPI_ROOT . '/plugins/tracker/front/plugin_tracker.errors.form.php', $_GET["ID"]);
}

function plugin_headings_tracker_printerCronConfig($type, $ID) {

	$print_config = new glpi_plugin_tracker_printers_history_config();
	$print_config->showForm(GLPI_ROOT . '/plugins/tracker/front/plugin_tracker.printer_history_config.form.php', $_GET["ID"]);
}

function plugin_headings_tracker_networkingInfo($type, $ID) {

	$snmp = new plugin_tracker_networking();
	$snmp->showForm(GLPI_ROOT . '/plugins/tracker/front/plugin_tracker.switch_info.form.php', $ID);
}

function plugin_headings_tracker_networkingErrors($type, $ID) {

	$errors = new plugin_tracker_errors();
	$errors->showForm(NETWORKING_TYPE, GLPI_ROOT . '/plugins/tracker/front/plugin_tracker.errors.form.php', $_GET["ID"]);
}

function plugin_headings_tracker_userHistory($type, $ID) {

	$computer_history = new plugin_tracker_computers_history();
	$computer_history->showForm(USER_TYPE, GLPI_ROOT . '/plugins/tracker/front/plugin_tracker.computer_history.form.php', $_GET["ID"]);
}


function plugin_headings_tracker($type,$ID,$withtemplate=0){
	global $CFG_GLPI;

	switch ($type){
		case PROFILE_TYPE :
			$prof=new plugin_tracker_Profile();	
			if (!$prof->GetfromDB($ID))
				plugin_tracker_createaccess($ID);				
			$prof->showForm($CFG_GLPI["root_doc"]."/plugins/tracker/front/plugin_tracker.profile.php",$ID);		
		break;
	}
}


function plugin_tracker_MassiveActions($type) {
	global $LANG;
	switch ($type) {
		case NETWORKING_TYPE :
			return array (
				"plugin_tracker_assign_model" => $LANG['plugin_tracker']["massiveaction"][1],
				"plugin_tracker_assign_auth" => $LANG['plugin_tracker']["massiveaction"][2]
			);
			break;
		case PRINTER_TYPE :
			return array (
				"plugin_tracker_assign_model" => $LANG['plugin_tracker']["massiveaction"][1],
				"plugin_tracker_assign_auth" => $LANG['plugin_tracker']["massiveaction"][2]
			);
			break;
	}
	return array ();
}

function plugin_tracker_MassiveActionsDisplay($type, $action) {
	global $LANG, $CFG_GLPI, $DB;
	switch ($type) {
		case NETWORKING_TYPE :
			switch ($action) {
				case "plugin_tracker_assign_model" :
					dropdownValue("glpi_plugin_tracker_model_infos", "snmp_model", "name");
					echo "<input type=\"submit\" name=\"massiveaction\" class=\"submit\" value=\"" . $LANG["buttons"][2] . "\" >";
					break;
				case "plugin_tracker_assign_auth" :
					plugin_tracker_snmp_auth_dropdown();
					echo "<input type=\"submit\" name=\"massiveaction\" class=\"submit\" value=\"" . $LANG["buttons"][2] . "\" >";
					break;
			}
			break;
		case PRINTER_TYPE :
			switch ($action) {
				case "plugin_tracker_assign_model" :
					dropdownValue("glpi_plugin_tracker_model_infos", "snmp_model", "name");
					echo "<input type=\"submit\" name=\"massiveaction\" class=\"submit\" value=\"" . $LANG["buttons"][2] . "\" >";
					break;
				case "plugin_tracker_assign_auth" :
					plugin_tracker_snmp_auth_dropdown();
					echo "<input type=\"submit\" name=\"massiveaction\" class=\"submit\" value=\"" . $LANG["buttons"][2] . "\" >";
					break;
			}
			break;
	}
	return "";
}

function plugin_tracker_MassiveActionsProcess($data) {
	global $LANG;

	switch ($data['action']) {
		case "plugin_tracker_assign_model" :
			if ($data['device_type'] == NETWORKING_TYPE) {
				foreach ($data['item'] as $key => $val) {
					if ($val == 1) {
						plugin_tracker_assign($key, NETWORKING_TYPE, "model", $data["snmp_model"]);
					}

				}
			}
			else if($data['device_type'] == PRINTER_TYPE)
			{
				foreach ($data['item'] as $key => $val) {
					if ($val == 1) {
						plugin_tracker_assign($key, PRINTER_TYPE, "model", $data["snmp_model"]);
					}

				}
			}
			break;
		case "plugin_tracker_assign_auth" :
			if ($data['device_type'] == NETWORKING_TYPE) {
				foreach ($data['item'] as $key => $val) {
					if ($val == 1) {
						plugin_tracker_assign($key, NETWORKING_TYPE, "auth", $data["FK_snmp_connection"]);
					}

				}
			}
			else if($data['device_type'] == PRINTER_TYPE)
			{
				foreach ($data['item'] as $key => $val) {
					if ($val == 1) {
						plugin_tracker_assign($key, PRINTER_TYPE, "auth", $data["FK_snmp_connection"]);
					}

				}
			}
			break;
	}
}
?>