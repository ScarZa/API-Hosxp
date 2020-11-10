<?php
session_save_path("../session/");
session_start(); 
header('Content-type: text/json; charset=utf-8');

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

$hn = $_GET['data'];   
for($ii=0;$ii<3;$ii++){
    if($ii==0){$es = 'ADHD_In';}elseif($ii==1){$es = 'ADHD_HIn';}elseif($ii==2){$es = 'ODD';}         
$sql = "SELECT ".$es." as name
FROM jvl_snap_iv
WHERE assessor='P' and hn='$hn'
ORDER BY month asc";
$countnum = array();
            $conn_DB->imp_sql($sql);
            $rs = $conn_DB->select();
            $series['name']=$es;
for($i=0;$i<count($rs);$i++){
    $countnum[$i] = (int)$rs[$i]['name'];
    
    $series['data'] = $countnum;
     } 
     array_push($rslt, $series); 
    }
print json_encode($rslt);
$conn_DB->close_PDO();