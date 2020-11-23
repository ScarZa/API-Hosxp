<?php
header('Content-type: text/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Allow-Credentials: true");

function __autoload($class_name) {
    include '../../class/' . $class_name . '.php';
}
include_once '../../plugins/function_date.php';
include_once '../../plugins/funcDateThai.php';
$conn_DB = new EnDeCode();
$read = "../../connection/conn_DB.txt";
$conn_DB->para_read($read);
$conn_db = $conn_DB->Read_Text();
$conn_DB->conn_PDO();
set_time_limit(0);
$rslt = array();
$series = array();
$data = isset($_POST['data1'])?$_POST['data1']:(isset($_GET['data1'])?$_GET['data1']:'');
$data2 = isset($_POST['data2'])?$_POST['data2']:(isset($_GET['data2'])?$_GET['data2']:'');
$sql="SELECT DISTINCT p.cid,p.hn hn_se
,(SELECT an FROM an_stat WHERE hn=hn_se ORDER BY an desc limit 1)an
,concat(p.fname,' ',p.lname)fullname,t3.name tambon,t2.name ampher,t1.name changwat
,a.dchdate
FROM patient p
inner join an_stat a on a.hn = p.hn
left outer join thaiaddress t1 on t1.chwpart=p.chwpart and
         t1.amppart='00' and t1.tmbpart='00'
left outer join thaiaddress t2 on t2.chwpart=p.chwpart and
         t2.amppart=p.amppart and t2.tmbpart='00'
left outer join thaiaddress t3 on t3.chwpart=p.chwpart and
         t3.amppart=p.amppart and t3.tmbpart=p.tmbpart
WHERE (p.chwpart = ".$data." and p.amppart = ".$data2.") and !ISNULL(a.dchdate) GROUP BY p.cid
 ORDER BY a.an desc;"; 
$conn_DB->imp_sql($sql);
    $num_risk = $conn_DB->select();
    $conv=new convers_encode();
    
    for($i=0;$i<count($num_risk);$i++){
      $series['an']= $num_risk[$i]['an'];
      $count = strlen($num_risk[$i]['cid']) - 7;
      $sensorCID = substr_replace($num_risk[$i]['cid'], str_repeat('*', $count), 7, $count);
    $series['cid']= $sensorCID;
    
    $fullname = explode(" ", $conv->tis620_to_utf8($num_risk[$i]['fullname']));
    //$countfname = strlen($fullname[0]);
    $sensorfname = substr_replace($fullname[0], str_repeat('*', 7), 0);
    $series['fullname'] = $sensorfname.'  '.$fullname[1];
    $series['informaddr']= ' ต.'. $conv->tis620_to_utf8( $num_risk[$i]['tambon']).' อ.'. $conv->tis620_to_utf8( $num_risk[$i]['ampher']).' จ.'. $conv->tis620_to_utf8( $num_risk[$i]['changwat']);
    $series['dchdate'] = DateThai1($num_risk[$i]['dchdate']);
    array_push($rslt, $series);    
    }
print json_encode($rslt);
$conn_DB->close_PDO();