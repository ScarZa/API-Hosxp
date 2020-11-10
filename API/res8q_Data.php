<?php
session_save_path("../session/");
header('Content-type: text/json; charset=utf-8');

function __autoload($class_name) {
    include '../class/' . $class_name . '.php';
}
include '../function/string_to_ascii.php';
set_time_limit(0);
$connDB = new EnDeCode();
$read = "../connection/conn_DB.txt";
$connDB->para_read($read);
$connDB->Read_Text();
$connDB->conn_PDO();
$rslt = array();
$series = array();
$score = $_GET['data'];
$sql = "SELECT rs8q_id as id
,concat(8qscore_range,' : ',rs8q_name) as name
FROM jvl_8q_results
WHERE rs8q_id = (SELECT 
CASE
    WHEN $score < 1 THEN 9
    WHEN $score >= 1 and $score <= 8 THEN 1
	WHEN $score >= 9 and $score <= 16 THEN 2
    ELSE 3
END FROM jvl_8q_results limit 1);";
$conv=new convers_encode();
    $connDB->imp_sql($sql);
    $place = $connDB->select();
    for($i=0;$i<count($place);$i++){
        $series['id'] = $conv->tis620_to_utf8($place[$i]['id']);
        $series['name'] = $conv->tis620_to_utf8($place[$i]['name']);
    array_push($rslt, $series);    
    }
    print json_encode($rslt);
$connDB->close_PDO();
?>