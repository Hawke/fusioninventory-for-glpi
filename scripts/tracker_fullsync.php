<?php
/*
 * @version $Id: ocsng_fullsync.php 4980 2007-05-15 13:32:29Z walid $
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
// Original Author of file: David DURIEUX
// Purpose of file:
// ----------------------------------------------------------------------
ini_set("memory_limit","-1");
ini_set("max_execution_time", "0");

$xml_auth_rep = "";

# Converts cli parameter to web parameter for compatibility
if ($argv) {
	for ($i=1;$i<count($argv);$i++)
	{
		$it = split("=",$argv[$i]);
		$it[0] = eregi_replace('^--','',$it[0]);
		$_GET[$it[0]] = $it[1];
	}
}

// Can't run on MySQL replicate
$USEDBREPLICATE=0;
$DBCONNECTION_REQUIRED=1;


// MASS IMPORT for OCSNG
define('GLPI_ROOT', '../../..');

$NEEDED_ITEMS=array("computer","device","printer","networking","peripheral","monitor","software","infocom",
	"phone","tracking","enterprise","reservation","setup","group","registry","rulesengine");
include (GLPI_ROOT . "/config/based_config.php");
include (GLPI_ROOT . "/inc/includes.php");

$CFG_GLPI["debug"]=0; 

//Check if plugin is installed, ie if tables are present
if (!TableExists("glpi_plugin_tracker_networking")) {
	echo "Plugin Tracker pas install�!!";
	exit(1);
}
 
$thread_nbr='';
$thread_id='';
$synchronized_nbr= 0;
$linked_nbr= 0;
$imported_nbr= 0;
$failed_nbr= 0;
$fields=array();
$type='';

if(isset($_GET['discovery_process'])){
	plugin_tracker_discovery_scan_process($_GET['ip1'],$_GET['ip2'],$_GET['ip3'],$_GET['ip4']);
}
elseif(isset($_GET['update_device_process'])){
	plugin_tracker_UpdateDeviceBySNMP_process(array($_GET['id']=>$_GET['ip']),$_GET['FK_process'],$xml_auth_rep,$_GET['type']);
}
else
{
	
	
	//Get script configuration
	
	$config = new plugin_tracker_config();
	
	if (isset($_GET["type"]))
	{
		$type=$_GET["type"];
	}
	
	//Get the script's process identifier
	if (isset($_GET["process_id"]))
		$fields["process_id"] = $_GET["process_id"];
	
	// Add process into database
	
	$processes = new Threads;
	
	$processes->addProcess($fields["process_id"]);
	
	// SNMP is working
	
	logInFile("tracker_snmp", ">>>>>> Starting Script <<<<<<\n\n");
	$OS = "";
	if (isset($_SERVER["OSTYPE"]))
	{
		$OS = $_SERVER["OSTYPE"];
	}
	else if (isset($_SERVER["OS"]))
	{
		$OS = $_SERVER["OS"];
	}
	logInFile("tracker_snmp", "Operating System : ".$OS." \n\n");
	logInFile("tracker_snmp", "I) Get all devices \n\n");
	
	$processes_values = 0;
	$processes_values2 = 0;
	
	// ** QUERY PRINTERS ** //
	if (($type == "printer_type") OR ($type == ""))
	{
		if ($config->getValue("activation_snmp_printer") == "1")
		{
			$ArrayListPrinter = plugin_tracker_getDeviceList(PRINTER_TYPE);
	
			$processes_values2 = plugin_tracker_UpdateDeviceBySNMP($ArrayListPrinter,$fields["process_id"],$xml_auth_rep,PRINTER_TYPE);
		}
	}
	
	// ** QUERY NETWORKING ** //
	if (($type == "networking_type") OR ($type == ""))
	{
		if ($config->getValue("activation_snmp_networking") == "1")
		{
			// Retrieve list of all networking to query SNMP
			$ArrayListNetworking = plugin_tracker_getDeviceList(NETWORKING_TYPE);
			plugin_tracker_snmp_networking_ifaddr($ArrayListNetworking,$xml_auth_rep);

			$processes_values = plugin_tracker_UpdateDeviceBySNMP_startprocess($ArrayListNetworking,$fields["process_id"],$xml_auth_rep,NETWORKING_TYPE);
		}
	}
	if (!isset($processes_values["errors"])){
		$processes_values["errors"] = "";
	}
	// Update process into database
	$processes->updateProcess($fields["process_id"],$processes_values["devices"], $processes_values2["devices"] , $processes_values["errors"]);
	
	
	// Discover function
	// get config if we can or not scan
	$conf = plugin_tracker_discovery_getConf();
	
	if (((isset($conf['discover'])) && ($conf['discover'] == "1") AND ($type == "")) OR ($type == "discovery"))
	{
		$explode = explode(".",$conf['ifaddr_start']);
		$Array_IP['ip11'] = $explode[0];
		$Array_IP['ip12'] = $explode[1];
		$Array_IP['ip13'] = $explode[2];
		$Array_IP['ip14'] = $explode[3];
		$explode = explode(".",$conf['ifaddr_end']);
		$Array_IP['ip21'] = $explode[0];
		$Array_IP['ip22'] = $explode[1];
		$Array_IP['ip23'] = $explode[2];
		$Array_IP['ip24'] = $explode[3];
	
		plugin_tracker_discovery_scan($Array_IP);
	}
	
	if (((isset($conf['getserialnumber'])) && ($conf['getserialnumber'] == "1") AND ($type == "")) OR ($type == "discovery_serial"))
	{
		plugin_tracker_discovery_scan_serial();
	}
}






?>