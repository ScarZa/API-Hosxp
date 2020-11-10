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
$method = isset($_POST['method']) ? $_POST['method'] : $_GET['method'];
if ($method == 'add_MMSE') {
       
        $vn = $_POST['vn'];
        $hn = $_POST['hn'];
        $education = $_POST['education'];
        $Q1 = isset($_POST['Q1'])?$_POST['Q1']:0;
        $Q2 = isset($_POST['Q2'])?$_POST['Q2']:0;
        $Q3 = isset($_POST['Q3'])?$_POST['Q3']:0;
        $Q4 = isset($_POST['Q4'])?$_POST['Q4']:0;
        $Q5 = isset($_POST['Q5'])?$_POST['Q5']:0;
        $Q6 = isset($_POST['Q6'])?$_POST['Q6']:0;
        $Q7 = isset($_POST['Q7'])?$_POST['Q7']:0;
        $Q8 = isset($_POST['Q8'])?$_POST['Q8']:0;
        $Q9 = isset($_POST['Q9'])?$_POST['Q9']:0;
        $Q10 = isset($_POST['Q10'])?$_POST['Q10']:0;
        $Q11 = isset($_POST['Q11'])?$_POST['Q11']:0;
        $Q12 = isset($_POST['Q12'])?$_POST['Q12']:0;
        $Q13 = isset($_POST['Q13'])?$_POST['Q13']:0;
        $Q14 = isset($_POST['Q14'])?$_POST['Q14']:0;
        $Q15 = isset($_POST['Q15'])?$_POST['Q15']:0;
        $Q16 = isset($_POST['Q16'])?$_POST['Q16']:0;
        $Q17 = isset($_POST['Q17'])?$_POST['Q17']:0;
        $Q18 = isset($_POST['Q18'])?$_POST['Q18']:0;
        $Q19 = isset($_POST['Q19'])?$_POST['Q19']:0;
        $Q20 = isset($_POST['Q20'])?$_POST['Q20']:0;
        $Q21 = isset($_POST['Q21'])?$_POST['Q21']:0;
        $Q22 = isset($_POST['Q22'])?$_POST['Q22']:0;
        $Q23 = isset($_POST['Q23'])?$_POST['Q23']:0;
        $Q24 = isset($_POST['Q24'])?$_POST['Q24']:0;
        $Q25 = isset($_POST['Q25'])?$_POST['Q25']:0;
        $Q26 = isset($_POST['Q26'])?$_POST['Q26']:0;
        $Q27 = isset($_POST['Q27'])?$_POST['Q27']:0;
        $Q28 = isset($_POST['Q28'])?$_POST['Q28']:0;
        $Q29 = isset($_POST['Q29'])?$_POST['Q29']:0;
        $Q30 = isset($_POST['Q30'])?$_POST['Q30']:0;
        $total = isset($_POST['total'])?$_POST['total']:0;
        $recdate = date('Y-m-d H:i:s');
        $recorder = $conv->utf8_to_tis620($_POST['recorder']);
        $user = $conv->utf8_to_tis620($_POST['user']);

        $data = array($hn,$vn,$education,$Q1,$Q2,$Q3,$Q4,$Q5,$Q6,$Q7,$Q8,$Q9,$Q10,$Q11,$Q12,$Q13,$Q14
                    ,$Q15,$Q16,$Q17,$Q18,$Q19,$Q20,$Q21,$Q22,$Q23,$Q24,$Q25,$Q26,$Q27,$Q28,$Q29,$Q30,$total,$recdate,$recorder,$user);
        $table = "jvl_mmse";
        $field = array('hn','vn','education','Q1','Q2','Q3','Q4','Q5','Q6','Q7','Q8','Q9','Q10'
        ,'Q11','Q12','Q13','Q14','Q15','Q16','Q17','Q18','Q19','Q20','Q21','Q22','Q23','Q24','Q25','Q26','Q27','Q28','Q29','Q30','total','recdate','recorder','user');
        $MMSE = $connDB->insert($table, $data,$field);
        if($MMSE===false){
            $res = array("messege"=>'ไม่สามารถบันทึก MMSE ได้!!!!');
        }else{
            $res = array("messege"=>'บันทึก MMSE สำเร็จ!!!!');
            }
        print json_encode($res);
        $connDB->close_PDO();
    }