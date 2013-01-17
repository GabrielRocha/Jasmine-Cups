<?php
include_once("config.php");
include_once("jasConfig.php");

$page = $_GET['page'];
$limit = $_GET['rows'];
$sidx = $_GET['sidx'];
$sord = $_GET['sord'];
$user = $_GET['user'];
$printer = $_GET['printer'];
$host = $_GET['host'];


if(!$sidx) $sidx =1;
$db = mysql_connect($DB_host, $DB_login, $DB_pass) or die("Connection Error: " . mysql_error());
mysql_select_db($DB_db) or die("Error connecting to db.");

if (isset($user)){
	$result = mysql_query("SELECT COUNT(*) AS count FROM jobs_log WHERE user=$user");
	//echo $user;
	make_info_pages_jqgrid();
	$SQL = "Select id,date,title, host, server, printer,copies,pages FROM jobs_log WHERE user=$user ORDER BY $sidx $sord LIMIT $start,$limit";
	$result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());
	$i=0;
	while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
			$row['host']="<a href=\"".$jas_hostStatsPage.$row['host']."\">".$row['host']."</a>";
			$row['printer']="<a href=\"".$jas_userStatsPage.$row['printer']."\">".$row['printer']."</a>";
			$response->rows[$i]['id']=$row[id];
			$response->rows[$i]['cell']=array($row['date'], $row['title'], $row['host'],$row['server'],$row['printer'], $row['copies'], $row['pages']);
		$i++;
	}
}else if(isset($printer)){
	$result = mysql_query("SELECT COUNT(*) AS count FROM jobs_log WHERE printer=$printer");
	make_info_pages_jqgrid();
	$SQL = "Select id,date,title, host, server, user,copies,pages FROM jobs_log WHERE printer=$printer ORDER BY $sidx $sord LIMIT $start,$limit";
	$result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());
	$i=0;
	while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
			$row['host']="<a href=\"".$jas_hostStatsPage.$row['host']."\">".$row['host']."</a>";
			$row['user']="<a href=\"".$jas_userStatsPage.$row['user']."\">".$row['user']."</a>";
			$response->rows[$i]['id']=$row[id];
			$response->rows[$i]['cell']=array($row['date'],	$row['title'], $row['host'], $row['server'],$row['user'], $row['copies'], $row['pages']);
		$i++;
	}
}else{
	$result = mysql_query("SELECT COUNT(*) AS count FROM jobs_log WHERE host=$host");
	make_info_pages_jqgrid();
	$SQL = "Select id,date,title, printer, server, user,copies,pages FROM jobs_log WHERE host=$host ORDER BY $sidx $sord LIMIT $start,$limit";
	$result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());
	$i=0;
	while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
			$row['printer']="<a href=\"".$jas_printerStatsPage.$row['printer']."\">".$row['printer']."</a>";
			$row['user']="<a href=\"".$jas_userStatsPage.$row['user']."\">".$row['user']."</a>";
			$response->rows[$i]['id']=$row[id];
			$response->rows[$i]['cell']=array($row['date'],	$row['title'], $row['printer'], $row['server'],$row['user'], $row['copies'], $row['pages']);
		$i++;
	}	
}

echo json_encode($response);

function make_info_pages_jqgrid(){
	global $user;
	global $result;
	global $page;
	global $response;
	global $limit;
	global $start;

	$row = mysql_fetch_array($result,MYSQL_ASSOC);
	$count = $row['count'];
	
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
	}	
?>
