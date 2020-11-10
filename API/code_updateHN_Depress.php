<?php

function __autoload($class_name) {
    include '../class/' . $class_name . '.php';
}

set_time_limit(0);
$connDB = new EnDeCode();
$read = "../connection/conn_DB.txt";
$connDB->para_read($read);
$connDB->Read_Text();
$connDB->conn_PDO();


    $sql = "SELECT p.hn
    FROM patient p
    inner join depression_screen ds on ds.patient_depression_id = p.hn
    ORDER BY ds.depression_screen_id asc";
    $connDB->imp_sql($sql);
    $result = $connDB->select();

    for($i=0;$i<count($result);$i++){

        //echo $result[$i]['id']."<br>";
    $data = array($result[$i]['hn']);
    $field=array("hn");
    $table = "depression_screen";
    $where="patient_depression_id=:patient_depression_id";
    $execute=array(':patient_depression_id' => $result[$i]['hn']);
    $WarpR=$connDB->update($table, $data, $where, $field, $execute);
  
    }
    $connDB->close_PDO();