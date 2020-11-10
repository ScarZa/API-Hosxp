<?php 
session_save_path("../session/");
//session_start(); 
header('Content-type: text/json; charset=utf-8');
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Headers: access");
// header("Access-Control-Allow-Methods: GET,POST");
// header("Access-Control-Allow-Credentials: true");
// header('Content-Type: application/json;charset=utf-8');


function __autoload($class_name) {
    include '../class/' . $class_name . '.php';
}
include_once ('../plugins/funcDateThai.php');
set_time_limit(0);
$conn_DB= new EnDeCode();
$read="../connection/conn_DB.txt";
$conn_DB->para_read($read);
$conn_DB->Read_Text();
$conn_DB->conn_PDO();
$result = array();
$series = array();
$data = isset($_POST['data'])?$_POST['data']:(isset($_GET['data'])?$_GET['data']:'');
$data2 = isset($_POST['data2'])?$_POST['data2']:(isset($_GET['data2'])?$_GET['data2']:'');
if(!empty($data2)){
    $sql="select p.hn,p.pname,p.fname,p.lname,p.informaddr,p.cid,p.birthday,m.name as mrname,a.an,a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5
    from patient p 
    LEFT OUTER JOIN an_stat a ON a.hn=p.hn
    left outer join marrystatus m on p.marrystatus=m.code 
    where a.an= :an";
    $conn_DB->imp_sql($sql);
    $execute=array(':an'=>$data2);
    $rslt=$conn_DB->select_a($execute);
}else {
    $sql="SELECT lh.hn,p.sex
    ,(SELECT lh.order_date FROM lab_order lo 
    inner join lab_head lh on lh.lab_order_number = lo.lab_order_number
    inner join lab_items li on li.lab_items_code = lo.lab_items_code 
    WHERE li.lab_items_code='293' and lh.hn=:hn and !ISNULL(lo.lab_order_result) order by lh.order_date desc limit 1)albumin_date
    ,(SELECT TIMESTAMPDIFF(month,albumin_date,NOW()))albumin_month
    ,(SELECT lo.lab_order_result FROM lab_order lo 
    inner join lab_head lh on lh.lab_order_number = lo.lab_order_number
    inner join lab_items li on li.lab_items_code = lo.lab_items_code 
    WHERE li.lab_items_code='293' and lh.hn=:hn and !ISNULL(lo.lab_order_result) order by lh.order_date desc limit 1)albumin
    ,(SELECT lo.lab_order_result FROM lab_order lo 
    inner join lab_head lh on lh.lab_order_number = lo.lab_order_number
    inner join lab_items li on li.lab_items_code = lo.lab_items_code 
    WHERE li.lab_items_code='294' and lh.hn=:hn and !ISNULL(lo.lab_order_result) order by lh.order_date desc limit 1)AST
    ,(SELECT lo.lab_order_result FROM lab_order lo 
    inner join lab_head lh on lh.lab_order_number = lo.lab_order_number
    inner join lab_items li on li.lab_items_code = lo.lab_items_code 
    WHERE li.lab_items_code='295' and lh.hn=:hn and !ISNULL(lo.lab_order_result) order by lh.order_date desc limit 1)ALT
    ,(SELECT lo.lab_order_result FROM lab_order lo 
    inner join lab_head lh on lh.lab_order_number = lo.lab_order_number
    inner join lab_items li on li.lab_items_code = lo.lab_items_code 
    WHERE li.lab_items_code='130' and lh.hn=:hn and !ISNULL(lo.lab_order_result) order by lh.order_date desc limit 1)ALP
    ,(SELECT lo.lab_order_result FROM lab_order lo 
    inner join lab_head lh on lh.lab_order_number = lo.lab_order_number
    inner join lab_items li on li.lab_items_code = lo.lab_items_code 
    WHERE li.lab_items_code='297' and lh.hn=:hn and !ISNULL(lo.lab_order_result) order by lh.order_date desc limit 1)total
    ,(SELECT lo.lab_order_result FROM lab_order lo 
    inner join lab_head lh on lh.lab_order_number = lo.lab_order_number
    inner join lab_items li on li.lab_items_code = lo.lab_items_code 
    WHERE li.lab_items_code='298' and lh.hn=:hn and !ISNULL(lo.lab_order_result) order by lh.order_date desc limit 1)direct
    FROM lab_order lo 
    inner join lab_head lh on lh.lab_order_number = lo.lab_order_number
    inner join patient p on p.hn=lh.hn
    WHERE lh.hn = :hn
    GROUP BY lh.hn;";
    $conn_DB->imp_sql($sql);
    $execute=array(':hn'=>$data);
    $rslt=$conn_DB->select_a($execute);
}

//print_r($rslt);
$conv=new convers_encode();
//for($i=0;$i<count($rslt);$i++){
    $series['hn'] = $rslt['hn'];
    $series['sex'] = $rslt['sex'];
    $series['albumin_date'] = isset($rslt['albumin_date'])?DateThai1($rslt['albumin_date']):'';
    $series['albumin_month'] = $rslt['albumin_month'];
    $series['albumin'] = isset($rslt['albumin'])?$rslt['albumin']:'';
    $series['AST'] = isset($rslt['AST'])?$rslt['AST']:'';
    $series['ALT'] = isset($rslt['ALT'])?$rslt['ALT']:'';
    $series['ALP'] = isset($rslt['ALP'])?$rslt['ALP']:'';
    $series['total'] = isset($rslt['total'])?$rslt['total']:'';
    $series['direct'] = isset($rslt['direct'])?$rslt['direct']:'';
array_push($result, $series);    
//}
//print_r($result);
print json_encode($result);
$conn_DB->close_PDO();
?>