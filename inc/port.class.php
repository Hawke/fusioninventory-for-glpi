<?php
/*
 * @version $Id$
 -------------------------------------------------------------------------
 GLPI - Gestionnaire Libre de Parc Informatique
 Copyright (C) 2003-2009 by the INDEPNET Development Team.

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
// Original Author of file: MAZZONI Vincent
// Purpose of file: modelisation of a networking switch port
// ----------------------------------------------------------------------

if (!defined('GLPI_ROOT')) {
	die("Sorry. You can't access directly to this file");
}

/**
 * Class to use networking ports
 **/
class PluginTrackerPort extends PluginTrackerCommonDBTM {
   private $oTracker_networking_ports; // link tracker table object
   private $tracker_networking_ports_ID; // ID in link tracker table
   private $portsToConnect=array(); // ID of known connected ports
   private $connectedPort=''; // ID of connected ports
   private $unknownDevicesToConnect=array(); // IP and/or MAC addresses of unknown connected ports
   private $portVlans=array(); // number and name for each vlan
   private $cdp=false; // true if CDP=1

	/**
	 * Constructor
	**/
   function __construct() {
      parent::__construct("glpi_networking_ports");
      $this->oTracker_networking_ports = new PluginTrackerCommonDBTM("glpi_plugin_tracker_networking_ports");
   }

   /**
    * Load an optionnaly existing port
    *
    *@return nothing
    **/
   function load($p_id='') {
      global $DB;

      parent::load($p_id);
      if (is_numeric($p_id)) { // port exists
         $query = "SELECT `ID`
                   FROM `glpi_plugin_tracker_networking_ports`
                   WHERE `FK_networking_ports` = '".$p_id."';";
         if ($result = $DB->query($query)) {
            if ($DB->numrows($result) != 0) {
               $portTracker = $DB->fetch_assoc($result);
               $this->tracker_networking_ports_ID = $portTracker['ID'];
               $this->oTracker_networking_ports->load($this->tracker_networking_ports_ID);
               $this->ptcdLinkedObjects[]=$this->oTracker_networking_ports;
            } else {
               $this->tracker_networking_ports_ID = NULL;
               $this->oTracker_networking_ports->load();
               $this->ptcdLinkedObjects[]=$this->oTracker_networking_ports;
            }
         }
      } else {
         $this->tracker_networking_ports_ID = NULL;
         $this->oTracker_networking_ports->load();
         $this->ptcdLinkedObjects[]=$this->oTracker_networking_ports;
      }
   }

   /**
    * Update an existing preloaded port with the instance values
    *
    *@return nothing
    **/
   function updateDB() {
      parent::updateDB(); // update core
      $this->oTracker_networking_ports->updateDB(); // update tracker
      $this->connect(); // update connections
      $this->assignVlans(); // update vlans
   }

   /**
    * Add a new port with the instance values
    *
    *@param $p_id Networking ID
    *@return nothing
    **/
   function addDB($p_id) {
      if (count($this->ptcdUpdates)) {
         // update core
         $this->ptcdUpdates['on_device']=$p_id;
         $this->ptcdUpdates['device_type']=NETWORKING_TYPE;
         $portID=parent::add($this->ptcdUpdates);
         // update tracker
         if (count($this->oTracker_networking_ports->ptcdUpdates)) {
            $this->oTracker_networking_ports->ptcdUpdates['FK_networking_ports']=$portID;
            $this->oTracker_networking_ports->add($this->oTracker_networking_ports->ptcdUpdates);
         }
         $this->connect(); // update connections
         $this->assignVlans(); // update vlans
      }
   }

   /**
    * Delete a loaded port
    *
    *@param $p_id Port ID
    *@return nothing
    **/
   function deleteDB() {
      $this->oTracker_networking_ports->deleteDB(); // tracker
      parent::deleteDB(); // core
      // TODO : clean vlans and connections
   }

   /**
    * Add connection
    *
    *@param $p_port Port id
    *@return nothing
    **/
   function addConnection($p_port) {
      $this->portsToConnect[]=$p_port;
   }

   /**
    * Add connection to unknown device
    *
    *@param $p_mac MAC address
    *@param $p_ip IP address
    *@return nothing
    **/
   function addUnknownConnection($p_mac, $p_ip) {
      $this->unknownDevicesToConnect[]=array('mac'=>$p_mac, 'ip'=>$p_ip);
   }

   /**
    * Manage connection to unknown device
    *
    *@param $p_mac MAC address
    *@param $p_ip IP address
    *@return nothing
    **/
   function PortUnknownConnection($p_mac, $p_ip) {
      $ptud = new PluginTrackerUnknownDevice;
      $unknown_infos["name"] = '';
      $newID=$ptud->add($unknown_infos);
      // Add networking_port
      $np=new Netport;
      $port_add["on_device"] = $newID;
      $port_add["device_type"] = PLUGIN_TRACKER_MAC_UNKNOWN;
      $port_add["ifaddr"] = $p_ip;
      $port_add['ifmac'] = $p_mac;
      $dport = $np->add($port_add);
      $ptsnmp=new PluginTrackerSNMP;
      $this->connectDB($dport);
   }

   /**
    * Connect this port to another one in DB
    *
    *@param $destination_port ID of destination port
    *@return nothing
    **/
	function connect() {
      if ($this->getCDP() OR count($this->portsToConnect)+count($this->unknownDevicesToConnect)==1){
         // only one connection
         if (count($this->portsToConnect)) { // this connection is not on an unknown device
            $this->connectedPort = $this->portsToConnect[0];
            $this->connectDB($this->connectedPort);
         }
      } else {
         $index = $this->getConnectionToSwitchIndex();
         if ($index != '') {
            $this->connectedPort = $this->portsToConnect[$index];
            $this->connectDB($this->connectedPort);
         }
      }
      // update connections to unknown devices
      if (!count($this->portsToConnect)) { // if no known connection
         if (count($this->unknownDevicesToConnect)==1) { // if only one unknown connection
            $uConnection = $this->unknownDevicesToConnect[0];
            $this->PortUnknownConnection($uConnection['mac'], $uConnection['ip']);
         }
      }
   }

    /**
    * Connect this port to another one in DB
    *
    *@param $destination_port ID of destination port
    *@return nothing
    **/
	function connectDB($destination_port) {
		global $DB;

		$netwire = new Netwire;

		$queryVerif = "SELECT *
                     FROM `glpi_networking_wire`
                     WHERE `end1` IN ('".$this->getValue('ID')."', '".$destination_port."')
                           AND `end2` IN ('".$this->getValue('ID')."', '".$destination_port."');";

		if ($resultVerif=$DB->query($queryVerif)) {
			if ($DB->numrows($resultVerif) == "0") { // no existing connection between those 2 ports
            $source_port = $this->getValue('ID');
				plugin_tracker_addLogConnection("remove",$netwire->getOppositeContact($source_port));
				plugin_tracker_addLogConnection("remove",$source_port);
            removeConnector($source_port); // remove existing connection to this source port

				plugin_tracker_addLogConnection("remove",$netwire->getOppositeContact($destination_port));
				plugin_tracker_addLogConnection("remove",$destination_port);
            removeConnector($destination_port); // remove existing connection to this dest port

				makeConnector($source_port,$destination_port); // connect those 2 ports
				plugin_tracker_addLogConnection("make",$destination_port);
				plugin_tracker_addLogConnection("make",$source_port);
         }
		}
   }



   /**
    * Add vlan
    *
    *@param $p_number Vlan number
    *@param $p_name Vlan name
    *@return nothing
    **/
   function addVlan($p_number, $p_name) {
      $this->portVlans[]=array('number'=>$p_number, 'name'=>$p_name);
   }

   /**
    * Assign vlans to this port
    *
    *@return nothing
    **/
   function assignVlans() {
      global $DB;
      
      $FK_vlans = array();
      foreach ($this->portVlans as $vlan) {
         $FK_vlans[] = externalImportDropdown("glpi_dropdown_vlan",$vlan['number'],0, array(), $vlan['name']);
      }
      if (count($FK_vlans)) {
         $ports[] = $this->getValue('ID');
         $ports[] = $this->connectedPort;
         foreach ($ports AS $num=>$tmp_port) {
            if ($num==1) { // connected port
               $ptpConnected = new PluginTrackerPort();
               $ptpConnected->load($tmp_port);
               if ($ptpConnected->fields['device_type']==NETWORKING_TYPE) {
                  break; // don't update if port on a switch
               }
            }
            $query = "SELECT *
                      FROM `glpi_networking_vlan`
                           LEFT JOIN `glpi_dropdown_vlan`
                              ON `glpi_networking_vlan`.`FK_vlan`=`glpi_dropdown_vlan`.`ID`
                      WHERE `FK_port`='$tmp_port'";
            if ($result=$DB->query($query)) {
               if ($DB->numrows($result) == "0") { // this port has no vlan
                  foreach ($FK_vlans as $FK_vlan) {
                     $this->assignVlan($tmp_port, $FK_vlan);
                  }
               } else { // this port has one or more vlans
                  $vlansDB = array();
                  $vlansDBnumber = array();
                  $vlansToAssign = array();
                  while ($vlanDB=$DB->fetch_assoc($result)) {
                     $vlansDBnumber[] = $vlanDB['name'];
                     $vlansDB[] = array('number'=>$vlanDB['name'], 'name'=>$vlanDB['comments'], 'ID'=>$vlanDB['ID']);
                  }

                  foreach ($this->portVlans as $portVlan) {
                     $vlanInDB=false;
                     $key='';
                     foreach ($vlansDBnumber as $vlanKey=>$vlanDBnumber) {
                        if ($vlanDBnumber==$portVlan['number']) {
                           $key=$vlanKey;
                        }
                     }
                     if ($key !== '') {
                        unset($vlansDB[$key]);
                        unset($vlansDBnumber[$key]);
                     } else {
                        $vlansToAssign[] = $portVlan;
                     }
                  }
                  foreach ($vlansDB as $vlanToUnassign) {
                     $this->cleanVlan($vlanToUnassign['ID']);
                  }
                  foreach ($vlansToAssign as $vlanToAssign) {
                     $FK_vlan = externalImportDropdown("glpi_dropdown_vlan",$vlanToAssign['number'],0, array(), $vlanToAssign['name']);
                     $this->assignVlan($tmp_port, $FK_vlan);
                  }
               }
            }
         }
      }
   }

   /**
    * Assign vlan
    *
    *@param $p_port Port ID
    *@param $p_vlan Vlan ID
    *@return nothing
    **/
   function assignVlan($p_port, $p_vlan) {
      global $DB;

      $query = "INSERT INTO glpi_networking_vlan (FK_port,FK_vlan)
                VALUES ('$p_port','$p_vlan')";
      $DB->query($query);
   }

   /**
    * Clean vlan
    *
    *@param $p_vlan Vlan ID
    *@return nothing
    **/
   function cleanVlan($p_vlan) {
		global $DB;

      $query="DELETE FROM `glpi_networking_vlan`
              WHERE `FK_vlan`='$p_vlan';";
      $DB->query($query);
	}

   /**
    * Get index of connection to switch
    *
    *@return index of connection in $this->portsToConnect
    **/
   private function getConnectionToSwitchIndex() {
      global $DB;

      $macs='';
      $ptp = new PluginTrackerPort;
      foreach($this->portsToConnect as $index=>$portConnection) {
         if ($macs!='') $macs.=', ';
         $ptp->load($portConnection);
         $macs.="'".$ptp->getValue('ifmac')."'";
         $ifmac[$index]=$ptp->getValue('ifmac');
      }
      if ($macs!='') {
         $query = "SELECT `ifmac`
                   FROM `glpi_networking`
                   WHERE `ifmac` IN (".$macs.");";
         $result=$DB->query($query);
         if ($DB->numrows($result) == 1) {
            $switch = $DB->fetch_assoc($result);
            return array_search($switch['ifmac'], $ifmac);
         }
      }
      return '';
   }

   /**
    * Set CDP
    *
    *@return nothing
    **/
   function setCDP() {
      $this->cdp=true;
   }

   /**
    * Get CDP
    *
    *@return true/false
    **/
   function getCDP() {
      return $this->cdp;
   }
}
?>
