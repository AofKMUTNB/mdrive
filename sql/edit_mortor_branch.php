<?php
 require("../conf.php");

    $arr=array();
        
        $c_color=$_POST['c_color'];
        $branch_id=$_POST['branch_id'];
        $mainID=$_POST['mainID'];
        $datenow=date("Y-m-d H:i:s");

       
        for ($i=1; $i <= $c_color; $i++) { 
            if(!empty($_POST['color'][$i]) && !empty($_POST['unit'][$i]))
                {
                    $color_id=$_POST['color'][$i];
                    $unit=$_POST['unit'][$i];
                    $sqli=$conn->query("SELECT  `color_name`, `stock` FROM `motorcycle_color_center` WHERE `color_id`='$color_id'");
                    list($color_name,$stock)=mysqli_fetch_row($sqli);


                    $ss=$conn->query("SELECT `id` FROM `tbl_motorcycle_color` WHERE `mainID`='$mainID' AND `color_id`='$color_id'");
                    if($ss->num_rows>0)
                    {
                        if(!empty($_POST['color_id'][$i]))
                        {
                            $conn->query("UPDATE `tbl_motorcycle_color` SET `unit`='$unit' WHERE `mainID`='$mainID' AND `color_id`='$color_id'");

                            $colors_id=$_POST['color_id'][$i];
                            $sss=$conn->query("SELECT `unit` FROM `tbl_motorcycle_color` WHERE `id`='$colors_id'");
                            list($last_unit)=mysqli_fetch_row($sss);
                            $addunit=$unit-$last_unit;
                        }else{
                        $conn->query("UPDATE `tbl_motorcycle_color` SET `unit`=`unit`+'$unit' WHERE `mainID`='$mainID' AND `color_id`='$color_id'");

                            $addunit=$unit;
                        }
                       
                    }else{

                        if(!empty($_POST['color_id'][$i]))
                        {
                            $colors_id=$_POST['color_id'][$i];
                            $sss=$conn->query("SELECT `unit` FROM `tbl_motorcycle_color` WHERE `id`='$colors_id'");
                            list($last_unit)=mysqli_fetch_row($sss);
                            $addunit=$unit-$last_unit;
                        $conn->query("UPDATE `tbl_motorcycle_color` SET `color_id`='$color_id',`color`='$color_name',`unit`='$unit' WHERE `id`='$colors_id'");
    
                        }else{
                            $conn->query("INSERT INTO `tbl_motorcycle_color`( `mainID`, `color_id`, `color`, `unit`) VALUES ('$mainID','$color_id','$color_name','$unit')");
                            $sss=$conn->query("SELECT `unit` FROM `tbl_motorcycle_color` WHERE `id`='$color_id'");
                            list($last_unit)=mysqli_fetch_row($sss);
                            $addunit=$unit-$last_unit;
                        }
                    }
                    if($addunit>0)
                    {
                        $conn->query("UPDATE `motorcycle_color_center` SET `stock`=`stock`-'$addunit' WHERE `color_id`='$color_id'");

                    }
                }
        }
       
  echo json_encode($arr);

?>