<?php
ob_start();
require_once('tcpdf.php');
include("../conf.php");
$order_id=$_GET['order_id'];

$sqli=$conn->query("SELECT * FROM `tbl_order` WHERE `id`='$order_id'");

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
    $user_id=$row['user_id'];
}
$sql2=$conn->query("SELECT a.branch_name,b.zone_name FROM `tbl_branch` a inner join tbl_zone b on a.zone_id=b.id WHERE a.id='$branch_delivery'");
list($branch_delivery_name,$zone_delivery)=mysqli_fetch_row($sql2);
$sql3=$conn->query("SELECT a.branch_name,b.zone_name FROM `tbl_branch` a inner join tbl_zone b on a.zone_id=b.id WHERE a.id='$branch_order'");
list($branch_order_name,$zone_order)=mysqli_fetch_row($sql3);
$sql4=$conn->query("SELECT `name` FROM `tbl_motorcycle` WHERE id='$motor_id'");
list($name)=mysqli_fetch_row($sql4);
$sql5=$conn->query("SELECT `color` FROM `tbl_motorcycle_color` WHERE `id`='$color'");
list($colorname)=mysqli_fetch_row($sql5);
$sql6=$conn->query("SELECT `name`,`surname` FROM `tbl_employee` WHERE `id`='$user_id'");
list($nameuser,$surname)=mysqli_fetch_row($sql6);




class MYPDF extends TCPDF {}

				// create new PDF document
$pdf= new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

				// set document information
$pdf ->SetCreator(PDF_CREATOR);
$pdf ->SetAuthor("ใบสั่งจองรถจักรยานยนต์");
$pdf ->SetTitle("ใบสั่งจองรถจักรยานยนต์");
$pdf ->SetSubject("ใบสั่งจองรถจักรยานยนต์");
$pdf ->SetKeywords("ใบสั่งจองรถจักรยานยนต์");

				// remove default header/footer
$pdf ->setPrintHeader(false);
$pdf ->setPrintFooter(false);

				// set default monospaced font
$pdf ->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

				// set margins
$pdf ->SetMargins(10, 20, 10,20);

				// set auto page breaks
$pdf ->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

				// set image scale factor
$pdf ->setImageScale(PDF_IMAGE_SCALE_RATIO);


				// ---------------------------------------------------------

				// set font
$pdf ->SetFont('angsanaupc', '', 16);

				// add a page
$pdf ->AddPage("P","A4");



$html= '

<div style="line-height:1;">
<span style="text-align:left;"><img src="../img/logo/5.png"></span>
<div style="text-align:center;font-size:30px;"><label>ใบสั่งจองรถจักรยานยนต์</label></div>
<br><br>
<table width="100%" style="line-height:1.8;">
<tr>
    <td width="70%" style="text-align:left;">สาขาที่สั่งจอง : '.$zone_delivery.$branch_delivery_name.' </td>
    <td width="30%" style="text-align:right;">วันที่ : '.DateThai($date_order).'</td>
</tr>
<tr >
    <td colspan="2" style="text-align:left;">สาขาที่จัดส่ง : '.$zone_order.$branch_order_name.' </td>
</tr>
</table>
<br><br>
<table width="100%" border="1"  cellpadding="5" style="font-size:16px;">
<tr>
    <th style="text-align:center;background-color:#ccc;" width="7%"><br>ลำดับ<br></th>
    <th style="text-align:center;background-color:#ccc;" width="15%"><br>ยี่ห้อ<br> </th>
    <th style="text-align:center;background-color:#ccc;" width="30%"><br>รุ่น <br></th>
    <th style="text-align:center;background-color:#ccc;" width="15%"><br>รหัส <br></th>
    <th style="text-align:center;background-color:#ccc;" width="10%"><br>สี <br></th>
    <th style="text-align:center;background-color:#ccc;" width="8%"><br>จำนวน <br></th>
    <th style="text-align:center;background-color:#ccc;" width="15%"><br>หมายเหตุ <br></th>
</tr>
<tr>
    <td style="text-align:center;" ><br>1</td>
    <td style="text-align:left;"><br>'.$brand.'</td>
    <td style="text-align:left;" ><br>'.$name.' </td>
    <td style="text-align:left;"><br>'.$code.'</td>
    <td style="text-align:center;" ><br>'.$colorname.'</td>
    <td style="text-align:center;" ><br>'.$unit.'</td>
    <td style="text-align:left;" ><br>'.$note.' </td>
</tr>
<tr>
    <td style="text-align:center;" ><br></td>
    <td style="text-align:left;"><br></td>
    <td style="text-align:left;" ><br> </td>
    <td style="text-align:left;"><br></td>
    <td style="text-align:center;" ><br></td>
    <td style="text-align:center;" ><br></td>
    <td style="text-align:left;" ><br> </td>
</tr>
<tr>
    <td style="text-align:center;" ><br></td>
    <td style="text-align:left;"><br></td>
    <td style="text-align:left;" ><br> </td>
    <td style="text-align:left;"><br></td>
    <td style="text-align:center;" ><br></td>
    <td style="text-align:center;" ><br></td>
    <td style="text-align:left;" ><br> </td>
</tr>
<tr>
    <td style="text-align:center;" ><br></td>
    <td style="text-align:left;"><br></td>
    <td style="text-align:left;" ><br> </td>
    <td style="text-align:left;"><br></td>
    <td style="text-align:center;" ><br></td>
    <td style="text-align:center;" ><br></td>
    <td style="text-align:left;" ><br> </td>
</tr>
<tr>
    <td style="text-align:center;" ><br></td>
    <td style="text-align:left;"><br></td>
    <td style="text-align:left;" ><br> </td>
    <td style="text-align:left;"><br></td>
    <td style="text-align:center;" ><br></td>
    <td style="text-align:center;" ><br></td>
    <td style="text-align:left;" ><br> </td>
</tr>
<tr>
    <td style="text-align:center;" ><br></td>
    <td style="text-align:left;"><br></td>
    <td style="text-align:left;" ><br> </td>
    <td style="text-align:left;"><br></td>
    <td style="text-align:center;" ><br></td>
    <td style="text-align:center;" ><br></td>
    <td style="text-align:left;" ><br> </td>
</tr>
<tr>
    <td style="text-align:center;" ><br></td>
    <td style="text-align:left;"><br></td>
    <td style="text-align:left;" ><br> </td>
    <td style="text-align:left;"><br></td>
    <td style="text-align:center;" ><br></td>
    <td style="text-align:center;" ><br></td>
    <td style="text-align:left;" ><br> </td>
</tr>
<tr>
    <td style="text-align:center;" ><br></td>
    <td style="text-align:left;"><br></td>
    <td style="text-align:left;" ><br> </td>
    <td style="text-align:left;"><br></td>
    <td style="text-align:center;" ><br></td>
    <td style="text-align:center;" ><br></td>
    <td style="text-align:left;" ><br> </td>
</tr>
</table>
<br><br>
<div style="text-align:right;">
<p >ผู้สั่งจอง &nbsp;'.$nameuser.' '.$surname.'</p>

</div>
</div>
';

$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();

$pdf->writeHTML($html, true, false, true, false, '');

				//Close and output PDF document
				// $pdf->Output('example_003.pdf', 'I');
$rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);
ob_end_clean();
$pdf->Output('report.pdf', 'I');
					// $pdf->Output('../pdf/bill.pdf', 'F');



?>