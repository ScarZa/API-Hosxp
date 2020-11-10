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
    ,sc.contributor,sc.relevance,symptom,hurt_comm,spawn_comm,evolu_comm,twitch_comm
    ,ed.eduname,sc.edu_comm,sc.career,sc.marry,sc.addict_comm,sc.family
    ,CASE
    WHEN sc.spending = 0 THEN 'ยากจน'
    WHEN sc.spending = 1 THEN 'ปานกลาง'
    ELSE 'ร่ำรวย'
    END as spending
    ,sc.spend_comm
    ,(SELECT concat(sp.problem_detial,' (',sp.problem_code,')') FROM jvl_social01 sc inner join jvl_social_problem_list sp on sp.so_problem_id=sc.Sdiag_1 WHERE sc.social_id=".$id.")Sdiag_1
    ,(SELECT concat(sp.problem_detial,' (',sp.problem_code,')') FROM jvl_social01 sc inner join jvl_social_problem_list sp on sp.so_problem_id=sc.Sdiag_2 WHERE sc.social_id=".$id.")Sdiag_2
    ,(SELECT concat(sp.problem_detial,' (',sp.problem_code,')') FROM jvl_social01 sc inner join jvl_social_problem_list sp on sp.so_problem_id=sc.Sdiag_3 WHERE sc.social_id=".$id.")Sdiag_3
    ,(SELECT concat(sp.problem_detial,' (',sp.problem_code,')') FROM jvl_social01 sc inner join jvl_social_problem_list sp on sp.so_problem_id=sc.Sdiag_4 WHERE sc.social_id=".$id.")Sdiag_4
    ,(SELECT concat(sp.problem_detial,' (',sp.problem_code,')') FROM jvl_social01 sc inner join jvl_social_problem_list sp on sp.so_problem_id=sc.Sdiag_5 WHERE sc.social_id=".$id.")Sdiag_5
    ,st.therapy_detial,sc.help_comm,sc.source_comm,os.name,os.entryposition,sc.vdate
    FROM jvl_social01 sc
    inner join patient pt on sc.hn=pt.hn
    inner join jvl_education ed on ed.education=sc.educate
	inner join jvl_social_therapy st on st.Social_therapy_id=sc.help
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
    $hurt_comm = $conv->tis620_to_utf8($detial_patient['hurt_comm']);
    $spawn_comm = $conv->tis620_to_utf8($detial_patient['spawn_comm']);
    $evolu_comm = $conv->tis620_to_utf8($detial_patient['evolu_comm']);
    $twitch_comm = $conv->tis620_to_utf8($detial_patient['twitch_comm']);
    $eduname = $conv->tis620_to_utf8($detial_patient['eduname']);
    $edu_comm = $conv->tis620_to_utf8($detial_patient['edu_comm']);
    $career = $conv->tis620_to_utf8($detial_patient['career']);
    $marry = $conv->tis620_to_utf8($detial_patient['marry']);
    $addict_comm = $conv->tis620_to_utf8($detial_patient['addict_comm']);
    $family = $conv->tis620_to_utf8($detial_patient['family']);
    $spending = $detial_patient['spending'];
    $spend_comm = $conv->tis620_to_utf8($detial_patient['spend_comm']);
    $Sdiag_1 = '1.) '.$conv->tis620_to_utf8($detial_patient['Sdiag_1']);
    $Sdiag_2 = isset($detial_patient['Sdiag_2'])?'<p> &nbsp;&nbsp;2.) '.$conv->tis620_to_utf8($detial_patient['Sdiag_2']):'';
    $Sdiag_3 = isset($detial_patient['Sdiag_3'])?'<p> &nbsp;&nbsp;3.) '.$conv->tis620_to_utf8($detial_patient['Sdiag_3']):'';
    $Sdiag_4 = isset($detial_patient['Sdiag_4'])?'<p> &nbsp;&nbsp;4.) '.$conv->tis620_to_utf8($detial_patient['Sdiag_4']):'';
    $Sdiag_5 = isset($detial_patient['Sdiag_5'])?'<p> &nbsp;&nbsp;5.) '.$conv->tis620_to_utf8($detial_patient['Sdiag_5']):'';
    $therapy_detial = $conv->tis620_to_utf8($detial_patient['therapy_detial']);
    $help_comm = $conv->tis620_to_utf8($detial_patient['help_comm']);
    $source_comm = $conv->tis620_to_utf8($detial_patient['source_comm']);
    $name = $conv->tis620_to_utf8($detial_patient['name']);
    $entryposition = $conv->tis620_to_utf8($detial_patient['entryposition']);
    $vdate = Datethai1($detial_patient['vdate']);
 ?>
<body>
    <?php
require_once('../plugins/library/mpdf60/mpdf.php'); //ที่อยู่ของไฟล์ mpdf.php ในเครื่องเรานะครับ
ob_start(); // ทำการเก็บค่า html นะครับ*/
?>
    <div class="col-lg-12" align="center"><b valign="bottom">เครื่องมือสำหรับงานสังคมสงเคราะห์จิตเวช</b></div>
            <div align="left"><b>แบบวินิจฉัยทางสังคมแบบผู้ป่วยนอก (สำหรับผู้ป่วยจิตเวชทั่วไป)</b></div>
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
                        </table>
                        </td>
                    </tr>
                    
                    <tr>
                        <td colspan='2' height="25">1. อาการสำคัญ/สาเหตุ ปัญหาและความต้องการ <u> &nbsp;&nbsp;<?= $symptom?>&nbsp;&nbsp; </u></td>
                    </tr>
                    <tr>
                        <td colspan='2' height="25">2. ประวัติการทำร้ายตนเอง <u> &nbsp;&nbsp;<?= empty($hurt_comm)?'ไม่มี':$hurt_comm;?>&nbsp;&nbsp; </u></td>
                    </tr>
                    <tr>
                        <td colspan='2' height="25"><b>ประวัติส่วนตัว</b></td>
                    </tr>
                    <tr>
                        <td colspan='2' height="25">3. ประวัติพัฒนาการ</td>
                    </tr>
                    <tr>
                        <td width='2%'>&nbsp;</td><td height="25">3.1 การตั้งครรภ์ <u> &nbsp;&nbsp;<?= empty($evolu_comm)?'ไม่มีความผิดปกติ':$evolu_comm;?>&nbsp;&nbsp; </u></td>
                    </tr>
                    <tr>
                        <td width='2%'>&nbsp;</td><td height="25">3.2 การคลอด/พัฒนาการในวัยเด็ก <u> &nbsp;&nbsp;<?= empty($spawn_comm)?'ไม่มีความผิดปกติ':$spawn_comm;?>&nbsp;&nbsp; </u></td>
                    </tr>
                    <tr>
                        <td width='2%'>&nbsp;</td><td height="25">3.3 ประวัติการชัก <u> &nbsp;&nbsp;<?= empty($twitch_comm)?'ไม่มีความผิดปกติ':$twitch_comm;?>&nbsp;&nbsp; </u></td>
                    </tr>
                    <tr>
                        <td colspan='2' height="25">4. ด้านการศึกษา <u> &nbsp;&nbsp;<?= empty($edu_comm)?'ไม่มี':$eduname.' '.$edu_comm?>&nbsp;&nbsp; </u></td>
                    </tr>
                    <tr>
                        <td colspan='2' height="25">5. ด้านการประกอบอาชีพ/ความสัมพันธ์กับเพื่อนร่วมงาน <u> &nbsp;&nbsp;<?= $career?>&nbsp;&nbsp; </u></td>
                    </tr>
                    <tr>
                        <td colspan='2' height="25">6. ด้านชีวิตสมรส/ความสัมพันธ์กับคู่สมรส และบุตร <u> &nbsp;&nbsp;<?= $marry?>&nbsp;&nbsp; </u></td>
                    </tr>
                    <tr>
                        <td colspan='2' height="25">7. ประวัติการใช้สารเสพติด <u> &nbsp;&nbsp;<?= empty($addict_comm)?'ไม่มี':$addict_comm?>&nbsp;&nbsp; </u></td>
                    </tr>
                    <tr>
                        <td colspan='2' height="25">8. ประวัติครอบครัว(ประวัติที่เกี่ยวข้องกับบิดา-มารดา : อุปนิสัย อาชีพ ความสัมพันธ์ในครอบครัว ความสัมพันธ์ระหว่างพี่น้อง ความคาดหวังที่ญาติมีต่อผู้ป่วย)
                        </td>
                    </tr>
                    <tr>
                        <td colspan='2'>
                        &nbsp;&nbsp;<u> &nbsp;&nbsp;<?= $family?>&nbsp;&nbsp; </u>
                        </td>
                    </tr>
                    <tr>
                        <td colspan='2' height="25">9. ฐานะทางครอบครัว <u> &nbsp;&nbsp;<?= $spending.' '.$spend_comm?>&nbsp;&nbsp; </u></td>
                    </tr>
                    <tr>
                        <td colspan='2' height="25">10. บันทึกการวินิจฉัยปัญหาทางสังคม </td>
                    </tr>
                    <tr>
                        <td colspan='2'>
                        <u> &nbsp;&nbsp;<b><?= $Sdiag_1?> <?= $Sdiag_2?> <?= $Sdiag_3?> <?= $Sdiag_4?> <?= $Sdiag_5?></b>&nbsp;&nbsp; </u>
                        </td>
                    </tr>
                    <tr>
                        <td colspan='2' height="25">11. การให้ความช่วยเหลือ <u> &nbsp;&nbsp;<?= $therapy_detial.' '.$help_comm?>&nbsp;&nbsp; </u></td>
                    </tr>
                    <tr>
                        <td colspan='2' height="25">12. แหล่งสนับสนุนทางสังคม <u> &nbsp;&nbsp;<?= $source_comm?>&nbsp;&nbsp; </u></td>
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
                                         <td width='50%' align="right">F-SO-023</td></tr>
                                     </table>
<?php
$html = ob_get_contents();
ob_clean();

$pdf = new mPDF('tha2','A4','11','');
$pdf->autoScriptToLang = true;
$pdf->autoLangToFont = true;
$pdf->SetDisplayMode('fullpage');

$pdf->WriteHTML($html, 2);
$pdf->Output("../SCPDF/Social.pdf");
echo "<meta http-equiv='refresh' content='0;url=../SCPDF/Social.pdf' />";
?>
<script src="../plugins/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom.js"></script>
</body>
</html>