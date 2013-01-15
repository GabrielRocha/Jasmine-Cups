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

  /* Show_host.php: Displays stats for a given host, 
     passed with $_GET['host']. */
     
  // Includes
  include_once("libJasReports.php");
  

  // Connect to the DB
  DB_connect($DB_host,$DB_login,$DB_pass);
  DB_select($DB_db);
  
  // Get the hostname
  $host=$_GET['host'];
  // Escape the string for later display
  $hostDisplayName=htmlentities($host);
  
  // Get some stats
  $hostTotalPages=jas_getHostTotalPages($host);
  
  // Get host's last month history
  $hostJobHistory=jas_getHostLastJobs($host, 30)
  
?>
    <!-- Begin host stats -->
      <h2>Status do usuário "<?php echo $hostDisplayName; ?>"</h2>
      <p class="status">
        <em>Aqui estão alguns status para a <strong><?php echo $hostDisplayName; ?></strong></em>
      </p>
      <h3>Total de páginas</h3>
      <p>
<?php
  if ($hostTotalPages)
    echo "        <em>$hostDisplayName imprimiu $hostTotalPages páginas.</em>\n";
  else
    echo "        Erro. Favor entrar em contato com a DTIC.\n";
?>	  
      </p>
      <h3>Histórico</h3>
      <table id="list"><tr><td/></tr></table>
			<div id="pager"></div>      
<script type="text/javascript">
$(function(){
	$("#list").jqGrid({
  	url:'jqgrid.php?host="<?php echo $host; ?>"',
  	datatype:'json',
  	mtype: 'GET',
  	colNames:['Data','Título', 'Impressora', 'Servidor', 'Usuário','Cópias','Total Páginas'],
  	colModel :[
    	{name:'Data', index:'date', width:155,sortable:false, align:'center'},
    	{name:'Título', index:'title', width:190,sortable:false, align:'center'},
    	{name:'Impressora', index:'host', width:180, align:'center',sortable:false},
    	{name:'Servidor', index:'server', width:180, align:'center',sortable:false},
    	{name:'Usuário', index:'usuario', width:180, align:'center',sortable:false},
    	{name:'Cópias', index:'copies', width:80, align:'center',sortable:false},
    	{name:'Total Páginas', index:'pages', width:100, sortable:false,align:'center'}
  		],
  		pager: '#pager',
  		rowNum:10,
  		rowList:[10,20,30,1000],
  		sortname: 'date',
  		sortorder: 'desc',
			height: '1000%',
  		viewrecords: true,
  		gridview: true,
  		caption: 'Relatório'
			}).navGrid("#pager",{edit:false,add:false,del:false,search:false});
		});
</script>
    <!-- End host stats -->

