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

//Options for GLPI 0.71 and newer : need slave db to access the report
$USEDBREPLICATE=1;
$DBCONNECTION_REQUIRED=0;

$NEEDED_ITEMS=array("search","computer","infocom","setup","networking");

define('GLPI_ROOT', '../../..'); 
include (GLPI_ROOT . "/inc/includes.php"); 

includeLocales("plugin_reports.computer");

plugin_reports_checkRight("computer","r");

commonHeader($GEDIFFREPORTLANG["computer"][1],$_SERVER['PHP_SELF'],"utils","report");

if (isset($_GET["reset_search"]))
	resetSearch();

$_GET=getValues($_GET,$_POST);

displaySearchForm();

manageGetValuesInSearch(PLUGIN_TRACKER_SNMP_HISTORY);

if(isset($_GET["FK_networking_ports"])){
		
	
	$field[]=2;
	$contains[]=$_GET["FK_networking_ports"];
	
	$_GET["field"] = $field;
	$_GET["contains"] = $contains;
	$_GET["sort"] = 1;
	$_GET["order"]="DESC";


	showList(PLUGIN_TRACKER_SNMP_HISTORY,$_SERVER['PHP_SELF'],$_GET["field"],$_GET["contains"],$_GET["sort"],$_GET["order"],$_GET["start"],$_GET["deleted"],$_GET["link"],$_GET["distinct"],$_GET["link2"],$_GET["contains2"],$_GET["field2"],$_GET["type2"]);

	
} 
	
echo "</form>";

commonFooter(); 

function displaySearchForm()
{
	global $DB,$_SERVER,$_GET,$GEDIFFREPORTLANG,$LANG,$CFG_GLPI;
	
	echo "<form action='".$_SERVER["PHP_SELF"]."' method='post'>";
	echo "<table class='tab_cadre' cellpadding='5'>";
	echo "<tr class='tab_bg_1' align='center'>";

	echo "<td>";
	echo $LANG["reports"][46]." :&nbsp;";

	$query = "SELECT glpi_networking.name as name,glpi_networking_ports.name as pname,
	glpi_networking_ports.ID as ID FROM glpi_networking
	LEFT JOIN glpi_networking_ports ON on_device = glpi_networking.ID
	WHERE device_type=".NETWORKING_TYPE."
	ORDER BY glpi_networking.name,glpi_networking_ports.logical_number";
	echo "<select name='FK_networking_ports'>";
	echo "<option>-----</option>";
	$result=$DB->query($query);
	while ( $data=$DB->fetch_array($result) )
	{
		$selected = '';
		if ((isset($_GET["FK_networking_ports"])) AND ($data['ID'] == $_GET["FK_networking_ports"]))
			$selected = "selected";
		echo "<option value='".$data['ID']."' ".$selected.">".$data['name']." - ".$data['pname']."</option>";
	}
	
	echo "</select>";

	echo "</td>";
	
	echo "<td>";
	echo "<input type='submit' value='Valider' class='submit' />";
	echo "</td>";
	
	echo "</tr>";
	echo "</table></form>";
}
 
function getValues($get,$post)
{
	$get=array_merge($get,$post);
	if (isset($get["field"]))
	{
		foreach ($get["field"] as $index => $value)
		{
			switch($value)
			{
				case 103:
					if (strpos( $get["contains"][$index],"lt;")==1)
						$get["dropdown_sup_inf"]="inf";
					else
						$get["dropdown_sup_inf"]="sup";
						
					$get["dropdown_calendar"] = substr($get["contains"][$index],4);
					break;
				case 31:
					$input["tablename"]="glpi_dropdown_state";
					$input["value"]=$get["contains"][$index];
					$input["FK_entities"]=0;
					$get["dropdown_state"] = getDropdownID($input);
					break;
				case 32:
					$input["tablename"]="glpi_dropdown_network";
					$input["value"]=$get["contains"][$index];
					$input["FK_entities"]=0;
					$get["dropdown_network"] = $get["contains"][$index];
					break;
			}
		}
		
		if (isset($get["link"]))
			foreach ($get["link"] as $index=>$value)
				$get["dropdown_and"][$index]=$value;
	}
	return $get;	
}

function resetSearch()
{
	$_GET["start"]=0;
	$_GET["order"]="ASC";
	$_GET["deleted"]=0;
	$_GET["distinct"]="N";
	$_GET["link"]=array();
	$_GET["field"]=array(0=>"view");
	$_GET["contains"]=array(0=>"");
	$_GET["link2"]=array();
	$_GET["field2"]=array(0=>"view");
	$_GET["contains2"]=array(0=>"");
	$_GET["type2"]="";
	$_GET["sort"]=1;
	
	$_GET["dropdown_state"]=5;
	$_GET["dropdown_network"]=4;
	$_GET["dropdown_sup_inf"]="inf";
	$_GET["dropdown_calendar"]=date("Y-m-d", mktime(0,0,0,date('m')-3,date('d'),date('Y')));
}
?>