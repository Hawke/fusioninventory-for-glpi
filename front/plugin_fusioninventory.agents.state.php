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

define('GLPI_ROOT', '../../..');

include (GLPI_ROOT . "/inc/includes.php");

//if (isset ($_POST["startagent"])) {
//   $pta = new PluginFusionInventoryAgents;
//   $ptt = new PluginFusionInventoryTask;
//   $ptais = new PluginFusionInventoryAgentsInventoryState;
//
//   if ($ptt->addTask(0, 0, 'INVENTORY', $_POST['agentID'])) {
//      $ptais->changeStatus($_POST['ID'], 1);
//      if ($pta->RemoteStartAgent($_POST['agentID'], $_POST['ip'])) {
//         $ptais->changeStatus($_POST['ID'], 2);
//      }
//   }
//	glpi_header($_SERVER['HTTP_REFERER']);
//}
//
//$ptais = new PluginFusionInventoryAgentsInventoryState;
//$ptais->computerState($_SERVER["PHP_SELF"], $_GET["ID"]);



if (isset($_POST['action'])) {
   $pfit = new PluginFusionInventoryTask;

   if (isset($_POST['agent-ip'])) {
      foreach ($_POST['agent-ip'] as $agentip) {
         $splitinfo = explode("-",$agentip);
         $param = "";
         if (isset($splitinfo[2])) {
            $param = "$splitinfo[2]";
         }
         // Add a task...
         if ($_POST['action'] == "INVENTORY") {
            $a_device = explode("-", $_POST['device']);
            switch ($a_device[0]) {

               case NETWORKING_TYPE;
               case PRINTER_TYPE;
                  $pfit->addTask($a_device[1], $a_device[0], 'SNMPQUERY', $splitinfo[0], $param);
                  break;

               case COMPUTER_TYPE;
                  $pfit->addTask($a_device[1], $a_device[0], 'INVENTORY', $splitinfo[0]);
                  break;

            }

         } else if ($_POST['action'] == "NETDISCOVERY") {
            $pfit->addTask($_POST['on_device'], $_POST['device_type'], 'NETDISCOVERY', $splitinfo[0], $param);
         } else if ($_POST['action'] == "SNMPQUERY") {
            $pfit->addTask($_POST['on_device'], $_POST['device_type'], 'SNMPQUERY', $splitinfo[0], $param);
         } else if ($_POST['action'] == "WAKEONLAN") {
            $pfit->addTask($_POST['on_device'], $_POST['device_type'], 'WAKEONLAN', $splitinfo[0], $param);
         }

         $pfit->RemoteStartAgent($splitinfo[0], $splitinfo[1]);
      }
   }
}

glpi_header($_SERVER['HTTP_REFERER']);

?>