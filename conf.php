<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mdrive"; 

date_default_timezone_set("Asia/Bangkok");

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
mysqli_set_charset($conn, "utf8mb4");

$arr_status=[
    "wait_confirm"=>"สั่งจองรถ",
    "confirm"=>"ยืนยันคำสั่งจอง",
    "delivery"=>"กำลังดำเนินการ",
    "success"=>"สำเร็จ",
    "failed"=>"ล้มเหลว"
];
$arr_color=[
    "BLK  ดำ",
    "B-G  ดำ-เทา",
    "B-S  ดำ-เทา",
    "B-R  ดำ-แดง",
    "BBU  ดำ-น้ำเงิน",
    "B-O  ดำ-ส้ม",
    "B-P  ดำ-ชมพู",
    "Y-B   เหลืองดำ",
    "G-B   เทา-ดำ",
    "GNB  เขียว-ดำ",
    "RED   แดง",
    "R-B   แดง-ดำ",
    "R-S   แดง-เงิน",
    "R-W  แดง-ขาว",
    "BUE   น้ำเงิน",
    "BUS   น้ำเงิน-เทา",
    "BUB   น้ำเงิน-ดำ",
    "BUR   น้ำเงิน-แดง",
    "BUG   น้ำเงิน-เทา",
    "EBU   ฟ้า-น้ำเงิน",
    "WHT   ขาว",
    "WBU   ขาว-น้ำเงิน",
    "W-B    ขาว-ดำ",
    "W-R   ขาว-แดง",
    "GNW   เขียว-ขาว",
    "O-W    ส้ม-ขาว",
    "SBW    ฟ้า-ขาว",
    "P-W     ชมพู-ขาว",
    "SLV    เทา",
    "S-R    เทา-แดง",
    "S-B    เทา-ดำ",
    "S-Y    เทา-เหลือง",
    "SBU   เทา--น้ำเงิน",
    "S-O   เทา-ส้ม",
    "P-G   ชมพู-เทา"

];

$arr_month=["","มกราคม",'กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฏาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'];
function rewriteLink1($title)
{
    $link = str_replace("%20", " ", $title);
    return $link;
}

function DateThai($strDate)
{
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour = date("H", strtotime($strDate));
    $strMinute = date("i", strtotime($strDate));
    $strSeconds = date("s", strtotime($strDate));
    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
}





function load_web()
{
    include("app/conDB.php");
    $sqli = $conn->query("SELECT * FROM `tbl_web` where id='1'");
    $arr = [];
    $n = 0;
    $arr['num_data']=$sqli->num_rows;
    while ($row = $sqli->fetch_assoc()) {
        $arr[$n]['id'] = $row['id'];
        $arr[$n]['address_th'] = $row['address_th'];
        $arr[$n]['address_en'] = $row['address_en'];
        $arr[$n]['address_ch'] = $row['address_ch'];
        $arr[$n]['phone'] = $row['phone'];
        $arr[$n]['phone2'] = $row['phone2'];
        $arr[$n]['email'] = $row['email'];
        $arr[$n]['facebook'] = $row['facebook'];
        $arr[$n]['twitter'] = $row['twitter'];
        $arr[$n]['ig'] = $row['ig'];
        $arr[$n]['line'] = $row['line'];
        $arr[$n]['map'] = $row['map'];
        $n++;
    }

    return $arr;
}
