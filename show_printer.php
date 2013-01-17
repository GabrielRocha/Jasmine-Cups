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

  /* Show_printer.php: Displays stats for a given printer, 
     passed with $_GET['printer']. */
     
  // Includes
  include_once("libJasReports.php");
  

  // Connect to the DB
  DB_connect($DB_host,$DB_login,$DB_pass);
  DB_select($DB_db);

  // Get the printer name
  $printer=$_GET['printer'];
  // Escape the string for later display
  $printerDisplayName=htmlentities($printer);
  
  // Get some stats
  $printerTotalPages=jas_getPrinterTotalPages($printer);
  
  // Get printer's last month history
  $printerJobHistory=jas_getPrinterLastJobs($printer, 30);
?>
    <!-- Begin printer stats -->
      <h2>Status da impressora "<?php echo $printerDisplayName; ?>"</h2>
      <p class="status">
        <em>Aqui estão algumas informações da impressora <strong><?php echo $printerDisplayName; ?></strong></em>
      </p>
      <h3>Total de páginas</h3>
      <p>
<?php
  if ($printerTotalPages)
    echo "        <em>$printerTotalPages páginas foram impressas na  $printerDisplayName</em>\n";
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
  	url:'jqgrid.php?printer="<?php echo $printer; ?>"',
  	datatype:'json',
  	mtype: 'GET',
  	colNames:['Data','Título', 'IP', 'Servidor', 'Usuário','Cópias','Total Páginas'],
  	colModel :[
    	{name:'Data', index:'date', width:155,sortable:false, align:'center'},
    	{name:'Título', index:'title', width:190,sortable:false, align:'center'},
    	{name:'IP', index:'host', width:180, align:'center',sortable:false},
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
		height: '100%',
		autowidth: true,
  		viewrecords: true,
  		gridview: true,
  		caption: 'Relatório'
			}).navGrid("#pager",{edit:false,add:false,del:false,search:false});
		});
</script>
    <!-- End printer stats -->

