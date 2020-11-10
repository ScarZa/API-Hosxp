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
if ($method == 'add_ER') {
    $vn = $_POST['vn'];
    $hn = $_POST['hn'];
    $relative = isset($_POST['relative'])?$conv->utf8_to_tis620($_POST['relative']):'';
    $police_name = isset($_POST['police_name'])?$conv->utf8_to_tis620($_POST['police_name']):'';
    $weapon_chk = $conv->utf8_to_tis620($_POST['weapon_chk']);
    $weapon = isset($_POST['weapon'])?$conv->utf8_to_tis620($_POST['weapon']):'';
    $weaponer_chk = $conv->utf8_to_tis620($_POST['weaponER_chk']);
    $weaponer = isset($_POST['weaponER'])?$conv->utf8_to_tis620($_POST['weaponER']):'';
    $detain_chk = $conv->utf8_to_tis620($_POST['detain_chk']);
    $detain = isset($_POST['detain'])?$conv->utf8_to_tis620($_POST['detain']):'';
    $typeP_1 = isset($_POST['typeP_1'])?$_POST['typeP_1']:'';
    $typeP_2 = isset($_POST['typeP_2'])?$_POST['typeP_2']:'';
    $typeP_3 = isset($_POST['typeP_3'])?$_POST['typeP_3']:'';
    $typeP_4 = isset($_POST['typeP_4'])?$_POST['typeP_4']:'';
    $typeP_5 = isset($_POST['typeP_5'])?$_POST['typeP_5']:'';
    $typeP_6 = isset($_POST['typeP_6'])?$_POST['typeP_6']:'';
    $typeP_7 = isset($_POST['typeP_7'])?$_POST['typeP_7']:'';
    $smi4_chk = $conv->utf8_to_tis620($_POST['smi4_chk']);
    $smi4_1 = isset($_POST['smi4_1'])?$_POST['smi4_1']:'';
    $smi4_2 = isset($_POST['smi4_2'])?$_POST['smi4_2']:'';
    $smi4_3 = isset($_POST['smi4_3'])?$_POST['smi4_3']:'';
    $smi4_4 = isset($_POST['smi4_4'])?$_POST['smi4_4']:'';
    $lawpsych_chk = $conv->utf8_to_tis620($_POST['lawpsych_chk']);
    $lawpsych = isset($_POST['lawpsych'])?$conv->utf8_to_tis620($_POST['lawpsych']):'';
    $sleep_chk = $conv->utf8_to_tis620($_POST['sleep_chk']);
    $sleep = isset($_POST['sleep'])?$conv->utf8_to_tis620($_POST['sleep']):'';
    $IC_chk = $conv->utf8_to_tis620($_POST['IC_chk']);
    $IC = isset($_POST['IC'])?$conv->utf8_to_tis620($_POST['IC']):'';
    $med_chk = $conv->utf8_to_tis620($_POST['med_chk']);
    $med = isset($_POST['med'])?$conv->utf8_to_tis620($_POST['med']):'';
    $accident_chk = $conv->utf8_to_tis620($_POST['accident_chk']);
    $accident = isset($_POST['accident'])?$conv->utf8_to_tis620($_POST['accident']):'';
    $wound_chk = $conv->utf8_to_tis620($_POST['wound_chk']);
    $wound = isset($_POST['wound'])?$conv->utf8_to_tis620($_POST['wound']):'';
    $surgery_chk = $conv->utf8_to_tis620($_POST['surgery_chk']);
    $surgery = isset($_POST['surgery'])?$conv->utf8_to_tis620($_POST['surgery']):'';
    $complicate_chk = $conv->utf8_to_tis620($_POST['complicate_chk']);
    $complicate = isset($_POST['complicate'])?$conv->utf8_to_tis620($_POST['complicate']):'';
    $cigarette_chk = $conv->utf8_to_tis620($_POST['cigarette_chk']);
    $D_cigarette = isset($_POST['D_cigarette'])?$conv->utf8_to_tis620($_POST['D_cigarette']):'';
    $last_useC = isset($_POST['last_useC'])?$_POST['last_useC']:'';
    $alcohol_chk = $conv->utf8_to_tis620($_POST['alcohol_chk']);
    $alcohol_type = isset($_POST['alcohol_type'])?$_POST['alcohol_type']:'';
    $alcohol_vol = isset($_POST['alcohol_vol'])?$_POST['alcohol_vol']:'';
    $last_useA = isset($_POST['last_useA'])?$_POST['last_useA']:'';
    $dope_chk = $conv->utf8_to_tis620($_POST['dope_chk']);
    $dope_type = isset($_POST['dope_type'])?$_POST['dope_type']:'';
    $last_useD = isset($_POST['last_useD'])?$_POST['last_useD']:'';
    $marihuana_chk = $conv->utf8_to_tis620($_POST['marihuana_chk']);
    $D_marihuana = isset($_POST['D_marihuana'])?$conv->utf8_to_tis620($_POST['D_marihuana']):'';
    $last_useM = isset($_POST['last_useM'])?$conv->utf8_to_tis620($_POST['last_useM']):'';
    $ADL = $_POST['ADL'];
    $work = $_POST['work'];
    $menses_chk = isset($_POST['menses_chk'])?$conv->utf8_to_tis620($_POST['menses_chk']):'';
    $menses = isset($_POST['menses'])?$conv->utf8_to_tis620($_POST['menses']):'';
    $admit_chk = 'N';
    // $refer = isset($_POST['refer'])?$conv->utf8_to_tis620($_POST['refer']):'';
    // $admit = isset($_POST['income'])?$conv->utf8_to_tis620($_POST['income']):'';
    $recorder = $conv->utf8_to_tis620($_POST['user']);
    $recdate = date('Y-m-d H:i:s');


    $data = array($hn,$vn,$relative,$police_name,$weapon_chk,$weapon,$weaponer_chk,$weaponer,$detain_chk,$detain,$typeP_1,$typeP_2,$typeP_3,$typeP_4
    ,$typeP_5,$typeP_6,$typeP_7,$smi4_chk,$smi4_1,$smi4_2,$smi4_3,$smi4_4,$lawpsych_chk,$lawpsych,$sleep_chk,$sleep,$IC_chk,$IC,$med_chk,$med
    ,$accident_chk,$accident,$wound_chk,$wound,$surgery_chk,$surgery,$complicate_chk,$complicate,$cigarette_chk,$D_cigarette,$last_useC,$alcohol_chk,$alcohol_type,$alcohol_vol,$last_useA
    ,$dope_chk,$dope_type,$last_useD,$marihuana_chk,$D_marihuana,$last_useM,$ADL,$work,$menses_chk,$menses,$admit_chk,'','',$recdate,$recorder);
    //$field = array('id','hcode','vdate','vn','hn','sex','dob','pdx','dx0','dx1','dx2','dx3','cgis_score','clinic','user','dupdate');
    $table = "jvlER_regis";
    $ER_regis = $connDB->insert($table, $data);
    $res = array("messege"=>$ER_regis);
if($ER_regis===false){
    $res = array("messege"=>'ไม่สามารถบันทึกการบริการผู้ป่วยจิตเวชฉุกเฉิน ได้!!!!');
}else{
    $res = array("messege"=>'บันทึกการบริการผู้ป่วยจิตเวชฉุกเฉิน สำเร็จ!!!!',"id"=>$ER_regis);
}
    print json_encode($res);
    $connDB->close_PDO();
}elseif ($method == 'add_Admit') {
    $vn = $_POST['vn'];
    $hn = $_POST['hn'];
    $admit_chk = 'Y';
    $refer = isset($_POST['refer'])?$conv->utf8_to_tis620($_POST['refer']):'';
    $admit = isset($_POST['income'])?$conv->utf8_to_tis620($_POST['income']):'';
    $recorder = $conv->utf8_to_tis620($_POST['user']);
    $recdate = date('Y-m-d H:i:s');

    $data = array($admit_chk,$refer,$admit,$recdate,$recorder);
    $field = array("admit_chk","refer","admit","recdate","recorder");
    $table = "jvlER_regis";
    $where="vn=:vn";
    $execute=array(':vn' => $vn);
    $add_admit = $connDB->update($table, $data, $where, $field, $execute);

    if($add_admit===false){
        $res = array("messege"=>'ไม่สามารถบันทึกการ Admit ได้!!!!');
    }else{
        $res = array("messege"=>'บันทึกการ Admit สำเร็จ!!!!');
    }
        print json_encode($res);
        $connDB->close_PDO();
    }