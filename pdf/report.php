<?php
session_start();
ob_start();
require_once('tcpdf.php');
include("../condb.php");


function Convert($amount_number)
{
	$amount_number = number_format($amount_number, 2, ".","");
	$pt = strpos($amount_number , ".");
	$number = $fraction = "";
	if ($pt === false) 
		$number = $amount_number;
	else
	{
		$number = substr($amount_number, 0, $pt);
		$fraction = substr($amount_number, $pt + 1);
	}

	$ret = "";
	$baht = ReadNumber ($number);
	if ($baht != "")
		$ret .= $baht . "บาท";

	$satang = ReadNumber($fraction);
	if ($satang != "")
		$ret .=  $satang . "สตางค์";
	else 
		$ret .= "ถ้วน";
	return $ret;
}

function ReadNumber($number)
{
	$position_call = array("แสน", "หมื่น", "พัน", "ร้อย", "สิบ", "");
	$number_call = array("", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ด", "แปด", "เก้า");
	$number = $number + 0;
	$ret = "";
	if ($number == 0) return $ret;
	if ($number > 1000000)
	{
		$ret .= ReadNumber(intval($number / 1000000)) . "ล้าน";
		$number = intval(fmod($number, 1000000));
	}

	$divider = 100000;
	$pos = 0;
	while($number > 0)
	{
		$d = intval($number / $divider);
		$ret .= (($divider == 10) && ($d == 2)) ? "ยี่" : 
		((($divider == 10) && ($d == 1)) ? "" :
			((($divider == 1) && ($d == 1) && ($ret != "")) ? "เอ็ด" : $number_call[$d]));
		$ret .= ($d ? $position_call[$pos] : "");
		$number = $number % $divider;
		$divider = $divider / 10;
		$pos++;
	}
	return $ret;
}
				// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {}

				// create new PDF document
$pdf= new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

				// set document information
$pdf ->SetCreator(PDF_CREATOR);
$pdf ->SetAuthor($title);
$pdf ->SetTitle($title." ( ".$month."/".$year." )");
$pdf ->SetSubject($title);
$pdf ->SetKeywords($title);

				// remove default header/footer
$pdf ->setPrintHeader(false);
$pdf ->setPrintFooter(false);

				// set default monospaced font
$pdf ->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

				// set margins
$pdf ->SetMargins(5, 10, 5,5);

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
sdfsdfsd

';

// $html = '<div style="z-index:99999;background-color:yellow;color:blue;">&nbsp;PAGE 1&nbsp;</div>';         
// $pdf->Image('logo.png', 0, 0, 210, 297, 'png', '', '', true, 200, '', false, false, 0, false, false, true);
// $img_file = K_PATH_IMAGES . 'logo.png';
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

$pdf->Image('logo.jpg', 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
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