<?php
ob_start();
require_once('tcpdf.php');
include("../conf.php");
$branch_id=$_GET['branch_id'];
$status=$_GET['status'];
if(empty($status))
{
    $sqli=$conn->query("SELECT * FROM `tbl_order` WHERE `branch_order`='$branch_id'");

}else{
    $sqli=$conn->query("SELECT * FROM `tbl_order` WHERE `branch_order`='$branch_id' and `status`='$status'");

}
$table="";

while ($row=$sqli->fetch_assoc()) {
    $branch_delivery=$row['branch_delivery'];
    $branch_order=$row['branch_order'];
    $date_order=$row['date_order'];
    $brand=$row['brand'];
    $code=$row['code'];
    $unit=$row['unit'];
    $color=$row['color_id'];
    $motor_id=$row['motor_id'];
    $note=$row['note'];
    $sql2=$conn->query("SELECT a.branch_name,b.zone_name FROM `tbl_branch` a inner join tbl_zone b on a.zone_id=b.id WHERE a.id='$branch_delivery'");
list($branch_delivery_name,$zone_delivery)=mysqli_fetch_row($sql2);
$sql3=$conn->query("SELECT a.branch_name,b.zone_name FROM `tbl_branch` a inner join tbl_zone b on a.zone_id=b.id WHERE a.id='$branch_order'");
list($branch_order_name,$zone_order)=mysqli_fetch_row($sql3);
$sql4=$conn->query("SELECT `name` FROM `tbl_motorcycle` WHERE id='$motor_id'");
list($name)=mysqli_fetch_row($sql4);
$sql5=$conn->query("SELECT `color` FROM `tbl_motorcycle_color` WHERE `id`='$color'");
list($colorname)=mysqli_fetch_row($sql5);

$table.='
<tr>
    <td style="text-align:center;" ><br>1</td>
    <td style="text-align:left;"><br>'.DateThai($date_order).'</td>
    <td style="text-align:left;"><br>'.$brand.'</td>
    <td style="text-align:left;" ><br>'.$name.' </td>
    <td style="text-align:left;"><br>'.$code.'</td>
    <td style="text-align:center;" ><br>'.$colorname.'</td>
    <td style="text-align:center;" ><br>'.$unit.'</td>
    <td style="text-align:left;" ><br>'.$zone_delivery.$branch_delivery_name.' </td>
    <td style="text-align:left;" ><br>'.$zone_order.$branch_order_name.' </td>
</tr>
';
}

$html= '

<div style="line-height:1;">
<table width="100%">
<tr>
    <td width="50%"><img src="../img/logo/5.png"></td>
    <td width="50%" style="text-align:right;">วันที่ : '.DateThai($date_order).'</td>
</tr>
</table>
<br>
<div style="text-align:center;font-size:30px;"><label>ยอดจำนวนการสั่งจอง</label></div>
<br><br>

<table width="100%" border="1"  cellpadding="5" style="font-size:16px;">
<tr>
    <th style="text-align:center;background-color:#ccc;" width="7%"><br>ลำดับ <br></th>
    <th style="text-align:center;background-color:#ccc;" width="8%"><br>วันที่<br> </th>
    <th style="text-align:center;background-color:#ccc;" width="10%"><br>ยี่ห้อ<br> </th>
    <th style="text-align:center;background-color:#ccc;" width="15%"><br>รุ่น <br></th>
    <th style="text-align:center;background-color:#ccc;" width="15%"><br>รหัส <br></th>
    <th style="text-align:center;background-color:#ccc;" width="8%"><br>สี <br></th>
    <th style="text-align:center;background-color:#ccc;" width="7%"><br>จำนวน <br></th>
    <th style="text-align:center;background-color:#ccc;" width="15%"><br>สาขาจัดส่ง <br></th>
    <th style="text-align:center;background-color:#ccc;" width="15%"><br>สาขาจอง <br></th>
</tr>
'.$table.'
</table>

';



class MYPDF extends TCPDF {}

				// create new PDF document
$pdf= new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

				// set document information
$pdf ->SetCreator(PDF_CREATOR);
$pdf ->SetAuthor("ใบสั่งจองรถจักรยานยนต์");
$pdf ->SetTitle("ใบสั่งจองรถจักรยานยนต์");
$pdf ->SetSubject("ใบสั่งจองรถจักรยานยนต์");
$pdf ->SetKeywords("ใบสั่งจองรถจักรยานยนต์");
 


				// ---------------------------------------------------------

				// set font
$pdf ->SetFont('angsanaupc', '', 16);

				// add a page
$pdf ->AddPage("L","A4"); 


$pdf ->setPrintHeader(false);
$pdf ->setPrintFooter(false);

// set default monospaced font
$pdf ->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf ->SetMargins(10, 10, 10,10);

// set auto page breaks
$PDF_MARGIN_BOTTOM = auto;

$pdf ->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf ->setImageScale(PDF_IMAGE_SCALE_RATIO);

		 
// $pdf->SetAutoPageBreak(true, $PDF_MARGIN_BOTTOM);

$pdf->writeHTML($html, true, false, true, false, '');


$rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);
ob_end_clean();
$pdf->Output('ใบสั่งจองรถจักรยานยนต์.pdf', 'I');


?>