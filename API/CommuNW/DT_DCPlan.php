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
$conv=new convers_encode();
$read = "../../connection/conn_DB.txt";
$conn_DB->para_read($read);
$conn_db = $conn_DB->Read_Text();
$conn_DB->conn_PDO();
set_time_limit(0);
$rslt = array();
$series = array();
$data = isset($_POST['data1'])?$_POST['data1']:(isset($_GET['data1'])?$_GET['data1']:'');
$data2 = isset($_POST['data2'])?$_POST['data2']:(isset($_GET['data2'])?$_GET['data2']:'');
if(!empty($data)){
  $data =$conv->utf8_to_tis620($data);
    $code = "WHERE (a.an like '%".$data."%' or p.fname like '%".$data."%' or p.lname like '%".$data."%' or a.hn like '%".$data."%') and !ISNULL(a.dchdate)";
}else{
    $code ='';
}
$sql="select a.an,a.hn,a.regdate,p.cid,CONCAT(p.pname,p.fname,' ',p.lname)fullname,p.informaddr from an_stat a 
inner join patient p on a.hn=p.hn
inner join jvl_ipd_first_rec ifr on ifr.an = a.an ".$code ; 
$conn_DB->imp_sql($sql);
    $num_risk = $conn_DB->select();
    
    for($i=0;$i<count($num_risk);$i++){
      $series['an'] = $num_risk[$i]['an'];
      $series['hn'] = $num_risk[$i]['hn'];
      $series['regdate'] = DateThai1($num_risk[$i]['regdate']);
      $series['cid']= $num_risk[$i]['cid'];
      $series['fullname'] = $conv->tis620_to_utf8($num_risk[$i]['fullname']);
      $series['informaddr']= $conv->tis620_to_utf8($num_risk[$i]['informaddr']);
      array_push($rslt, $series);    
      }
print json_encode($rslt);
$conn_DB->close_PDO();