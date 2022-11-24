<?php
 require("../conf.php");

    $arr=array();
        $id=$_POST['id'];
        $sql=$conn->query("SELECT `stock` FROM `motorcycle_color_center` WHERE `color_id`='$id'");
        list($stock)=mysqli_fetch_row($sql);
$arr['stock']=$stock;
       
  echo json_encode($arr);

?>