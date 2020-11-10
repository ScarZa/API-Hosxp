<?php session_save_path("../session/");
session_start();

function __autoload($class_name) {
    include '../class/' . $class_name . '.php';
}

set_time_limit(0);
$connDB = new TablePDO();
$read = "../connection/conn_DB.txt";
$connDB->para_read($read);
$connDB->Read_Text();
$connDB->conn_PDO();
$conv=new convers_encode();?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>แบบการวินิจฉัยทางสังคม</title>
<link rel='SHORTCUT ICON' href='images/icon_set2/compose.ico'>
    <meta charset="UTF-8">
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../../font/template/bootstrap-4.1.1/css/bootstrap.min.css" crossorigin="anonymous">
    <!-- <link rel="stylesheet" type="text/css" href="plugins/Jprint/print.min.css"> -->
    <link rel="stylesheet" href="../../font/plugins/font-awesome-4.6.3/css/font-awesome.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="../../font/plugins/select2/select2.min.css">
    <!-- My tools -->
    <!-- <script src="MyTools/createTableAjax.js" type="text/javascript"></script>
    <script src="MyTools/AJAXCharts.js" type="text/javascript"></script>
    <script src="MyTools/reportLayout.js" type="text/javascript"></script> -->
    <!-- End My tools -->
    <link rel="stylesheet" href="../../font/plugins/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom.css" />
    <link rel="stylesheet" href="../../font/plugins/jquery-ui-1.11.4.custom/SpecialDateSheet.css" />
    <!-- <link rel="stylesheet" type="text/css" href="plugins/DataTables/datatables.min.css"/> -->
    <link rel="stylesheet" type="text/css" href="../../font/plugins/DataTables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css" />
   
<style type="text/css">
body {
	margin-top: 50px;
}
</style>
</head>
<?php
include_once ('../plugins/funcDateThai.php');
include '../plugins/function_date.php';
    $id=$_GET['id'];

    $sql=  "SELECT concat(pt.pname,pt.fname,' ',pt.lname)fullname,TIMESTAMPDIFF(year,pt.birthday,NOW())age,sc.hn
    ,sc.contributor,sc.relevance,sc.symptom,sc.aliment,sc.relationship,sc.issue_ali,sc.ali_comm,sc.issue_edu,sc.edu_comm,sc.issue_other,sc.other_comm
		,sc.assessment01,sc.assessment02,sc.assessment02_comm,sc.assessment03,sc.assessment04,sc.assessment05
		,sc.assessment06,sc.assessment07,sc.assessment07_comm,sc.assessment08,sc.assessment09,sc.assessment10,sc.assessment11
		,sc.assessment12,sc.assessment12_comm,sc.plan01,sc.plan02,sc.plan03,sc.plan04,sc.plan05,sc.plan05_comm
		,os.name,os.entryposition,sc.vdate
		FROM jvl_social02 sc
    inner join patient pt on sc.hn=pt.hn
    inner join opduser os on os.loginname=recorder
    WHERE sc.social_id=".$id;
    $connDB->imp_sql($sql);
    $detial_patient=$connDB->select_a();
    //print_r($detial_patient);
    $fullname = $conv->tis620_to_utf8($detial_patient['fullname']);
    $age = $detial_patient['age'];
    $hn = $detial_patient['hn'];
    $contributor = $conv->tis620_to_utf8($detial_patient['contributor']);
    $relevance = $conv->tis620_to_utf8($detial_patient['relevance']);
    $symptom = $conv->tis620_to_utf8($detial_patient['symptom']);
    $aliment = $conv->tis620_to_utf8($detial_patient['aliment']);
    $relationship = $conv->tis620_to_utf8($detial_patient['relationship']);
    $issue_ali = $detial_patient['issue_ali'];
    $ali_comm = $conv->tis620_to_utf8($detial_patient['ali_comm']);
    $issue_edu = $detial_patient['issue_edu'];
    $edu_comm = $conv->tis620_to_utf8($detial_patient['edu_comm']);
    $issue_other = $detial_patient['issue_other'];
    $other_comm = $conv->tis620_to_utf8($detial_patient['other_comm']);
    $assessment01 = $detial_patient['assessment01'];
    $assessment02 = $detial_patient['assessment02'];
    $ass02_comm = $conv->tis620_to_utf8($detial_patient['assessment02_comm']);
    $assessment03 = $detial_patient['assessment03'];
    $assessment04 = $detial_patient['assessment04'];
    $assessment05 = $detial_patient['assessment05'];
    $assessment06 = $detial_patient['assessment06'];
    $assessment07 = $detial_patient['assessment07'];
    $ass07_comm = $conv->tis620_to_utf8($detial_patient['assessment07_comm']);
    $assessment08 = $detial_patient['assessment08'];
    $assessment09 = $detial_patient['assessment09'];
    $assessment10 = $detial_patient['assessment10'];
    $assessment11 = $detial_patient['assessment11'];
    $assessment12 = $detial_patient['assessment12'];
    $ass12_comm = $conv->tis620_to_utf8($detial_patient['assessment12_comm']);
    $plan01 = $detial_patient['plan01'];
    $plan02 = $detial_patient['plan02'];
    $plan03 = $detial_patient['plan03'];
    $plan04 = $detial_patient['plan04'];
    $plan05 = $detial_patient['plan05'];
    $p05_comm = $conv->tis620_to_utf8($detial_patient['plan05_comm']);
    $name = $conv->tis620_to_utf8($detial_patient['name']);
    $entryposition = $conv->tis620_to_utf8($detial_patient['entryposition']);
    $vdate = Datethai1($detial_patient['vdate']);
 ?>
<body>
    <?php
require_once('../plugins/library/mpdf60/mpdf.php'); //ที่อยู่ของไฟล์ mpdf.php ในเครื่องเรานะครับ
ob_start(); // ทำการเก็บค่า html นะครับ*/
?>
    <div class="col-lg-12" align="center"><b valign="bottom">โรงพยาบาลจิตเวชเลยราชนครินทร์ กรมสุขภาพจิต กระทรวงสาธารณสุข</b></div>
            <div align="left"><b>แบบวินิจฉัยทางสังคม (สำหรับผู้ป่วยจิตเด็ก)</b></div>
            <div class="col-lg-12">
            <table width='100%' border='0' cellspacing='' cellpadding='' frame='below' class='divider'>
                    <tr>
                        <td colspan='2'>
                <table width='100%' border='1' cellspacing='' cellpadding=''>
                    <tr>
                        <td>
                        <table width='100%' border='0' cellspacing='' cellpadding=''>
                        <tr>
                        <td height="25">ชื่อ-สกุลผู้ป่วย <u> &nbsp;&nbsp;<?= $fullname?>&nbsp;&nbsp; </u> อายุ <u> &nbsp;&nbsp;<?= $age?>&nbsp;&nbsp; </u> ปี  HN <u> &nbsp;&nbsp;<b><?= $hn?></b>&nbsp;&nbsp; </u></td>
                    </tr>
                    <tr>
                        <td height="25">ผู้ให้ประวัติ <u> &nbsp;&nbsp;<?= $contributor?>&nbsp;&nbsp; </u> เกี่ยวข้องเป็น <u> &nbsp;&nbsp;<?= $relevance?>&nbsp;&nbsp; </u></td>
                    </tr>
                        </table>
                        </td>
                        </tr>
                        </table><br><br>
                        </td>
                    </tr>
                    <tr>
                        <td colspan='2' height="35"><b>การประเมินทางสังคมสงเคราะห์</b></td>
                    </tr>
                    <tr>
                        <td colspan='2' height="35"><b>Sujective</b></td>
                    </tr>
                    <tr>
                        <td colspan='2' height="25">อาการสำคัญ <u> &nbsp;&nbsp;<?= $symptom?>&nbsp;&nbsp; </u></td>
                    </tr>
                    <tr>
                        <td colspan='2' height="35"><b>Objective</b></td>
                    </tr>
                    <tr>
                        <td colspan='2' height="25">ประวัติการเลี้ยงดู <u> &nbsp;&nbsp;<?= empty($aliment)?'ไม่มี':$aliment;?>&nbsp;&nbsp; </u></td>
                    </tr>
                    <tr>
                        <td colspan='2' height="25">ความสัมพันธ์ในครอบครัว และความเป็นอยู่ในปัจจุบัน <u> &nbsp;&nbsp;<?= empty($relationship)?'ไม่มี':$relationship;?>&nbsp;&nbsp; </u></td>
                    </tr>
                    <tr>
                        <td colspan='2' height="35"><b>Assessment</b></td>
                    </tr>
                    <tr>
                        <td colspan='2' height="25"><b>การวินิจฉัยทางสังคม</b></td>
                    </tr>
                    <tr>
                        <td width='5%'><?=$issue_ali=='Y'?"[ / ]":"[&nbsp;&nbsp;&nbsp;]";?></td><td height="25">ปัญหาการเลี้ยงดู <u> &nbsp;&nbsp;<?= empty($ali_comm)?'':$ali_comm;?>&nbsp;&nbsp; </u></td>
                    </tr>
                    <tr>
                        <td width='5%'><?=$issue_edu=='Y'?"[ / ]":"[&nbsp;&nbsp;&nbsp;]";?></td><td height="25">ปัญหาการเรียน <u> &nbsp;&nbsp;<?= empty($edu_comm)?'':$edu_comm;?>&nbsp;&nbsp; </u></td>
                    </tr>
                    <tr>
                        <td width='5%'><?=$issue_other=='Y'?"[ / ]":"[&nbsp;&nbsp;&nbsp;]";?></td><td height="25">ปัญหาอื่นๆ <u> &nbsp;&nbsp;<?= empty($other_comm)?'':$other_comm;?>&nbsp;&nbsp; </u></td>
                    </tr>
                </table>
            </div>
            <?php
$html = ob_get_contents();
ob_clean();

ob_start(); // ทำการเก็บค่า html นะครับ*/
?>
<div class="col-lg-12">
            <table width='100%' border='0' cellspacing='' cellpadding='' frame='below' class='divider'>
                <tr>
                    <td colspan='2' height="25"><b>แบบวิตรวจนิจฉัยทางสังคม และบำบัดทางสังคม</b><hr></td>
                </tr>
                <tr>
                    <td colspan='2' height="25"><b>Assessment</b></td>
                </tr>
                <tr>
                    <td colspan='2' height="25"><b>การให้ความช่วยเหลือ</b></td>
                </tr>
                <tr>
                <td width='5%'><?=$assessment01=='Y'?"[ / ]":"[&nbsp;&nbsp;&nbsp;]";?></td><td height="25">Counseling ผู้ปกครองในการอบรมเลี้ยงดูที่เหมาะสม และเลี้ยงดูไปในทางเดียวกัน </td>
                </tr>
                <tr>
                <td width='5%'><?=$assessment02=='Y'?"[ / ]":"[&nbsp;&nbsp;&nbsp;]";?></td><td height="25">การปรับพฤติกรรมเบื้องต้น <u> &nbsp;&nbsp;<?= empty($ass02_comm)?'':$ass02_comm;?>&nbsp;&nbsp; </u></td>
                </tr>
                <tr>
                <td width='5%'><?=$assessment03=='Y'?"[ / ]":"[&nbsp;&nbsp;&nbsp;]";?></td><td height="25">การจัดตารางในการทบทวนการเรียนสม่ำเสมอ </td>
                </tr>
                <tr>
                <td valign="top" width='5%'><?=$assessment04=='Y'?"[ / ]":"[&nbsp;&nbsp;&nbsp;]";?></td><td height="25">การจัดสิ่งแวดล้อมขณะทบทวนการสอน เช่น ไม่เปิดโทรทัศน์ การจัดโต๊ะในการทำกิจกรรม การแบ่งย่อยงาน เป็นต้น </td>
                </tr>
                <tr>
                <td width='5%'><?=$assessment05=='Y'?"[ / ]":"[&nbsp;&nbsp;&nbsp;]";?></td><td height="25">การ Empowerment </td>
                </tr>
                <tr>
                <td width='5%'><?=$assessment06=='Y'?"[ / ]":"[&nbsp;&nbsp;&nbsp;]";?></td><td height="25">Supportive Counscling </td>
                </tr>
                <tr>
                <td width='5%'><?=$assessment07=='Y'?"[ / ]":"[&nbsp;&nbsp;&nbsp;]";?></td><td height="25">การพิทักษ์สิทธิ์ <u> &nbsp;&nbsp;<?= empty($ass07_comm)?'':$ass07_comm;?>&nbsp;&nbsp; </u></td>
                </tr>
                <tr>
                <td width='5%'><?=$assessment08=='Y'?"[ / ]":"[&nbsp;&nbsp;&nbsp;]";?></td><td height="25">ประเมินปัญหา/ความสามารถร่วมกับครู และวางแผนแก้ไขปัญหาร่วมกัน </td>
                </tr>
                <tr>
                <td width='5%'><?=$assessment09=='Y'?"[ / ]":"[&nbsp;&nbsp;&nbsp;]";?></td><td height="25">ให้ใบรายงานโรงเรียน </td>
                </tr>
                <tr>
                <td width='5%'><?=$assessment10=='Y'?"[ / ]":"[&nbsp;&nbsp;&nbsp;]";?></td><td height="25">ให้แบบประเมินพฤติกรรมสำหรับครู/ผู้ปกครอง </td>
                </tr>
                <tr>
                <td width='5%'><?=$assessment11=='Y'?"[ / ]":"[&nbsp;&nbsp;&nbsp;]";?></td><td height="25">ชี้แจงระบบนัด ความสำคัญของการมาตามนัด และการบำบัดรักษาอย่างต่อเนื่อง </td>
                </tr>
                <tr>
                <td width='5%'><?=$assessment12=='Y'?"[ / ]":"[&nbsp;&nbsp;&nbsp;]";?></td><td height="25">ระบุอื่นๆ <u> &nbsp;&nbsp;<?= empty($ass12_comm)?'':$ass12_comm;?>&nbsp;&nbsp; </u></td>
                </tr>
                <tr>
                    <td colspan='2' height="25"><b>Plan</b></td>
                </tr>
                <tr>
                    <td colspan='2' height="25"><b>การดำเนินการต่อ</b></td>
                </tr>
                <tr>
                <td width='5%'><?=$plan01=='Y'?"[ / ]":"[&nbsp;&nbsp;&nbsp;]";?></td><td height="25">ส่งนักจิตวิทยาทดสอบ IQ test </td>
                </tr>
                <tr>
                <td width='5%'><?=$plan02=='Y'?"[ / ]":"[&nbsp;&nbsp;&nbsp;]";?></td><td height="25">ส่งตรวจ VABS </td>
                </tr>
                <tr>
                <td width='5%'><?=$plan03=='Y'?"[ / ]":"[&nbsp;&nbsp;&nbsp;]";?></td><td height="25">เข้ากลุ่มส่งเสริมพัฒนาการเด็กที่มีความเสี่ยงต่อพัฒนาการล่าช้าโดยผู้ปกครองมีส่วนร่วม </td>
                </tr>
                <tr>
                <td width='5%'><?=$plan04=='Y'?"[ / ]":"[&nbsp;&nbsp;&nbsp;]";?></td><td height="25">พิจารณาตรวจทางจิตวิทย่า </td>
                </tr>
                <tr>
                <td width='5%'><?=$plan05=='Y'?"[ / ]":"[&nbsp;&nbsp;&nbsp;]";?></td><td height="25">ระบุอื่นๆ <u> &nbsp;&nbsp;<?= empty($p05_comm)?'':$p05_comm;?>&nbsp;&nbsp; </u></td>
                </tr>
            </table>
            </div><br><br>
            <table border="0" width="100%">
                                         <tr>
                                             <td width='50%' align="center">&nbsp;</td>
                                             <td width='50%' align="center">
                                     ลงชื่อ.........................................................<br><br>
                                     ( <?= $name?> )<br>
                                     ตำแหน่ง <?= $entryposition?> <br>วันที่ <?= $vdate?></td>
                                     
                                         </tr>
                                         <tr>
                                         <td width='50%' align="center">&nbsp;</td>
                                         </tr>
                                     </table>
<?php
$html2 = ob_get_contents();
ob_clean();

$pdf = new mPDF('tha2','A4','11','');
$pdf->autoScriptToLang = true;
$pdf->autoLangToFont = true;
$pdf->SetDisplayMode('fullpage');

$pdf->WriteHTML($html, 2);
$pdf->AddPage();
$pdf->WriteHTML($html2,2);
$pdf->Output("../SCPDF/Social.pdf");
echo "<meta http-equiv='refresh' content='0;url=../SCPDF/Social.pdf' />";
?>
<script src="../plugins/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom.js"></script>
</body>
</html>