<?php
include_once("config.php");
include_once("jasConfig.php");

$page = $_GET['page'];
$limit = (int)$_GET['rows'];
$user = $_GET['user'];
$printer = $_GET['printer'];
$host = $_GET["host"];
$data_inicio = $_GET["data_inicio"];
$data_fim_array = explode("/",$_GET["data_fim"]);
$data_fim  = date("d/m/Y",mktime (0, 0, 0, $data_fim_array[1]  , $data_fim_array[0]+1, $data_fim_array[2]));

$column_order = "id";
$order = "desc";

$opcoes = array(
    PDO::ATTR_PERSISTENT => true,
    PDO::ATTR_CASE => PDO::CASE_LOWER
);

try {
		$dbh = new PDO("$DB_driver:host=$DB_host;dbname=$DB_db", "$DB_login", "$DB_pass");
} catch (PDOException $e) {
    echo 'Erro: '.$e->getMessage();
}

if (isset($user)){
	if(isset($data_inicio) and isset($data_fim)){
		get_file_printed_by_date_and_user();
	}else{
		get_all_file_printed_by_user();
	}
	if ($result->execute()) {
		$i=0;
		foreach($result as $row) {
			$row['host']="<a href=\"".$jas_hostStatsPage.$row['host']."\">".$row['host']."</a>";
			$row['printer']="<a href=\"".$jas_userStatsPage.$row['printer']."\">".$row['printer']."</a>";
			$response->rows[$i]['id']=$row[id];
			$response->rows[$i]['cell']=array($row['date'], $row['title'], $row['host'],$row['server'],$row['printer'], $row['copies'], $row['pages']);
		$i++;
		}
	}
}else if(isset($printer)){
	if(isset($data_inicio) and isset($data_fim)){
		get_file_printed_by_date_and_printer();
	}else{
		get_all_file_printed_by_printer();
	}
	if ($result->execute()) {
		$i=0;
		foreach($result as $row) {
				$row['host']="<a href=\"".$jas_hostStatsPage.$row['host']."\">".$row['host']."</a>";
				$row['user']="<a href=\"".$jas_userStatsPage.$row['user']."\">".$row['user']."</a>";
				$response->rows[$i]['id']=$row[id];
				$response->rows[$i]['cell']=array($row['date'],	$row['title'], $row['host'], $row['server'],$row['user'], $row['copies'], $row['pages']);
				$i++;
			}
	}
}else{
	if(isset($data_inicio) and isset($data_fim)){
		get_file_printed_by_date_and_host();
	}else{
		get_all_file_printed_by_hosts();
	}	
	if ($result->execute()) {
		$i=0;
	 	foreach($result as $row) {
			 		$row['printer']="<a href=\"".$jas_printerStatsPage.$row['printer']."\">".$row['printer']."</a>";
			 		$row['user']="<a href=\"".$jas_userStatsPage.$row['user']."\">".$row['user']."</a>";
			 		$response->rows[$i]['id']=$row[id];
			 		$response->rows[$i]['cell']=array($row['date'],	$row['title'], $row['printer'], $row['server'],$row['user'], $row['copies'], $row['pages']);
			 	$i++;
	  }
	}

}

	// $result = mysql_query("SELECT COUNT(*) AS count FROM jobs_log WHERE host=$host");
	// make_info_pages_jqgrid();
	// $SQL = "Select id,date,title, printer, server, user,copies,pages FROM jobs_log WHERE host=$host ORDER BY $sidx $sord LIMIT $start,$limit";
	// $result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());
	// $i=0;
	// while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
	// 		$row['printer']="<a href=\"".$jas_printerStatsPage.$row['printer']."\">".$row['printer']."</a>";
	// 		$row['user']="<a href=\"".$jas_userStatsPage.$row['user']."\">".$row['user']."</a>";
	// 		$response->rows[$i]['id']=$row[id];
	// 		$response->rows[$i]['cell']=array($row['date'],	$row['title'], $row['printer'], $row['server'],$row['user'], $row['copies'], $row['pages']);
	// 	$i++;
	// }	

echo json_encode($response);

function make_info_pages_jqgrid(){
	global $user;
	global $result;
	global $page;
	global $response;
	global $limit;
	global $start;
	

	$result->execute();
	$row = $result->fetch();
	$count = $row['count'];
	$totalpages = $row['totalpages'];
	
	if( $count > 0 && $limit > 0) {
              	$total_pages = ceil($count/$limit);
							} else {
              	$total_pages = 0;	
	}

	if ($page > $total_pages) $page=$total_pages;

	$start = $limit*$page - $limit;

	if($start <0) $start = 0;
	
	$response->page = $page;
	$response->total = $total_pages;
  $response->records = $count;
	$response->sumtotalpages = $totalpages;
}

function get_all_file_printed_by_user(){
	global $user;
	global $result;
	global $order;
	global $column_order;
	global $limit;
	global $start;
	global $dbh;
	$result = $dbh->prepare("SELECT COUNT(*) AS count, SUM(pages) as totalpages FROM jobs_log WHERE user=:user");
	$result->bindValue(':user', $user);
	make_info_pages_jqgrid();
	$result = $dbh->prepare("Select id, DATE_FORMAT(date, '%d/%m/%Y %H:%i:%s') as date ,title, host, server, printer,copies,pages FROM jobs_log WHERE user=:user ORDER BY $column_order $order LIMIT $start,$limit");
	$result->bindValue(':user', $user);
}

function get_file_printed_by_date_and_user(){
	global $user;
	global $data_inicio;
	global $data_fim;
	global $result;
	global $order;
	global $column_order;
	global $limit;
	global $start;
	global $dbh;
	$result = $dbh->prepare("SELECT COUNT(*) AS count, SUM(pages) as totalpages FROM jobs_log WHERE user=:user and date BETWEEN STR_TO_DATE(:data_inicio,'%d/%m/%Y') and STR_TO_DATE(:data_fim,'%d/%m/%Y')");
	$result->bindValue(':user', $user);
	$result->bindValue(':data_inicio', $data_inicio);
	$result->bindValue(':data_fim', $data_fim);
	make_info_pages_jqgrid();
	$result = $dbh->prepare("Select id,DATE_FORMAT(date, '%d/%m/%Y %H:%i:%s') as date,title, host, server, printer,copies,pages FROM jobs_log WHERE user=:user and date BETWEEN STR_TO_DATE(:data_inicio,'%d/%m/%Y') and STR_TO_DATE(:data_fim,'%d/%m/%Y')  ORDER BY $column_order $order 	LIMIT $start, $limit");
	$result->bindValue(':user', $user);
	$result->bindValue(':data_inicio', $data_inicio);
	$result->bindValue(':data_fim', $data_fim);
}

function get_all_file_printed_by_printer(){
	global $printer;
	global $result;
	global $order;
	global $column_order;
	global $limit;
	global $start;
	global $dbh;
	$result = $dbh->prepare("SELECT COUNT(*) AS count, SUM(pages) as totalpages FROM jobs_log WHERE printer=:printer");
	$result->bindValue(':printer', $printer);
	make_info_pages_jqgrid();
	$result = $dbh->prepare("Select id,DATE_FORMAT(date, '%d/%m/%Y %H:%i:%s') as date,title, host, server, user,copies,pages FROM jobs_log WHERE printer=:printer ORDER BY $column_order $order LIMIT $start, $limit");
	$result->bindValue(':printer', $printer);
}

function get_file_printed_by_date_and_printer(){
	global $printer;
	global $data_inicio;
	global $data_fim;
	global $result;
	global $order;
	global $column_order;
	global $limit;
	global $start;
	global $dbh;
	$result = $dbh->prepare("SELECT COUNT(*) AS count, SUM(pages) as totalpages FROM jobs_log WHERE printer=:printer and date BETWEEN STR_TO_DATE(:data_inicio,'%d/%m/%Y') and STR_TO_DATE(:data_fim,'%d/%m/%Y')");
	$result->bindValue(':printer', $printer);
	$result->bindValue(':data_inicio', $data_inicio);
	$result->bindValue(':data_fim', $data_fim);
	make_info_pages_jqgrid();
	$result = $dbh->prepare("Select id,DATE_FORMAT(date, '%d/%m/%Y %H:%i:%s') as date,title, host, server, user,copies,pages FROM jobs_log WHERE printer=:printer and date BETWEEN STR_TO_DATE(:data_inicio,'%d/%m/%Y') and STR_TO_DATE(:data_fim,'%d/%m/%Y')  ORDER BY $column_order $order 	LIMIT $start, $limit");
	$result->bindValue(':printer', $printer);
	$result->bindValue(':data_inicio', $data_inicio);
	$result->bindValue(':data_fim', $data_fim);
}

function get_all_file_printed_by_hosts(){
	global $host;
	global $result;
	global $order;
	global $column_order;
	global $limit;
	global $start;
	global $dbh;
	$result = $dbh->prepare("SELECT COUNT(*) AS count, SUM(pages) as totalpages FROM jobs_log WHERE host=:host");
	$result->bindValue(':host', $host);
	make_info_pages_jqgrid();
	$result = $dbh->prepare("Select id,DATE_FORMAT(date, '%d/%m/%Y %H:%i:%s') as date,title, printer, server, user,copies,pages FROM jobs_log WHERE host=:host ORDER BY $column_order $order LIMIT $start, $limit");
	$result->bindValue(':host', $host);
}

function get_file_printed_by_date_and_host(){
	global $host;
	global $data_inicio;
	global $data_fim;
	global $result;
	global $order;
	global $column_order;
	global $limit;
	global $start;
	global $dbh;
	$result = $dbh->prepare("SELECT COUNT(*) AS count, SUM(pages) as totalpages FROM jobs_log WHERE host=:host and date BETWEEN STR_TO_DATE(:data_inicio,'%d/%m/%Y') and STR_TO_DATE(:data_fim,'%d/%m/%Y')");
	$result->bindValue(':host', $host);
	$result->bindValue(':data_inicio', $data_inicio);
	$result->bindValue(':data_fim', $data_fim);
	make_info_pages_jqgrid();
	$result = $dbh->prepare("Select id,DATE_FORMAT(date, '%d/%m/%Y %H:%i:%s') as date,title, printer, server, user,copies,pages FROM jobs_log WHERE host=:host and date BETWEEN STR_TO_DATE(:data_inicio,'%d/%m/%Y') and STR_TO_DATE(:data_fim,'%d/%m/%Y')  ORDER BY $column_order $order 	LIMIT $start, $limit");
	$result->bindValue(':host', $host);
	$result->bindValue(':data_inicio', $data_inicio);
	$result->bindValue(':data_fim', $data_fim);
}
?>
