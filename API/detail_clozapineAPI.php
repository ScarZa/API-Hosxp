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
    $sql="SELECT lh.hn,lh.order_date OrderDate
    ,TIMESTAMPDIFF(DAY,lh.order_date,NOW())day
    ,TIMESTAMPDIFF(month,lh.order_date,NOW())month
    #,(SELECT os.vstdate FROM opdscreen os WHERE os.hn=:hn and os.vstdate =OrderDate)vstdate
    ,(SELECT os.bw FROM opdscreen os WHERE os.hn=:hn and os.vstdate =OrderDate)bw
    ,(SELECT os.height FROM opdscreen os WHERE os.hn=:hn and os.vstdate =OrderDate)height
    ,(SELECT os.bmi FROM opdscreen os WHERE os.hn=:hn and os.vstdate =OrderDate)bmi
    ,(SELECT lo.lab_order_result*1000 FROM lab_order lo 
    inner join lab_head lh on lh.lab_order_number = lo.lab_order_number
    inner join lab_items li on li.lab_items_code = lo.lab_items_code 
    WHERE li.lab_items_code='255' and lh.hn=:hn and lh.order_date = OrderDate)WBC
    ,(SELECT lo.lab_order_result*1000 FROM lab_order lo 
    inner join lab_head lh on lh.lab_order_number = lo.lab_order_number
    inner join lab_items li on li.lab_items_code = lo.lab_items_code
    WHERE li.lab_items_code='256' and lh.hn=:hn and lh.order_date = OrderDate)Platelet
    ,(SELECT (lo.lab_order_result*WBC)/100 FROM lab_order lo 
    inner join lab_head lh on lh.lab_order_number = lo.lab_order_number
    inner join lab_items li on li.lab_items_code = lo.lab_items_code 
    WHERE li.lab_items_code='261' and lh.hn=:hn and lh.order_date = OrderDate)ANC
    FROM lab_order lo
    inner join lab_head lh on lh.lab_order_number = lo.lab_order_number
    inner join lab_items li on li.lab_items_code = lo.lab_items_code
    inner join opdscreen os on os.hn = lh.hn
    WHERE lo.lab_items_sub_group_code = '191'
    and lh.hn = :hn
    GROUP BY lh.lab_order_number order by lh.lab_order_number desc,os.vstdate desc limit 1";
    $conn_DB->imp_sql($sql);
    $execute=array(':hn'=>$data);
    $rslt=$conn_DB->select_a($execute);
}

//print_r($rslt);
$conv=new convers_encode();
//for($i=0;$i<count($rslt);$i++){
    $series['hn'] = $rslt['hn'];
    $series['month'] = $rslt['month'];
    $series['day'] = $rslt['day'];
    $series['OrderDate'] = DateThai1($rslt['OrderDate']);
    $series['bw'] = $rslt['bw'];
    $series['height'] = $rslt['height'];
    $series['bmi'] = $rslt['bmi'];
    $series['WBC'] = $rslt['WBC'];
    $series['Platelet'] = $rslt['Platelet'];
    $series['ANC'] = $rslt['ANC'];
    // $series['WBC'] = 2500;
    // $series['Platelet'] = 75000;
    // $series['ANC'] = 1200;
array_push($result, $series);    
//}
//print_r($result);
print json_encode($result);
$conn_DB->close_PDO();
?>