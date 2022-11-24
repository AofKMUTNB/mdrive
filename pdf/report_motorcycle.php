<?php
ob_start();
require_once('tcpdf.php');
include("../conf.php");
$branch_id=$_GET['branch_id'];
$key=$_GET['key'];
$myid=$_SESSION['user-id'];

$sql2=$conn->query("SELECT a.branch_name,b.zone_name FROM `tbl_branch` a inner join tbl_zone b on a.zone_id=b.id WHERE a.id='$branch_id'");
list($branch_name,$zone_name)=mysqli_fetch_row($sql2);

$sqli1=$conn->query("SELECT `name`,`surname` FROM `tbl_employee` WHERE `id`='$myid'");
list($name,$surname)=mysqli_fetch_row($sqli1);

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

$table="";

if(empty($key))
{
    $sqli=$conn->query("SELECT * FROM `tbl_motorcycle` WHERE `branch_id`='$branch_id'");

}else{
    $sqli = $conn->query("SELECT * FROM `tbl_motorcycle` where branch_id='$branch_id' and (`name` LIKE '%$key%' OR `code` LIKE '%$key%' OR `brand` LIKE '%$key%') order by id asc");

}

while ($row=$sqli->fetch_assoc()) {
  $mainID=$row['id'];
$sql5=$conn->query("SELECT `color`,`unit` FROM `tbl_motorcycle_color` WHERE `mainID`='$mainID'");
while ($r=$sql5->fetch_assoc()) {
    if($r['unit']!=0)
    {
        $table.='
        <tr>
           
            <td style="text-align:left;"><br>'.$row['brand'].'</td>
            <td style="text-align:left;" ><br>'.$row['name'].' </td>
            <td style="text-align:left;"><br>'.$row['code'].'</td>
            <td style="text-align:center;" ><br>'.$r['color'].'</td>
            <td style="text-align:center;" ><br>'.$r['unit'].'</td>
        </tr>';
    }
   
   
}


}

$html= '

<div style="line-height:1;">
<table width="100%">
<tr>
    <td width="50%"><img src="../img/logo/5.png"></td>
    <td width="50%" style="text-align:right;">วันที่เอกสาร : '.DateThai(date("Y-m-d")).'</td>
</tr>
</table>
<br>
<div style="text-align:center;font-size:30px;"><label>ใบสินค้าคงเหลือ</label></div>
<br>
<table width="100%" style="line-height:1.8;">
<tr>
    <td width="40%">ผู้บันทึก '.$name." ".$surname.'</td>
    <td width="60%" style="text-align:right;">สาขา : '.$zone_name.$branch_name.'</td>
</tr>
<tr>
    <td width="1000%" colspan="2">หมายเหตุ................................................................................</td>
</tr>
</table>
<br><br>
<table width="100%" border="1"  cellpadding="5" style="font-size:16px;">
<tr>
    <th style="text-align:center;background-color:#ccc;" width="10%"><br>ยี่ห้อ<br> </th>
    <th style="text-align:center;background-color:#ccc;" width="30%"><br>รุ่น <br></th>
    <th style="text-align:center;background-color:#ccc;" width="30%"><br>รหัส <br></th>
    <th style="text-align:center;background-color:#ccc;" width="20%"><br>สี <br></th>
    <th style="text-align:center;background-color:#ccc;" width="10%"><br>จำนวน <br></th>
</tr>
'.$table.'
</table>
</div>
';


// $pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content

// $pdf->writeHTML($html, true, false, true, false, '');
$PDF_MARGIN_BOTTOM = 40;
$pdf->SetAutoPageBreak(true, $PDF_MARGIN_BOTTOM);
$pdf->setPageMark();

        $pdf->writeHTML($html, true, false, true, false, '');


				//Close and output PDF document
				// $pdf->Output('example_003.pdf', 'I');
                $rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);
                ob_end_clean();
                $pdf->Output('quotation.pdf', 'I');

?>