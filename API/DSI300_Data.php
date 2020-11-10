<?php
session_save_path("../session/");
header('Content-type: text/json; charset=utf-8');

function __autoload($class_name) {
    include '../class/' . $class_name . '.php';
}
include '../function/string_to_ascii.php';
set_time_limit(0);
$connDB = new EnDeCode();
$read = "../connection/conn_DB.txt";
$connDB->para_read($read);
$connDB->Read_Text();
$connDB->conn_PDO();
$rslt = array();
$series = array();
$data = isset($_POST['data'])?$_POST['data']:(isset($_GET['data'])?$_GET['data']:'');
$conv=new convers_encode();
for($ii=1;$ii<=5;$ii++){ 
$sql = "SELECT dsi.dsi_id,ag.ag_name,ag.ag_month,skg.skg_name,dsi.skill_group,skg.skg_detail,dsi.dsi_name
FROM jvl_result_dsi300 dsi
inner join jvl_skillgroup skg on skg.skg_id = dsi.skill_group
inner join jvl_agegroup ag on ag.ag_id = dsi.age_group
where dsi.skill_group =".$ii." and dsi.age_group = ".$data;

    $connDB->imp_sql($sql);
    $user = $connDB->select();
      //if($ii-1 == $user[$ii-1]['skill_group']){
        $series['ag_name'] = $conv->tis620_to_utf8($user[$ii-1]['ag_name']);
        $series['skg_name'] = $conv->tis620_to_utf8($user[$ii-1]['skg_name']);
        $series['ag_month'] = $conv->tis620_to_utf8($user[$ii-1]['ag_month']);
        $series['skg_detail'] = $conv->tis620_to_utf8($user[$ii-1]['skg_detail']);
        for($i=0;$i<count($user);$i++){
          $series[$i]['dsi_id'] = $conv->tis620_to_utf8($user[$i]['dsi_id']);
          $series[$i]['dsi_name'] = $conv->tis620_to_utf8($user[$i]['dsi_name']);
          
      }
      array_push($rslt, $series);
      }
      
    //}
    
    //print_r($rslt);
    print json_encode($rslt);
$connDB->close_PDO();
?>