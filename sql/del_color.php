<?php
 require("../conf.php");

    $arr=array();
        $color_id=$_POST['ids'];
       
        $conn->query("DELETE FROM `tbl_order` WHERE `color_id`='$color_id'");
        $conn->query("DELETE FROM `tbl_motorcycle_color` WHERE `color_id`='$color_id'");
        $conn->query("DELETE FROM `motorcycle_color_center` WHERE `color_id`='$color_id'");

        
  echo json_encode($arr);

?>