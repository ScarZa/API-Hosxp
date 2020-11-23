<?php
header('Content-type: text/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Allow-Credentials: true");

function __autoload($class_name) {
    include '../../class/' . $class_name . '.php';
}
include '../../plugins/funcDateThai.php';
$conn_DB = new EnDeCode();
$conv=new convers_encode();
$read = "../../connection/conn_DB.txt";
$conn_DB->para_read($read);
$conn_db = $conn_DB->Read_Text();
$conn_DB->conn_PDO();
$rslt = array();
$series = array();
//$data1 = isset($_POST['data1'])?$_POST['data1']:$_GET['data1'];
$data = isset($_POST['data1'])?$_POST['data1']:(isset($_GET['data1'])?$_GET['data1']:'');
$sql = "SELECT concat(di.name,' ',di.strength)drugName,du.shortlist ,concat(op.qty,' ',di.units)qty,op.sum_price
FROM opitemrece op 
inner join ovst o1 on op.hn = o1.hn 
inner join drugitems di on di.icode = op.icode 
inner join drugusage du on du.drugusage = op.drugusage
WHERE op.vn = '".$data."' and op.income = 03 GROUP BY drugName";

$conn_DB->imp_sql($sql);
$num_risk = $conn_DB->select();
for($i=0;$i<count($num_risk);$i++){
    $series['drugName'] = $conv->tis620_to_utf8($num_risk[$i]['drugName']);
    $series['shortlist'] = $conv->tis620_to_utf8($num_risk[$i]['shortlist']);
    $series['qty'] = $conv->tis620_to_utf8($num_risk[$i]['qty']);
    $series['sum_price'] = round($num_risk[$i]['sum_price'],2);
array_push($rslt, $series);    
}
    print json_encode($rslt);
$conn_DB->close_PDO();
?>