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

  /* Show_user.php: Displays stats for a given user, 
     passed with $_GET['user']. */
     
  // Includes
  include_once("libJasReports.php");
  

  // Connect to the DB
  DB_connect($DB_host,$DB_login,$DB_pass);
  DB_select($DB_db);
  
  // Get the username
  $user=$_GET['user'];
  // Escape the string for later display
  $userDisplayName=htmlentities($user);
  
  // Get some stats
  $userTotalPages=jas_getUserTotalPages($user);
  
  // Get user's last month history
  $userJobHistory=jas_getUserLastJobs($user, 30)
  
?>
    <!-- Begin user stats -->
      <h2>Status do usuário "<?php echo $userDisplayName; ?>"</h2>
      <p class="status">
        <em>Aqui estão alguns status para a <strong><?php echo $userDisplayName; ?></strong></em>
      </p>
      <h3>Total de páginas</h3>
      <p>
<?php
  if ($userTotalPages)
    echo "        <em>$userDisplayName imprimiu $userTotalPages páginas.</em>\n";
  else
    echo "        Erro. Favor entrar em contato com a DTIC.\n";
?>	  
      </p>
      <h3>Histórico dos últimos 30 dias</h3>
      <?=($userJobHistory)?$userJobHistory:"<p>Erro. Favor entrar em contato com a DTIC.</p>"?>
    <!-- End user stats -->

