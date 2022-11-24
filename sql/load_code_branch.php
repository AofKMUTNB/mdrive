<?php
 require("../conf.php");

    $arr=array();
        $branch_id=$_POST['branch_id'];
       $n=0;
        $sqli=$conn->query("SELECT `id`, `type`, `brand`, `name`, `code`, `branch_id`, `motor_id` FROM `tbl_motorcycle` WHERE `branch_id`='$branch_id' GROUP BY `code`");
        while ($row=$sqli->fetch_assoc()) {
           $arr[$n]['id']=$row['id'];
           $arr[$n]['type']=$row['type'];
           $arr[$n]['brand']=$row['brand'];
           $arr[$n]['code']=$row['code'];
           $arr[$n]['name']=$row['name'];
           $arr[$n]['branch_id']=$row['branch_id'];
           $arr[$n]['motor_id']=$row['motor_id'];
           $n++;
        }
        $arr['num_data']=$sqli->num_rows;

       
       
  echo json_encode($arr);

?>