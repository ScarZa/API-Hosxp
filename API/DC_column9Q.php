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

$hn = $_GET['data'];   
for($ii=0;$ii<2;$ii++){
    if($ii==0){$es = 'ds.depression_score';$namecase='9Q';}elseif($ii==1){$es = 'ds.suicide_score';$namecase='8Q';}
$sql = "SELECT ".$es." as name
FROM jvl_headData_2q8q9q hd
inner join depression_screen ds on ds.depression_screen_id = hd.depression_screen_id
WHERE ds.hn='".$hn."' ORDER BY hd.vdate asc";
$countnum = array();
            $conn_DB->imp_sql($sql);
            $rs = $conn_DB->select();
            $series['name']=$namecase;
for($i=0;$i<count($rs);$i++){
    $countnum[$i] = (int)$rs[$i]['name'];
    
    $series['data'] = $countnum;
     } 
     array_push($rslt, $series); 
    }
print json_encode($rslt);
$conn_DB->close_PDO();