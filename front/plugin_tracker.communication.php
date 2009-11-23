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
// Purpose of file: test of communication class
// ----------------------------------------------------------------------

if (!defined('GLPI_ROOT')) {
	define('GLPI_ROOT', '../../..');
}
include (GLPI_ROOT."/inc/includes.php");

//include("agent_communication.php");
$ptc = new PluginTrackerCommunication();
$res='';
$errors='';
//if ($ac->connectionOK($errors)) {
if (1) {
   $res .= "1'".$errors."'";
   $ptc->addDiscovery();
   $ptc->setXML("<?xml version='1.0' encoding='ISO-8859-1'?>
         <REPLY>
<OPTION><NAME>DOWNLOAD</NAME>
<PARAM FRAG_LATENCY=\"10\" PERIOD_LATENCY=\"10\" TIMEOUT=\"30\" ON=\"1\" TYPE=\"CONF\" CYCLE_LATENCY=\"60\" PERIOD_LENGTH=\"10\" /></OPTION>
            <RESPONSE>SEND</RESPONSE>
            <PROLOG_FREQ>24</PROLOG_FREQ>
</REPLY>");
   echo $ptc->send(); // echo response for the agent
   $ptc->addQuery();
   //$ptc->addDiscovery();
//   echo $ptc->getXML();
} else {
   $res .= "0'".$errors."'";
}
//file_put_contents('dial.log', $res);
?>