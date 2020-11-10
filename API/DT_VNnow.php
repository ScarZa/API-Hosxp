<?php
header('Content-type: text/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Allow-Credentials: true");

function __autoload($class_name) {
    include '../class/' . $class_name . '.php';
}
include_once '../plugins/function_date.php';
include_once '../plugins/funcDateThai.php';
$conn_DB = new EnDeCode();
$read = "../connection/conn_DB.txt";
$conn_DB->para_read($read);
$conn_db = $conn_DB->Read_Text();
$conn_DB->conn_PDO();
set_time_limit(0);
$rslt = array();
$series = array();
$data = isset($_POST['data1'])?$_POST['data1']:(isset($_GET['data1'])?$_GET['data1']:'');
$sql="SELECT 
#v.lastvisit_vn, 
v.vn,p.hn,concat(p.fname,' ',p.lname)fullname,ov.vsttime
FROM vn_stat v
inner join patient p on p.hn = v.hn
inner join ovst ov on ov.vn = v.vn
left join jvl_vnchk chk on chk.vn = v.vn
WHERE v.vstdate = SUBSTR(NOW(),1,10) and v.lastvisit_vn!='' and ISNULL(chk.vn)
ORDER BY v.vn desc"; 
$conn_DB->imp_sql($sql);
    $num_risk = $conn_DB->select();
    $conv=new convers_encode();
    for($i=0;$i<count($num_risk);$i++){
    //$series['lastvisit_vn']= $num_risk[$i]['lastvisit_vn'];
    $series['vn']= $num_risk[$i]['vn'];
    $series['hn']= $num_risk[$i]['hn'];
    $series['fullname'] = $conv->tis620_to_utf8($num_risk[$i]['fullname']);
    $series['vsttime']= $num_risk[$i]['vsttime'];
    array_push($rslt, $series);    
    }
print json_encode($rslt);
$conn_DB->close_PDO();