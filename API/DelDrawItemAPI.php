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
$connDB = new EnDeCode();
$read = "../connection/conn_DB.txt";
$connDB->para_read($read);
$connDB->Read_Text();
$connDB->conn_PDO();

$id=$_POST['id'];

$sql = "SELECT *
FROM bill_item
WHERE bi_id= :bi_id";
$connDB->imp_sql($sql);
$execute=array(':bi_id' => $id);
$detial_bill_item=$connDB->select_a($execute);

    $sql = "select receive,pay from material where mate_id= :mate_id";
    $connDB->imp_sql($sql);
    $execute=array(':mate_id' => $detial_bill_item['mate_id']);
    $receive=$connDB->select_a($execute);

    $total_pay = (int) $receive['pay']-$detial_bill_item['draw_amount'];//คืนค่าการนำเข้า(receive)ให้ตาราง material

    $data2 = array($total_pay);
        $field = array("pay");
        $table2 = "material";
        $where="mate_id=:mate_id";
        $execute2=array(':mate_id' => $detial_bill_item['mate_id']);
        $edit_material=$connDB->update($table2, $data2, $where, $field, $execute2); 
    
        $sql = "SELECT bill_amount,bill_amo_total FROM bill WHERE bill_id= :bill_id";
        $connDB->imp_sql($sql);
        $execute=array(':bill_id' => $detial_bill_item['bill_id']);
        $chk_bill=$connDB->select_a($execute);

        $bill_amo_total = $chk_bill['bill_amo_total']-$detial_bill_item['draw_amount'];
        $bill_amount = $chk_bill['bill_amount']-1;

        $data3 = array($bill_amount,$bill_amo_total);
        $field3 = array("bill_amount","bill_amo_total");
        $table3 = "bill";
        $where3="bill_id=:bill_id";
        $execute3=array(':bill_id' => $detial_bill_item['bill_id']);
        $edit_bill=$connDB->update($table3, $data3, $where3, $field3, $execute3);

        if($edit_bill){
            $table=$_POST['table'];
            $field=$_POST['field'];
            $where=$field."=:".$field;
            $execute=  array(':'.$field => $id);
            $del=$connDB->delete($table, $where , $execute);
            if($del===true){
                echo 'ลบสำเร็จครับ';
            }else{
                echo 'ไม่สามารถลบได้สำเร็จครับ';
            }
        }else{
            echo 'ไม่สามารถลบรายการได้ครับ';
        }

$connDB->close_PDO();
?>