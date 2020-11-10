<?php
header('Content-type: text/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Allow-Credentials: true");
function __autoload($class_name) {
    include '../class/' . $class_name . '.php';
}

$conn_DB = new EnDeCode();
$read = "../connection/conn_DB.txt";
$conn_DB->para_read($read);
$conn_db = $conn_DB->Read_Text();
$conn_DB->conn_PDO();
set_time_limit(0);
$rslt = array();
$series = array();

$countnum = array();

$hn = $_GET['data'];            
$sql = "SELECT cgis_score
FROM cgi
WHERE hn='$hn'
ORDER BY id asc";
            $conn_DB->imp_sql($sql);
            $rs = $conn_DB->select();
            $series['name']='ผล';
for($i=0;$i<count($rs);$i++){
    $countnum[0] = (int)$rs[$i]['cgis_score'];
    
    $series['data'][$i] = $countnum;
     }            
    array_push($rslt, $series);
print json_encode($rslt);
$conn_DB->close_PDO();