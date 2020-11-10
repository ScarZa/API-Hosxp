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
$conv=new convers_encode();
$read="../connection/conn_DB.txt";
$conn_DB->para_read($read);
$conn_DB->Read_Text();
$conn_DB->conn_PDO();
$result = array();
$series = array();
$data = isset($_POST['data'])?$_POST['data']:(isset($_GET['data'])?$_GET['data']:'');
    $sql="SELECT * FROM jvl_DocOPD WHERE doc_id = :doc_id";
    $conn_DB->imp_sql($sql);
    $execute=array(':doc_id'=>$data);
    $rslt=$conn_DB->select_a($execute);

//print_r($rslt);

//for($i=0;$i<count($rslt);$i++){
    $series['doc_note']=$conv->tis620_to_utf8( $rslt['doc_note']);
    $series['GA']=$conv->tis620_to_utf8( $rslt['GA']);
    $series['heent_chk'] = $rslt['heent_chk'];
    $series['heent'] = $conv->tis620_to_utf8( $rslt['heent']);
    $series['heart_chk'] = $rslt['heart_chk'];
    $series['heart'] = $conv->tis620_to_utf8( $rslt['heart']);
    $series['lung_chk'] = $rslt['lung_chk'];
    $series['lung'] = $conv->tis620_to_utf8( $rslt['lung']);
    $series['abd_chk'] = $rslt['abd_chk'];
    $series['abd'] = $conv->tis620_to_utf8( $rslt['abd']);
    $series['ext_chk'] = $rslt['ext_chk'];
    $series['ext'] = $conv->tis620_to_utf8( $rslt['ext']);
    $series['neuro_chk'] = $rslt['neuro_chk'];
    $series['neuro'] = $conv->tis620_to_utf8( $rslt['neuro']);
    $series['psych_chk'] = $rslt['psych_chk'];
    $series['psych'] = $conv->tis620_to_utf8( $rslt['psych']);
    $series['speech_chk'] = $rslt['speech_chk'];
    $series['speech'] = $conv->tis620_to_utf8( $rslt['speech']);
    $series['MA_chk'] = $rslt['MA_chk'];
    $series['MA_1'] = $rslt['MA_1'];
    $series['MA_2'] = $rslt['MA_2'];
    $series['FT_chk'] = $rslt['FT_chk'];
    $series['FT'] = $conv->tis620_to_utf8( $rslt['FT']);
    $series['CT_chk'] = $rslt['CT_chk'];
    $series['CT_1'] = $rslt['CT_1'];
    $series['CT_2'] = $rslt['CT_2'];
    $series['CT_3'] = $rslt['CT_3'];
    $series['FT'] = $conv->tis620_to_utf8( $rslt['FT']);
    $series['perception_chk'] = $rslt['perception_chk'];
    $series['percep_1'] = $rslt['percep_1'];
    $series['Halluc'] = $conv->tis620_to_utf8( $rslt['Halluc']);
    $series['percep_2'] = $rslt['percep_2'];
    $series['Illusion'] = $conv->tis620_to_utf8( $rslt['Illusion']);
    $series['percep_3'] = $rslt['percep_3'];
    $series['percep_4'] = $rslt['percep_4'];
    $series['good'] = $conv->tis620_to_utf8( $rslt['good']);
    $series['IJ_chk'] = $rslt['IJ_chk'];
    $series['SC_1'] = $rslt['SC_1'];
    $series['SC_2'] = $rslt['SC_2'];
    $series['SC_3'] = $rslt['SC_3'];
    $series['SC_4'] = $rslt['SC_4'];
    $series['Orientaion'] = $conv->tis620_to_utf8( $rslt['Orientaion']);
    $series['Gemeral'] = $conv->tis620_to_utf8( $rslt['Gemeral']);
    $series['Abstract'] = $conv->tis620_to_utf8( $rslt['Abstract']);
    $series['Attention'] = $conv->tis620_to_utf8( $rslt['Attention']);
    $series['progress_note'] = $conv->tis620_to_utf8( $rslt['progress_note']);
array_push($result, $series);    
//}
//print_r($result);
print json_encode($result);
$conn_DB->close_PDO();
?>