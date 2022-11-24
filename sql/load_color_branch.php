<?php
 require("../conf.php");

    $arr=array();
        $id=$_POST['id'];
        $branch_id=$_POST['branch_id'];
       $n=0;
      
       $s=$conn->query("SELECT `color_id` FROM `tbl_order` WHERE `code`='$id' AND `branch_order`='$branch_id' GROUP BY `color_id`");
       while($r=$s->fetch_assoc())
       {
          $ids=$r['color_id'];
          $sqli=$conn->query("SELECT `id`, `mainID`, `color_id`, `color`, `unit` FROM `tbl_motorcycle_color` WHERE `id`='$ids'");
          while ($row=$sqli->fetch_assoc()) {
             $arr[$n]['id']=$row['id'];
             $arr[$n]['mainID']=$row['mainID'];
             $arr[$n]['color_id']=$row['color_id'];
             $arr[$n]['color']=$row['color'];
             $arr[$n]['unit']=$row['unit']; 
             $n++;
          }
       }

    


       
        $arr['num_data']=$n;

       
       
  echo json_encode($arr);

?>