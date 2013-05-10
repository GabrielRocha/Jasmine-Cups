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
  $host=ValidInput($_GET['host']);
	
	
  // Escape the string for later display
  $hostDisplayName=htmlentities($host);
  
  // Get some stats
  $hostTotalPages=jas_getHostTotalPages($host);
  
  // Get host's last month history
  //$hostJobHistory=jas_getHostLastJobs($host, 30)
  
?>
    <!-- Begin host stats -->
      <h2>Status do usuário "<?php echo $hostDisplayName; ?>"</h2>
      <p class="status">
        <em>Aqui estão algumas informações sobre o IP  <strong><?php echo $hostDisplayName; ?></strong></em>
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
			<h3>Pesquisar</h3>
			De: <input type="text" id="data_inicio" name="data_inicio">
			Até: <input type="text" id="data_fim" name="data_fim">
			<p>
				<input type="button" value="Pesquisar" id="pesquisar">
      <h3>Histórico</h3>
      <table id="list"><tr><td/></tr></table>
			<div id="pager"></div>      
<script type="text/javascript">
$(function(){
	
	$("#pesquisar").click(function(){
		$("#list").jqGrid('setGridParam',{url:"jqgrid.php?host=<?php echo $host; ?>&data_inicio="+$("#data_inicio").val()+"&data_fim="+$("#data_fim").val()}).trigger("reloadGrid");
	});
	
	$("#list").jqGrid({
  	url:'jqgrid.php?host=<?php echo $host; ?>',
  	datatype:'json',
  	mtype: 'GET',
  	colNames:['Data','Título', 'Impressora', 'Servidor', 'Usuário','Cópias','Total Páginas'],
  	colModel :[
    	{name:'Data', index:'date', width:155,sortable:false, align:'center', searchoptions: { sopt: ['eq', 'bw', 'cn']}},
    	{name:'Título', index:'title', width:190,sortable:false, align:'center', searchoptions: { sopt: ['eq', 'bw', 'cn']}},
    	{name:'Impressora', index:'host', width:180, align:'center',sortable:false,search: false},
    	{name:'Servidor', index:'server', width:180, align:'center',sortable:false,search: false},
    	{name:'Usuário', index:'usuario', width:180, align:'center',sortable:false, searchoptions: { sopt: ['eq', 'bw', 'cn']}},
    	{name:'Cópias', index:'copies', width:80, align:'center',sortable:false,search: false},
    	{name:'Total Páginas', index:'pages', width:100, sortable:false,align:'center',search: false}
  		],
  		pager: '#pager',
  		rowNum:10,
  		rowList:[10,20,30,100000000000],
			height: '100%',
			autowidth: true,
  		viewrecords: true,
  		gridview: true,
  		caption: 'Relatório',
			loadComplete: function() {
			    $("option[value=100000000000]").text('All');
			},
			}).navGrid("#pager", { search: false, add: false, edit: false, view: false, del: false });
			
		$("#data_inicio").datepicker({
			dateFormat: 'dd/mm/yy',
			changeMonth: true,
			changeYear: true,
			showButtonPanel:true,
			showOn: "both",
			buttonImage: "images/calendario.jpg",
			buttonImageOnly: true,
			dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
			dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
			dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
			monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
			monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez']
		});
		$("#data_fim").datepicker({
			dateFormat: 'dd/mm/yy',
			changeMonth: true,
			changeYear: true,
			showButtonPanel:true,
			showOn: "both",
			buttonImage: "images/calendario.jpg",
			buttonImageOnly: true,
			dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
			dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
			dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
			monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
			monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez']
		});
		
		$(".ui-icon-refresh").click(function(){
			$("#list").jqGrid('setGridParam',{url:"jqgrid.php?host=<?php echo $host; ?>"}).trigger("reloadGrid");	
		});
});
</script>
    <!-- End host stats -->

