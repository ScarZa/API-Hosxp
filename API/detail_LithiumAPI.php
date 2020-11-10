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
    WHERE li.lab_items_code='683' and lh.hn=:hn and !ISNULL(lo.lab_order_result) order by lh.order_date desc limit 1)LithiumLevel_date
    ,(SELECT TIMESTAMPDIFF(month,LithiumLevel_date,NOW()))LithiumLevel_month
    ,(SELECT lo.lab_order_result FROM lab_order lo 
    inner join lab_head lh on lh.lab_order_number = lo.lab_order_number
    inner join lab_items li on li.lab_items_code = lo.lab_items_code 
    WHERE li.lab_items_code='683' and lh.hn=:hn and !ISNULL(lo.lab_order_result) order by lh.order_date desc limit 1)LithiumLevel
    ,(SELECT lh.order_date FROM lab_order lo 
    inner join lab_head lh on lh.lab_order_number = lo.lab_order_number
    inner join lab_items li on li.lab_items_code = lo.lab_items_code 
    WHERE li.lab_items_code='115' and lh.hn=:hn and !ISNULL(lo.lab_order_result) order by lh.order_date desc limit 1)BUN_date
    ,(SELECT TIMESTAMPDIFF(month,BUN_date,NOW()))BUN_month
    ,(SELECT lo.lab_order_result FROM lab_order lo 
    inner join lab_head lh on lh.lab_order_number = lo.lab_order_number
    inner join lab_items li on li.lab_items_code = lo.lab_items_code 
    WHERE li.lab_items_code='115' and lh.hn=:hn and !ISNULL(lo.lab_order_result) order by lh.order_date desc limit 1)BUN
    ,(SELECT lh.order_date FROM lab_order lo 
    inner join lab_head lh on lh.lab_order_number = lo.lab_order_number
    inner join lab_items li on li.lab_items_code = lo.lab_items_code 
    WHERE li.lab_items_code='114' and lh.hn=:hn and !ISNULL(lo.lab_order_result) order by lh.order_date desc limit 1)Cr_date
    ,(SELECT TIMESTAMPDIFF(month,Cr_date,NOW()))Cr_month
    ,(SELECT lo.lab_order_result FROM lab_order lo 
    inner join lab_head lh on lh.lab_order_number = lo.lab_order_number
    inner join lab_items li on li.lab_items_code = lo.lab_items_code 
    WHERE li.lab_items_code='114' and lh.hn=:hn and !ISNULL(lo.lab_order_result) order by lh.order_date desc limit 1)Cr
    ,(SELECT lo.lab_order_result FROM lab_order lo 
    inner join lab_head lh on lh.lab_order_number = lo.lab_order_number
    inner join lab_items li on li.lab_items_code = lo.lab_items_code 
    WHERE li.lab_items_code='709' and lh.hn=:hn and !ISNULL(lo.lab_order_result) order by lh.order_date desc limit 1)eGFR
    ,(SELECT lh.order_date FROM lab_order lo 
    inner join lab_head lh on lh.lab_order_number = lo.lab_order_number
    inner join lab_items li on li.lab_items_code = lo.lab_items_code 
    WHERE li.lab_items_code='186' and lh.hn=:hn and !ISNULL(lo.lab_order_result) order by lh.order_date desc limit 1)TSH_date
    ,(SELECT TIMESTAMPDIFF(month,TSH_date,NOW()))TSH_month
    ,(SELECT lo.lab_order_result FROM lab_order lo 
    inner join lab_head lh on lh.lab_order_number = lo.lab_order_number
    inner join lab_items li on li.lab_items_code = lo.lab_items_code 
    WHERE li.lab_items_code='186' and lh.hn=:hn and !ISNULL(lo.lab_order_result) order by lh.order_date desc limit 1)TSH
    ,(SELECT lo.lab_order_result FROM lab_order lo 
    inner join lab_head lh on lh.lab_order_number = lo.lab_order_number
    inner join lab_items li on li.lab_items_code = lo.lab_items_code 
    WHERE li.lab_items_code='187' and lh.hn=:hn and !ISNULL(lo.lab_order_result) order by lh.order_date desc limit 1)FT3
    ,(SELECT lo.lab_order_result FROM lab_order lo 
    inner join lab_head lh on lh.lab_order_number = lo.lab_order_number
    inner join lab_items li on li.lab_items_code = lo.lab_items_code 
    WHERE li.lab_items_code='188' and lh.hn=:hn and !ISNULL(lo.lab_order_result) order by lh.order_date desc limit 1)FT4
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
    $series['LithiumLevel_date'] = isset($rslt['LithiumLevel_date'])?DateThai1($rslt['LithiumLevel_date']):'';
    $series['LithiumLevel_month'] = $rslt['LithiumLevel_month'];
    $series['LithiumLevel'] = isset($rslt['LithiumLevel'])?$rslt['LithiumLevel']:'';
    $series['BUN_date'] = isset($rslt['BUN_date'])?DateThai1($rslt['BUN_date']):'';
    $series['BUN_month'] = $rslt['BUN_month'];
    $series['BUN'] = isset($rslt['BUN'])?$rslt['BUN']:'';
    $series['Cr_date'] = isset($rslt['Cr_date'])?DateThai1($rslt['Cr_date']):'';
    $series['Cr_month'] = $rslt['Cr_month'];
    $series['Cr'] = isset($rslt['Cr'])?$rslt['Cr']:'';
    $series['eGFR'] = isset($rslt['eGFR'])?$rslt['eGFR']:'';
    $series['TSH_date'] = isset($rslt['TSH_date'])?DateThai1($rslt['TSH_date']):'';
    $series['TSH_month'] = $rslt['TSH_month'];
    $series['TSH'] = isset($rslt['TSH'])?$rslt['TSH']:'';
    $series['FT3'] = isset($rslt['FT3'])?$rslt['FT3']:'';
    $series['FT4'] = isset($rslt['FT4'])?$rslt['FT4']:'';
    // $series['WBC'] = 2500;
    // $series['Platelet'] = 75000;
    // $series['ANC'] = 1200;
array_push($result, $series);    
//}
//print_r($result);
print json_encode($result);
$conn_DB->close_PDO();
?>