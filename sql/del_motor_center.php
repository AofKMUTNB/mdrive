<?php
 require("../conf.php");

    $arr=array();
        $motor_id=$_POST['ids'];
       $sql=$conn->query("SELECT `id` FROM `tbl_order` WHERE `motor_id`='$motor_id'");
      if($sql->num_rows>0)
{
    while ($r=$sql->fetch_assoc()) {
        $order_id=$r['id'];
     $conn->query("DELETE FROM `tbl_accept` WHERE `order_id`='$order_id'");

    }
}
       
       $sql2=$conn->query("SELECT `id` FROM `tbl_motorcycle` WHERE `motor_id`='$motor_id'");
      if($sql2->num_rows>0)
      {
        while ($rr=$sql2->fetch_assoc()) {
            $mainID=$rr['id'];
         $conn->query("DELETE FROM `tbl_motorcycle_color` WHERE `mainID`='$mainID'");
        }
      }
        $conn->query("DELETE FROM `tbl_order` WHERE `motor_id`='$motor_id'");
        $conn->query("DELETE FROM `tbl_motorcycle` WHERE `motor_id`='$motor_id'");
        $conn->query("DELETE FROM `motorcycle_color_center` WHERE `motor_id`='$motor_id'");
        $conn->query("DELETE FROM `motorcycle_center` WHERE `id`='$motor_id'");

        
  echo json_encode($arr);

?>