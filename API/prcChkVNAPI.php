<?php
header('Content-type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Allow-Credentials: true");
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

function insert_date($take_date_conv) {
    $take_date = explode("-", $take_date_conv);
    $take_date_year = @$take_date[2] - 543;
    $take_date = "$take_date_year-" . @$take_date[1] . "-" . @$take_date[0] . "";
    return $take_date;
}
$conv=new convers_encode();
//$method = isset($_POST['method']) ? $_POST['method'] : $_GET['method'];
//if ($method == 'add_culture') {
        $vn = $_POST['vn'];
        $data = array($vn);
        $table = "jvl_vnchk";
        $culture = $connDB->insert($table, $data);
    if($culture===false){
        $res = array("messege"=>'not complate!!!!');
    }else{
        $res = array("messege"=>'VN Chk OK!!!!');
    }
        print json_encode($res);
        $connDB->close_PDO();
//}