<?php ob_start(); 
    include '../connection/connect1.php';
	include '../connection/db_connect.php';
	include '../connection/function.php';
        
 	$strSQL = "select image as cc from patient_image where hn='".$_GET['hn']."' ";
	header("Content - type : image/jpeg");
// 	header('Content-type: text/json; charset=utf-8');
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Headers: access");
// header("Access-Control-Allow-Methods: GET,POST");
// header("Access-Control-Allow-Credentials: true");
	echo getsqldata($strSQL);
?>