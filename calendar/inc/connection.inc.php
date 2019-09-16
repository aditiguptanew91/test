<?php

//------------------------------------------------------------------------------
require_once("config.inc.php");

// Setup connection
$database_connection = @mysqli_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);
if(!$database_connection){
	echo "DB connection error! Please configure your settings.";
	if(DB_CONNECTION_MODE != "debug") echo "<br>To get more info about this problem, switch DB_CONNECTION_MODE to 'debug' in config.inc.php";
	if(DB_CONNECTION_MODE == "debug") echo "<br>Error description: ".mysqli_connect_error();
	die();
}

set_collation();

// RETURN TYPES FOR DATABASE_QUERY FUNCTION
define("ALL_ROWS", 0);
define("FIRST_ROW_ONLY", 1);
define("DATA_ONLY", 0);
define("ROWS_ONLY", 1);
define("DATA_AND_ROWS", 2);
define("FIELDS_ONLY", 3);
define("FETCH_ASSOC", "mysqli_fetch_assoc");
define("FETCH_ARRAY", "mysqli_fetch_array");


function database_query($sql, $return_type = DATA_ONLY, $first_row_only = ALL_ROWS, $fetch_func = FETCH_ASSOC, $debug=false) {
	$data_array = array();
	$num_rows = 0;
	$fields_len = 0;
	
	$result = mysqli_query($GLOBALS["database_connection"], $sql) or die($sql . "|" . mysqli_error($GLOBALS["database_connection"]));
	if ($return_type == 0 || $return_type == 2) {
		while ($row_array = $fetch_func($result)) {
			if (!$first_row_only) {
				array_push($data_array, $row_array);
			} else {
				$data_array = $row_array;
				break;
			}
		}
	}
	$num_rows = mysqli_num_rows($result);
	$fields_len = mysqli_num_fields($result);
	mysqli_free_result($result);
	if($debug == true) echo $sql . " - " . mysqli_error($GLOBALS["database_connection"]);
	
	switch ($return_type) {
		case DATA_ONLY:
			return $data_array;
		case ROWS_ONLY:
			return $num_rows;
		case DATA_AND_ROWS:
			return array($data_array, $num_rows);
		case FIELDS_ONLY:
			return $fields_len;
	}	
}


function database_void_query($sql, $debug=false) {
	$result = mysqli_query($GLOBALS["database_connection"], $sql);
	if($debug == true) echo $sql . " - " . mysqli_error($GLOBALS["database_connection"]);
	$affected_rows = mysqli_affected_rows($GLOBALS["database_connection"]);
	if(preg_match("/\bupdate\b/i", $sql)){
		if($affected_rows >= 0) return true;
	}else if(preg_match("/\binsert\b/i", $sql)){
		if($affected_rows >= 0) return mysqli_insert_id($GLOBALS["database_connection"]);
	}else if($affected_rows > 0){ 
		return true;
	}
	return false;
}

function set_collation(){
	$encoding = "utf8";
	$collation = "utf8_unicode_ci";
	
	$sql_variables = array(
		'character_set_client'  =>$encoding,
		'character_set_server'  =>$encoding,
		'character_set_results' =>$encoding,
		'character_set_database'=>$encoding,
		'character_set_connection'=>$encoding,
		'collation_server'      =>$collation,
		'collation_database'    =>$collation,
		'collation_connection'  =>$collation
	);

	foreach($sql_variables as $var => $value){
		$sql = "SET $var=$value;";
		database_void_query($sql);
	}        
}
