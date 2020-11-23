<?php 

function db_connect( $host='10.0.0.254', $dbname='hosxp', $user='admintoy', $passwd='gotoytoynoy', $port='3306', $persist=false ) {
	function_exists( 'mysqli_connect' )
		or  die( 'FATAL ERROR: MySQL support not avaiable.  Please check your configuration.' );

	if ($persist) {
		mysqli_connect( "P:"."$host:$port", $user, $passwd )
			or die( 'FATAL ERROR: Connection to database server failed' );
	} else {
		$db = mysqli_connect($host, $user, $passwd,$dbname ,$port)
			or die( 'FATAL ERROR: Connection to database server failed' );
			print_r($db) ;
	}

	// if ($dbname) {
	// 	$sel_DB = mysqli_select_db($db, $dbname )
	// 		or die( "FATAL ERROR: Database not found ($dbname)" );
	// } else {
	// 	die( "FATAL ERROR: Database name not supplied<br />(connection to database server succesful)" );
	// }
	// print_r($sel_DB) ;
}
function addDB() {
  $GLOBALS['db'];
}
function db_close(){
    //function_exists('mysql_close')
       // or die('FATAL ERROR: MySQL support not avaiable.  Please check your configuration.' );
        
    //if($dbname){
        mysqli_close($db);
    //}
}

function db_error() {
	return mysqli_error($db);
}

function db_errno() {
	return mysqli_errno($db);
}

function db_insert_id() {
	return mysqli_insert_id($db);
}

function db_exec( $sql ) {
	include 'connect1.php';
	$cur = mysqli_query($db, $sql );
	if( !$cur ) {
		return false;
	}
	return $cur;
}

function db_free_result( $cur ) {
	mysqli_free_result( $cur );
}

function db_num_rows( $qid ) {
	return mysqli_num_rows( $qid );
}

function db_fetch_row( $cur ) {
	return mysqli_fetch_row( $cur );
}

function db_fetch_assoc( $cur ) {
	return mysqli_fetch_assoc( $cur );
}

function db_fetch_array( $cur  ) {
	return mysqli_fetch_array( $cur );
}

function db_fetch_object( $cur  ) {
	return mysqli_fetch_object( $cur );
}

function db_escape( $str ) {
	return mysqli_escape_string( $str );
}

function db_version() {
	;
	if( ($cur = mysqli_query($db, "SELECT VERSION()" )) ) {
		$row =  mysqli_fetch_row( $cur );
		mysqli_free_result( $cur );
		return $row[0];
	} else {
		return 0;
	}
}

function db_unix2dateTime( $time ) {
	// converts a unix time stamp to the default date format
	return $time > 0 ? date("Y-m-d H:i:s", $time) : null;
}

function db_dateTime2unix( $time ) {
	if ($time == '0000-00-00 00:00:00') {
		return -1;
	}
	if( ! preg_match( "/^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})(.?)$/", $time, $a ) ) {
		return -1;
	} else {
		return mktime( $a[4], $a[5], $a[6], $a[2], $a[3], $a[1] );
	}
}
?>