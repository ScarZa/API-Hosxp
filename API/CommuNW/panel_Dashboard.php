<?php 
header('Content-type: text/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Allow-Credentials: true");

function __autoload($class_name) {
    include '../../class/' . $class_name . '.php';
}
include_once ('../../plugins/funcDateThai.php');
set_time_limit(0);
$conn_DB= new EnDeCode();
$read="../../connection/conn_DB.txt";
$conn_DB->para_read($read);
$conn_DB->Read_Text();
$conn_DB->conn_PDO();
$result = array();
$series = array();
$data = isset($_POST['data'])?$_POST['data']:(isset($_GET['data'])?$_GET['data']:'');
$data2 = isset($_POST['data2'])?$_POST['data2']:(isset($_GET['data2'])?$_GET['data2']:'');
// if(empty($data2)){
//     $sql1 = "SELECT an
//     FROM an_stat 
//     WHERE vn = :vn";
//     $conn_DB->imp_sql($sql1);
//     $execute=array(':vn' => $data);
//     $rslt=$conn_DB->select_a($execute);
//     $data2 = empty($rslt['an'])?'':$rslt['an'];
// }
$sql="SELECT count(hn)sum
FROM patient p
WHERE p.chwpart = ".$data." and p.amppart = ".$data2;

$sql1="SELECT count(hn)sum
FROM patient p
WHERE p.chwpart = ".$data." and p.amppart = ".$data2;

$sql2="SELECT count(p.hn)sum
FROM patient p
inner join an_stat a on a.hn = p.hn
WHERE (p.chwpart = ".$data." and p.amppart = ".$data2.") and ISNULL(a.dchdate)";

$sql3="SELECT count(DISTINCT p.hn)sum
FROM patient p
inner join an_stat a on a.hn = p.hn
WHERE (p.chwpart = ".$data." and p.amppart = ".$data2.") and !ISNULL(a.dchdate) ORDER BY p.hn";

$conn_DB->imp_sql($sql1);
// $execute=array(':vn' => $data,':an'=>$data2);
//$execute=array(':vn' => $data);
$rslt1=$conn_DB->select_a();

$conn_DB->imp_sql($sql2);
// $execute=array(':vn' => $data,':an'=>$data2);
//$execute=array(':vn' => $data);
$rslt2=$conn_DB->select_a();

$conn_DB->imp_sql($sql3);
// $execute=array(':vn' => $data,':an'=>$data2);
//$execute=array(':vn' => $data);
$rslt3=$conn_DB->select_a();
//print_r($rslt);
$conv=new convers_encode();
    $series['total'] = $rslt1['sum'];
    $series['admit'] = $rslt2['sum'];
    $series['follow_up'] = $rslt3['sum'];
//array_push($result, $series);    
//print_r($result);
print json_encode($series);
$conn_DB->close_PDO();
?>