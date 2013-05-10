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
  $user=ValidInput($_GET['user']);
  // Escape the string for later display
  $userDisplayName=htmlentities($user);
  
  // Get some stats
  $userTotalPages=jas_getUserTotalPages($user);
  
  // Get user's last month history
  //$userJobHistory=jas_getUserLastJobs($user, 30)
  
?>
    <!-- Begin user stats -->
      <h2>Status do usuário "<?php echo $userDisplayName; ?>"</h2>
      <p class="status">
        <em>Aqui estão algumas informações sobre o usuário <strong><?php echo $userDisplayName; ?></strong></em>
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
			<h3>Pesquisar</h3>
			De: <input type="text" id="data_inicio" name="data_inicio">
			Até: <input type="text" id="data_fim" name="data_fim">
			<p>
				<input type="button" value="Pesquisar" id="pesquisar">
      <h3>Histórico</h3>
	<div id="jqgrid" style="width=100%">
		<table id="list"><tr><td/></tr></table>
		<div id="pager"></div>
	</div>      
<script type="text/javascript">
$(function(){
	
	$("#pesquisar").click(function(){
		$("#list").jqGrid('setGridParam',{url:"jqgrid.php?user=<?php echo $user; ?>&data_inicio="+$("#data_inicio").val()+"&data_fim="+$("#data_fim").val()}).trigger("reloadGrid");
	});
	
	$("#list").jqGrid({
  	url:"jqgrid.php?user=<?php echo $user; ?>",
  	datatype:'json',
  	mtype: 'GET',
  	colNames:['Data','Título', 'IP', 'Servidor', 'Impressora','Cópias','Total Páginas'],
  	colModel :[
    	{name:'Data', index:'date',width:120,sortable:false, align:'center'},
    	{name:'Título', index:'title',width:190,sortable:false, align:'center'},
    	{name:'IP', index:'host', width:100, align:'center',sortable:false},
    	{name:'Servidor', index:'server', width:120, align:'center',sortable:false},
    	{name:'Impressora', index:'printer', width:120, align:'center',sortable:false},
    	{name:'Cópias', index:'copies', width:80, align:'center',sortable:false},
    	{name:'Total Páginas', index:'pages', width:100, sortable:false,align:'center'}
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
			}).navGrid("#pager",{edit:false,add:false,del:false,search:false});
		
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
				$("#list").jqGrid('setGridParam',{url:"jqgrid.php?user=<?php echo $user; ?>"}).trigger("reloadGrid");	
			});
});
</script>
    <!-- End user stats -->
