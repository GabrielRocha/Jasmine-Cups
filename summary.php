<?php
/* JASmine, print accounting system for Cups.
 Copyright (C) Nayco.

 (Please read the COPYING file)

 This program is free software; you can redistribute it and/or
 modify it under the terms of the GNU General Public License
 as published by the Free Software Foundation; either version 2
 of the License, or (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA. */

  /* Summary.php: Displays a summary of overall  printing
     activity. */

  include_once("libJasReports.php");

  DB_connect($DB_host,$DB_login,$DB_pass);
  DB_select($DB_db);

  $topUsers=jas_getUserRankings(20);
  $topPrinters=jas_getPrinterRankings(10);
  $topHosts=jas_getHostRankings(10);
  $top5Servers=jas_getServerRankings(5);


?><!-- Begin Summary -->
<h2>Índice</h2>
<h3>Top 20 Usuários</h3>
<?=($topUsers)?$topUsers:"<p>An error occured, please check the error messages.</p>"?>
<h3>Top 10 Ip's</h3>
<?=($topHosts)?$topHosts:"<p>An error occured, please check the error messages.</p>"?>
<h3>Top 10 Impressoras</h3>
<?=($topPrinters)?$topPrinters:"<p>An error occured, please check the error messages.</p>"?>
<!--<h3>Servers Top5</h3>
=($top5Servers)?$top5Servers:"<p>An error occured, please check the error messages.</p>"?>-->
<!-- End Summary -->
