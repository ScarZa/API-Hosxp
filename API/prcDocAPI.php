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
if ($method == 'add_doc01') {
    $vn = $_POST['vn'];
    $hn = $_POST['hn'];
    $doc_note = isset($_POST['doc_note'])?$conv->utf8_to_tis620($_POST['doc_note']):'';
    $GA = isset($_POST['GA'])?$conv->utf8_to_tis620($_POST['GA']):'';
    $heent_chk = $conv->utf8_to_tis620($_POST['heent_chk']);
    $heent = isset($_POST['heent'])?$conv->utf8_to_tis620($_POST['heent']):'';
    $heart_chk = $conv->utf8_to_tis620($_POST['heart_chk']);
    $heart = isset($_POST['heart'])?$conv->utf8_to_tis620($_POST['heart']):'';
    $lung_chk = $conv->utf8_to_tis620($_POST['lung_chk']);
    $lung = isset($_POST['lung'])?$conv->utf8_to_tis620($_POST['lung']):'';
    $abd_chk = $conv->utf8_to_tis620($_POST['abd_chk']);
    $abd = isset($_POST['abd'])?$conv->utf8_to_tis620($_POST['abd']):'';
    $ext_chk = $conv->utf8_to_tis620($_POST['ext_chk']);
    $ext = isset($_POST['ext'])?$conv->utf8_to_tis620($_POST['ext']):'';
    $neuro_chk = $conv->utf8_to_tis620($_POST['neuro_chk']);
    $neuro = isset($_POST['neuro'])?$conv->utf8_to_tis620($_POST['neuro']):'';
    $psych_chk = $conv->utf8_to_tis620($_POST['psych_chk']);
    $psych = isset($_POST['psych'])?$conv->utf8_to_tis620($_POST['psych']):'';
    $speech_chk = $conv->utf8_to_tis620($_POST['speech_chk']);
    $speech = isset($_POST['speech'])?$conv->utf8_to_tis620($_POST['speech']):'';
    $MA_chk = $conv->utf8_to_tis620($_POST['MA_chk']);
    $MA_1 = isset($_POST['MA_1'])?$_POST['MA_1']:'';
    $MA_2 = isset($_POST['MA_2'])?$_POST['MA_2']:'';
    $FT_chk = $conv->utf8_to_tis620($_POST['FT_chk']);
    $FT = isset($_POST['FT'])?$conv->utf8_to_tis620($_POST['FT']):'';
    $CT_chk = $conv->utf8_to_tis620($_POST['CT_chk']);
    $CT_1 = isset($_POST['CT_1'])?$_POST['CT_1']:'';
    $CT_2 = isset($_POST['CT_2'])?$_POST['CT_2']:'';
    $CT_3 = isset($_POST['CT_3'])?$_POST['CT_3']:'';
    $perception_chk = $conv->utf8_to_tis620($_POST['perception_chk']);
    $percep_1 = isset($_POST['percep_1'])?$_POST['percep_1']:'';
    $Halluc = isset($_POST['Halluc'])?$conv->utf8_to_tis620($_POST['Halluc']):'';
    $percep_2 = isset($_POST['percep_2'])?$_POST['percep_2']:'';
    $Illusion = isset($_POST['Illusion'])?$conv->utf8_to_tis620($_POST['Illusion']):'';
    $percep_3 = isset($_POST['percep_3'])?$_POST['percep_3']:'';
    $percep_4 = isset($_POST['percep_4'])?$_POST['percep_4']:'';
    $IJ_chk = isset($_POST['IJ_chk'])?$_POST['IJ_chk']:'';
    $good = isset($_POST['good'])?$conv->utf8_to_tis620($_POST['good']):'';
    $SC_1 = isset($_POST['SC_1'])?$_POST['SC_1']:'';
    $SC_2 = isset($_POST['SC_2'])?$_POST['SC_2']:'';
    $SC_3 = isset($_POST['SC_3'])?$_POST['SC_3']:'';
    $SC_4 = isset($_POST['SC_4'])?$_POST['SC_4']:'';
    $Orientaion = isset($_POST['Orientaion'])?$conv->utf8_to_tis620($_POST['Orientaion']):'';
    $Gemeral = isset($_POST['Gemeral'])?$conv->utf8_to_tis620($_POST['Gemeral']):'';
    $Abstract = isset($_POST['Abstract'])?$conv->utf8_to_tis620($_POST['Abstract']):'';
    $Attention = isset($_POST['Attention'])?$conv->utf8_to_tis620($_POST['Attention']):'';
    $progress_note = isset($_POST['progress_note'])?$conv->utf8_to_tis620($_POST['progress_note']):'';
    $recorder = $conv->utf8_to_tis620($_POST['user']);
    $recdate = date('Y-m-d H:i:s');


    $data = array($hn,$vn,$doc_note,$GA,$heent_chk,$heent,$heart_chk,$heart,$lung_chk,$lung,$abd_chk,$abd
    ,$ext_chk,$ext,$neuro_chk,$neuro,$psych_chk,$psych,$speech_chk,$speech,$MA_chk,$MA_1,$MA_2,$FT_chk,$FT,$CT_chk,$CT_1
    ,$CT_2,$CT_3,$perception_chk,$percep_1,$Halluc,$percep_2,$Illusion,$percep_3,$percep_4,$IJ_chk,$good,$SC_1,$Orientaion,$SC_2,$Gemeral
    ,$SC_3,$Abstract,$SC_4,$Attention,$progress_note,$recdate,$recorder);
    //$field = array('id','hcode','vdate','vn','hn','sex','dob','pdx','dx0','dx1','dx2','dx3','cgis_score','clinic','user','dupdate');
    $table = "jvl_DocOPD";
    $DocOPD = $connDB->insert($table, $data);
    $res = array("messege"=>$DocOPD);
if($DocOPD===false){
    $res = array("messege"=>'ไม่สามารถบันทึกประวัติการักษา ได้!!!!');
}else{
    $res = array("messege"=>'บันทึกประวัติการักษา สำเร็จ!!!!',"id"=>$DocOPD);
}
    print json_encode($res);
    $connDB->close_PDO();
}elseif ($method == 'edit_lotitem') {
    $lot_price=0;
    $li_id = $_POST['li_id'];
    $lot_id = $_POST['lot_id'];
    $db_id = $_POST['db_id'];
    $item_price = $_POST['item_price'];
    $item_amount = $_POST['item_amount'];
    $sell_price = $_POST['sell_price'];
    $expire_date = insert_date($_POST['expire_date']);

    $sql = "select receive,sell from drug_brand where db_id= :db_id";
    $connDB->imp_sql($sql);
    $execute=array(':db_id' => $db_id);
    $receive=$connDB->select_a($execute);
    // $total_receive = (int) $item_amount + (int) $receive['receive'];
    // $total_now = $total_receive - (int) $receive['sell'];

    $sql = "select item_price,item_amount from lot_item where li_id= :li_id";
    $connDB->imp_sql($sql);
    $execute=array(':li_id' => $li_id);
    $amount=$connDB->select_a($execute);
    $total_receive = (int) $item_amount + ((int) $receive['receive']-$amount['item_amount']);
    $total_now = $total_receive - (int) $receive['sell'];

    $data = array($db_id,$item_price,$item_amount,$sell_price,$expire_date,$total_now);
    $field = array("db_id","item_price","item_amount","sell_price","expire_date","total_now");
    $table = "lot_item";
    $where="li_id=:li_id";
    $execute=array(':li_id' => $li_id);
    $edit_lot_item = $connDB->update($table, $data, $where, $field, $execute);

    if($edit_lot_item){
        $data2 = array($total_receive);
        $field = array("receive");
        $table2 = "drug_brand";
        $where="db_id=:db_id";
        $execute2=array(':db_id' => $db_id);
        $edit_drug_brand=$connDB->update($table2, $data2, $where, $field, $execute2); 

        $lot_price += $item_price*$item_amount;
    }
    else if(!$add_lot_item){
        $res = array("messege"=>'เพิ่มรายการไม่สำเร็จ!!!! '.$edit_lot_item->errorInfo());
        print json_encode($res);
    }
    $sql = "SELECT lot_price,lot_amount FROM lot WHERE lot_id= :lot_id";
    $connDB->imp_sql($sql);
    $execute=array(':lot_id' => $lot_id);
    $chk_lot=$connDB->select_a($execute);

    $lot_price = ($chk_lot['lot_price']-($amount['item_price']*$amount['item_amount'])+$lot_price);
    $lot_amount = $chk_lot['lot_amount'];

    $data3 = array($lot_price,$lot_amount);
    $field3 = array("lot_price","lot_amount");
    $table3 = "lot";
    $where3="lot_id=:lot_id";
    $execute3=array(':lot_id' => $lot_id);
    $edit_lot=$connDB->update($table3, $data3, $where3, $field3, $execute3); 

    $res = array("messege"=>'เพิ่มรายการสำเร็จ!!!!');
    print json_encode($res);
    $connDB->close_PDO();
}