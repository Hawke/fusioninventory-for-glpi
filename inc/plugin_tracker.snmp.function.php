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

if (!defined('GLPI_ROOT')){
	die("Sorry. You can't access directly to this file");
}


/**
 * Get all networking list ready for SNMP query  
 *
 * @return array with ID => IP 
 *
**/
function getNetworkList()
{
	global $DB;
	
	$NetworksID = array();	
	
	$query = "SELECT active_device_state FROM glpi_plugin_tracker_config ";
	
	if ( ($result = $DB->query($query)) )
	{
		$device_state = $DB->result($result, 0, "active_device_state");
	}

	$query = "SELECT ID,ifaddr 
	FROM glpi_networking 
	WHERE deleted='0' 
		AND state='".$device_state."' ";
		
	if ( $result=$DB->query($query) )
	{
		while ( $data=$DB->fetch_array($result) )
		{
			$NetworksID[$data["ID"]] = $data["ifaddr"];
		}
	}

	return $NetworksID;

}
	


/**
 * Get and update infos of networking and its ports  
 *
 * @param $ArrayListNetworking ID => IP of the network materiel
 *
 * @return nothing
 *
**/
function UpdateNetworkBySNMP($ArrayListNetworking)
{
	foreach ( $ArrayListNetworking as $IDNetworking=>$ifIP )
	{
		$updateNetwork = new plugin_tracker_snmp;
		// Get SNMP model 
		$snmp_model_ID = $updateNetwork->GetSNMPModel($IDNetworking);
		if (($snmp_model_ID != "") && ($IDNetworking != ""))
		{
			// ** Get oid
			$Array_Object_oid = $updateNetwork->GetOID($snmp_model_ID,"oid_port_dyn='0'");

			// ** Get snmp version and authentification
			// A CODER
			$snmp_version = "1";
			$snmp_auth["community"] = "public";
			$snmp_auth["sec_name"] = "";
			$snmp_auth["sec_level"] = "";
			$snmp_auth["auth_protocol"] = "";
			$snmp_auth["auth_passphrase"] = "";
			$snmp_auth["priv_protocol"] = "";
			$snmp_auth["priv_passphrase"] = "";
			// FIN DE A CODER

			//**
			$ArrayPort_LogicalNum_SNMPName = $updateNetwork->GetPortsName($ifIP,$snmp_version,$snmp_auth);

			//**
			$ArrayPortDB_Name_ID = $updateNetwork->GetPortsID($IDNetworking);

			// **
			$ArrayPort_LogicalNum_SNMPNum = $updateNetwork->GetPortsSNMPNumber($ifIP,$snmp_version,$snmp_auth);

			// ** Get oid ports Counter
			$ArrayPort_Object_oid = tracker_snmp_GetOIDPorts($snmp_model_ID,$ifIP,$IDNetworking,$ArrayPort_LogicalNum_SNMPName,$ArrayPort_LogicalNum_SNMPNum,$snmp_version,$snmp_auth);

			// ** Define oid and object name
			//$updateNetwork->DefineObject($Array_Object_oid);
			// ** Get query SNMP on switch
			$ArraySNMP_Object_result= $updateNetwork->SNMPQuery($Array_Object_oid,$ifIP,$snmp_version,$snmp_auth);

			// ** Define oid and object name
			//$updateNetwork->DefineObject($ArrayPort_Object_oid);
			// ** Get query SNMP of switchs ports
			$ArraySNMPPort_Object_result = $updateNetwork->SNMPQuery($ArrayPort_Object_oid,$ifIP,$snmp_version,$snmp_auth);

			// ** Get link OID fields
			$Array_Object_TypeNameConstant = $updateNetwork->GetLinkOidToFields($snmp_model_ID);

			// ** Update fields of switchs
			tracker_snmp_UpdateGLPINetworking($ArraySNMP_Object_result,$Array_Object_TypeNameConstant,$IDNetworking);

			// ** Update ports fields of switchs
			UpdateGLPINetworkingPorts($ArraySNMPPort_Object_result,$Array_Object_TypeNameConstant,$IDNetworking,$ArrayPort_LogicalNum_SNMPNum,$ArrayPortDB_Name_ID);
exit();








			
			// ** Get MAC adress of connected ports
			$updateNetwork->GetMACtoPort($ifIP,$ArrayPortDB_Name_ID,$IDNetworking);
		}
	} 

}



function tracker_snmp_GetOIDPorts($snmp_model_ID,$IP,$IDNetworking,$ArrayPort_LogicalNum_SNMPName,$ArrayPort_LogicalNum_SNMPNum,$snmp_version,$snmp_auth)
{
	
	global $DB;

	$oidList = array();
	$object = "";
	$portcounter = "";

	$snmp_queries = new plugin_tracker_snmp;
	

	$return = $snmp_queries->GetOID($snmp_model_ID,"oid_port_counter='1'");	
	foreach ($return as $key=>$value)
	{
		$object = $key;
		$portcounter = $value;
	}

	// Get query SNMP to have number of ports

	if (isset($portcounter))
	{

		$snmp_queries->DefineObject(array($object=>$portcounter));
	
		$Arrayportsnumber = $snmp_queries->SNMPQuery(array($object=>$portcounter),$IP,$snmp_version,$snmp_auth);

		$portsnumber = $Arrayportsnumber[$object];

		// We have the number of Ports

		// Add ports in DataBase if they don't exists

		$np=new Netport();

		for ($i = 1; $i <= $portsnumber; $i++)
		{
		
			$query = "SELECT ID,name
		
			FROM glpi_networking_ports
			
			WHERE on_device='".$IDNetworking."'
				AND logical_number='".$i."' ";
		
			if ( $result = $DB->query($query) )
			{
				if ( $DB->numrows($result) == 0 )
				{

					$array["logical_number"] = $i;
					$array["name"] = $ArrayPort_LogicalNum_SNMPName[$i];
					$array["iface"] = "";
					$array["ifaddr"] = "";
					$array["ifmac"] = "";
					$array["netmask"] = "";
					$array["gateway"] = "";
					$array["subnet"] = "";
					$array["netpoint"] = "";
					$array["on_device"] = $IDNetworking;
					$array["device_type"] = "2";
					$array["add"] = "Ajouter";
					
					$IDPort = $np->add($array);
					logEvent(0, "networking", 5, "inventory", "Tracker ".$LANG["log"][70]);


					//$queryInsert = "INSERT INTO glpi_networking_ports 
					//	(on_device,device_type,logical_number)
					
					//VALUES ('".$IDNetworking."','2','".$i."') ";
					
					//$DB->query($query);
					
					//$IDPort = mysql_insert_id();
					
					$queryInsert = "INSERT INTO glpi_plugin_tracker_networking_ports 
						(FK_networking_ports)
					
					VALUES ('".$IDPort."') ";
					
					$DB->query($queryInsert);
					tracker_snmp_addLog($IDPort,"port creation","","");
				
				}
				else
				{
				echo "DEDE\n";
					// Update if it's necessary
					// $np->update
					if ($DB->result($result, 0, "name") != $ArrayPort_LogicalNum_SNMPName[$i])
					{
						
						unset($array);
						$array["name"] = $ArrayPort_LogicalNum_SNMPName[$i];
						$array["ID"] = $DB->result($result, 0, "ID");
						$np->update($array);
					
					}

				
				
					$queryTrackerPort = "SELECT ID
				
					FROM glpi_plugin_tracker_networking_ports
					
					WHERE FK_networking_ports='".$DB->result($result, 0, "ID")."' ";
				
					if ( $resultTrackerPort = $DB->query($queryTrackerPort) ){
						if ( $DB->numrows($resultTrackerPort) == 0 ) {
						
							$queryInsert = "INSERT INTO glpi_plugin_tracker_networking_ports 
								(FK_networking_ports)
							
							VALUES ('".$DB->result($result, 0, "ID")."') ";

							$DB->query($queryInsert);
							tracker_snmp_addLog($DB->result($result, 0, "ID"),"SNMP port creation","","");
						
						}
					}
					
				}
			}
		
		}

	}
	// Get oid list of ports

	$oidList = $snmp_queries->GetOID($snmp_model_ID,"oid_port_dyn='1'",$Arrayportsnumber[$object],$ArrayPort_LogicalNum_SNMPNum);

	// Debug
	foreach($oidList as $object=>$oid)
	{
		echo "===========>".$object." => ".$oid."\n";
	}
	// Debug END		
	return $oidList;
	
}	



function tracker_snmp_UpdateGLPINetworking($ArraySNMP_Object_result,$Array_Object_TypeNameConstant,$IDNetworking)
{

	global $DB,$LANG,$LANGTRACKER,$TRACKER_MAPPING;	

	foreach($ArraySNMP_Object_result as $object=>$SNMPValue)
	{
		$explode = explode ("||", $Array_Object_TypeNameConstant[$object]);
		$object_type = $explode[0];
		$object_name = $explode[1];

		if ($TRACKER_MAPPING[$object_type][$object_name]['dropdown'] != "")
		{
			// Search if value of SNMP Query is in dropdown, if not, we put it
			// Wawax : si tu ajoutes le lieu manuellement tu mets un msg dans le message_after_redirect
			// 
			
			// $ArrayDropdown = getDropdownArrayNames($data["table"],"%")
			$SNMPValue = externalImportDropdown($TRACKER_MAPPING[$object_type][$object_name]['dropdown'],$SNMPValue,0);
			

		}
		
		// Update fields
		//$query_update = "UPDATE
		if ($TRACKER_MAPPING[$object_type][$object_name]['table'] == "glpi_networking")
		{
		
			$Field = "ID";
			
		}
		else
		{
			
			$Field = "FK_networking";
			
		}
		
		$SNMPValue = preg_replace('/^\"/', '',$SNMPValue);
		$SNMPValue = preg_replace('/\"$/', '',$SNMPValue);

		$queryUpdate = "UPDATE ".$TRACKER_MAPPING[$object_type][$object_name]['table']."
		
		SET ".$TRACKER_MAPPING[$object_type][$object_name]['field']."='".$SNMPValue."' 
		
		WHERE ".$Field."='".$IDNetworking."'";
		
		// update via :  $networking->update(array("serial"=>"tonnumero"));
		
		$DB->query($queryUpdate);
		
		//<MoYo> cleanAllItemCache($item,$group)
		//<MoYo> $item = ID
		//<MoYo> group = GLPI_ + NETWORKING_TYPE

	}
}



function UpdateGLPINetworkingPorts($ArraySNMPPort_Object_result,$Array_Object_TypeNameConstant,$IDNetworking,$ArrayPort_LogicalNum_SNMPNum,$ArrayPortDB_Name_ID)
{

	global $DB,$LANG,$LANGTRACKER,$TRACKER_MAPPING;	
	
	$ArrayPortsList = array();
	
	$ArrayPortListTracker = array();
	
	$ArrayPort_LogicalNum_SNMPNum = array_flip($ArrayPort_LogicalNum_SNMPNum);
	
	$query = "SELECT ID, logical_number
	
	FROM glpi_networking_ports
	
	WHERE on_device='".$IDNetworking."'
	
	ORDER BY logical_number";
	
	if ( $result=$DB->query($query) )
	{
		while ( $data=$DB->fetch_array($result) )
		{
		
			$ArrayPortsList[$data["logical_number"]] = $data["ID"];
			
			$queryPortsTracker = "SELECT ID,FK_networking_ports
			
			FROM glpi_plugin_tracker_networking_ports
			
			WHERE FK_networking_ports='".$data["ID"]."' ";
			
			if ( $resultPortsTracker=$DB->query($queryPortsTracker) )
			{
				while ( $dataPortsTracker=$DB->fetch_assoc($resultPortsTracker) )
				{
					$ArrayPortListTracker[$data["logical_number"]] = $dataPortsTracker["ID"];
					$ArrayDB_ID_FKNetPort[$data["logical_number"]] = $dataPortsTracker["FK_networking_ports"];
					
				}
			} 
		
		}
	}
	
	foreach($ArraySNMPPort_Object_result as $object=>$SNMPValue)
	{
		$ArrayObject = explode (".",$object);
		$i = count($ArrayObject);
		$i--;
		$PortNumber = $ArrayObject[$i];

		
		$object = '';
		
		for ($j = 0; $j < $i;$j++)
		{
		
			$object .= $ArrayObject[$j];

		}

		$explode = explode ("||", $Array_Object_TypeNameConstant[$object]);
		$object_type = $explode[0];
		$object_name = $explode[1];

		if ($TRACKER_MAPPING[$object_type][$object_name]['dropdown'] != "")
		{
		
			$SNMPValue = externalImportDropdown($TRACKER_MAPPING[$object_type][$object_name]['dropdown'],$SNMPValue,0);
		
		}
		else
		{
			
			if ($TRACKER_MAPPING[$object_type][$object_name]['table'] == "glpi_networking_ports")
			{
			
				$Field = $ArrayPortsList[$ArrayPort_LogicalNum_SNMPNum[$PortNumber]];
				
			}
			else
			{

				$Field = $ArrayPortListTracker[$ArrayPort_LogicalNum_SNMPNum[$PortNumber]];


			}						

			// Detect if changes

			$update = 0;
			$query_select = "SELECT ".$TRACKER_MAPPING[$object_type][$object_name]['field']."
			FROM ".$TRACKER_MAPPING[$object_type][$object_name]['table']."
			WHERE ID='".$Field."'";
			if ( $result_select=$DB->query($query_select) )
			{
				while ( $data_select=$DB->fetch_assoc($result_select) )
				{
					if ($SNMPValue != $data_select[$TRACKER_MAPPING[$object_type][$object_name]['field']])
					{
						$update = 1;
						$SNMPValue_old = $data_select[$TRACKER_MAPPING[$object_type][$object_name]['field']];
					}

				}
			}		
			
			if ($update == "1")
			{
				$queryUpdate = "UPDATE ".$TRACKER_MAPPING[$object_type][$object_name]['table']."
			
				SET ".$TRACKER_MAPPING[$object_type][$object_name]['field']."='".$SNMPValue."' 
				
				WHERE ID='".$Field."'";

				$DB->query($queryUpdate);
				tracker_snmp_addLog($ArrayDB_ID_FKNetPort[$Field],$TRACKER_MAPPING[$object_type][$object_name]['name'],$SNMPValue_old,$SNMPValue);
			}
		}					
	}
}

?>