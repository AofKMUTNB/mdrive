<?php 
require("conf.php");


$act=$_REQUEST['act'];

switch ($act) {
	case 'login':
                        $username=$_POST['username'];
                    $password=$_POST['password'];

                    $sql="SELECT * FROM `tbl_employee` WHERE (`username`='$username' or  `email`='$username') and `password`='$password' ";
                    $arr=array();
                    $result_numpage=$conn->query($sql);
                    $num_data=$result_numpage->num_rows;
                    $arr['num_data']=$num_data;
                    $arr['sql']=$sql;

                    if ($num_data > 0) {
                        $arr['tus']="success";

                        while ($row=$result_numpage->fetch_assoc()) {
                            $user_id=$row['id'];
                            $datenow=date("Y-m-d H:i:s");
                            $conn->query("INSERT INTO `tbl_log`(`user_id`, `date_time`) VALUES ('$user_id','$datenow')");
                            $_SESSION['user-id']=$row['id'];
                            $_SESSION['user-type']=$row['position'];
                            $_SESSION['user-branch']=$row['branch'];
                            $_SESSION['user-fullname']=$row['name']." ".$row['surname'];
                           
                        }

                    }else {
                        $arr['tus']="error";
                    }
                        echo json_encode($arr);

	break;
	
    case 'form_add_employee':
        $arr=array();
            $firstname=$_POST['firstname'];
            $surname=$_POST['surname'];
            $phone=$_POST['phone'];
            $email=$_POST['email'];
           
            $position=$_POST['position'];
            $branch_id=$_POST['branch_id'];
            $username=$_POST['username'];
            $password=$_POST['password'];
            $sql=$conn->query("SELECT * FROM `tbl_employee` WHERE `username`='$username'");
            if($sql->num_rows>0)
            {
                $arr['status']="error";

            }else{
                $arr['status']="success";
                $conn->query("INSERT INTO `tbl_employee`( `name`, `surname`, `phone`, `position`, `branch`, `email`, `username`, `password`) VALUES ('$firstname','$surname','$phone','$position','$branch_id','$email','$username','$password')");

            }
      echo json_encode($arr);

	break;
    
    
    
    
    case 'form_edit_employee':
        $arr=array();
            $user_id=$_POST['user_id'];
            $firstname=$_POST['firstname'];
            $surname=$_POST['surname'];
            $phone=$_POST['phone'];
            $email=$_POST['email'];
          
            $position=$_POST['position'];
            $branch_id=$_POST['branch_id'];
            $username=$_POST['username'];
            $password=$_POST['password'];
            $sql=$conn->query("SELECT * FROM `tbl_employee` WHERE `username`='$username' and id!='$user_id'");
            if($sql->num_rows>0)
            {
                $arr['status']="error";

            }else{
                $arr['status']="success";
                $conn->query("UPDATE `tbl_employee` SET `name`='$firstname',`surname`='$surname',`phone`='$phone',`position`='$position',`branch`='$branch_id',`email`='$email',`username`='$username',`password`='$password' WHERE `id`='$user_id'");


            }
      echo json_encode($arr);

    break;
    


    case 'form_edit_profile':
        $arr=array();
            $user_id=$_SESSION['user-id'];
            $firstname=$_POST['firstname'];
            $surname=$_POST['surname'];
            $phone=$_POST['phone'];
            $email=$_POST['email'];
            $username=$_POST['username'];
            $password=$_POST['password'];
            $sql=$conn->query("SELECT * FROM `tbl_employee` WHERE `username`='$username' and id!='$user_id'");
            if($sql->num_rows>0)
            {
                $arr['status']="error";

            }else{
                $arr['status']="success";
                $conn->query("UPDATE `tbl_employee` SET `name`='$firstname',`surname`='$surname',`phone`='$phone',`email`='$email',`username`='$username',`password`='$password' WHERE `id`='$user_id'");
                $_SESSION['user-fullname']=$firstname." ".$surname;


            }
      echo json_encode($arr);

	break;
    
    
    
    case 'form_add_zone':
        $arr=array();
            $zone_name=$_POST['zone_name'];
            $conn->query("INSERT INTO `tbl_zone`(`zone_name`) VALUES ('$zone_name')");

      echo json_encode($arr);

	break;
    case 'read_noti':
        $arr=array();
            $ids=$_POST['ids'];
            $conn->query("UPDATE `tbl_notication` SET `statis`='1' WHERE `id`='$ids'");

      echo json_encode($arr);

	break;
    case 'form_edit_zone':
        $arr=array();
            $id=$_POST['id'];
            $zone_name=$_POST['zone_name'];
            $conn->query("UPDATE `tbl_zone` SET `zone_name`='$zone_name' WHERE `id`='$id'");

      echo json_encode($arr);

	break;
    case 'form_add_branch':
        $arr=array();
            $zone_id=$_POST['zone_id'];
            $branch_name=$_POST['branch_name'];
            $conn->query("INSERT INTO `tbl_branch`( `zone_id`, `branch_name`) VALUES ('$zone_id','$branch_name')");

      echo json_encode($arr);

	break;
    case 'form_edit_branch':
        $arr=array();
            $id=$_POST['id'];
            $zone_id=$_POST['zone_id'];
            $branch_name=$_POST['branch_name'];
            $conn->query("UPDATE `tbl_branch` SET `zone_id`='$zone_id',`branch_name`='$branch_name' WHERE `id`='$id'");

      echo json_encode($arr);

	break;
    
    
    case 'form_add_mortor':
        $arr=array();
            $name=$_POST['name'];
            $code=$_POST['code'];
            $brand=$_POST['brand'];
            $type=$_POST['type'];
            $branch_id=$_POST['branch_id'];
            $conn->query("INSERT INTO `tbl_motorcycle`( `type`, `brand`, `name`, `code`, `branch_id`) VALUES ('$type','$brand','$name','$code','$branch_id')");
            $sqli=$conn->query("SELECT `id` FROM `tbl_motorcycle` WHERE `code`='$code' and `branch_id`='$branch_id' ORDER BY `id` DESC");
            list($last_id)=mysqli_fetch_row($sqli);
            for ($i=1; $i < 7; $i++) { 
                if(!empty($_POST['color'][$i]) && !empty($_POST['unit'][$i]))
            {
                $color=$_POST['color'][$i];
                if(empty($_POST['unit'][$i])){$unit=0;}else{$unit=$_POST['unit'][$i];}
                
                $conn->query("INSERT INTO `tbl_motorcycle_color`( `mainID`, `color`,`color_id`,`unit`) VALUES ('$last_id','$color','$i','$unit')");
            }else{
                $conn->query("INSERT INTO `tbl_motorcycle_color`( `mainID`, `color`,`color_id`,`unit`) VALUES ('$last_id','','$i','0')"); 
            }
            }
           
      echo json_encode($arr);

    break;
    
    case 'form_edit_mortor':
        $arr=array();
            $mortor_id=$_POST['mortor_id'];
            $name=$_POST['name'];
            $code=$_POST['code'];
            $brand=$_POST['brand'];
            $type=$_POST['type'];
            $conn->query("UPDATE `tbl_motorcycle` SET `type`='$type',`brand`='$brand',`name`='$name',`code`='$code' WHERE `id`='$mortor_id'");
           
            for ($i=1; $i < 7; $i++) { 
              $idcolor=$_POST['idcolor'][$i];
              $color=$_POST['color'][$i];
              if(!empty($_POST['color'][$i]))
              {
                if(empty($_POST['unit'][$i])){$unit=0;}else{$unit=$_POST['unit'][$i];}
                $conn->query("UPDATE `tbl_motorcycle_color` SET `color`='$color',`unit`='$unit' WHERE `id`='$idcolor'");

              }
             
            }
           
      echo json_encode($arr);

	break;
   
    case 'form_order':
        $arr=array();
        $myid=$_SESSION['user-id'];

            $getunit=$_POST['getunit'];
            $motor_id=$_POST['motor_id'];
            $color_id=$_POST['color_id'];
            if(empty($_POST['note']))
            {
                $note="ไม่ระบุ";

            }else{
                $note=$_POST['note'];

            }
           $sqli1=$conn->query("SELECT `type`,`brand`,`name`,`code`,`branch_id` FROM `tbl_motorcycle` WHERE `id`='$motor_id'");
           list($type,$brand,$name,$code,$branch_delivery)=mysqli_fetch_row($sqli1);

         if(empty($_POST['branch_id']))
         {
           $sqli2=$conn->query("SELECT `branch` FROM `tbl_employee` WHERE `id`='$myid'");
           list($branch_order)=mysqli_fetch_row($sqli2);
         }else{
             $branch_order=$_POST['branch_id'];
         }
         $sqli4=$conn->query("SELECT `color` FROM `tbl_motorcycle_color` WHERE `id`='$color_id'");
         list($color)=mysqli_fetch_row($sqli4);
         //เช็๕ว่าในสาขามีรถคันนี้รึยัง ถ้าไม่มี ให้แสดง error ถ้ามีให้ทำการสั่งจองได้
         $sqli3=$conn->query("SELECT `id` FROM `tbl_motorcycle` WHERE `branch_id`='$branch_order' and `code`='$code'");
         if($sqli3->num_rows>0)
         {
             list($ids)=mysqli_fetch_row($sqli3);
           
             $sqli5=$conn->query("SELECT `id` FROM `tbl_motorcycle_color` WHERE `color`='$color' and  `mainID`='$ids'");
             if($sqli5->num_rows>0)
             {
                $date_now=date("Y-m-d H:i:s");
                $conn->query("INSERT INTO `tbl_order`( `branch_order`, `branch_delivery`, `motor_id`, `brand`, `code`, `color_id`, `unit`, `status`, `date_order`, `note`,`user_id`) VALUES ('$branch_order','$branch_delivery','$motor_id','$brand','$code','$color_id','$getunit','wait_confirm','$date_now','$note','$myid')");
                  
       
             }else{
                // $arr['status']="error1";
             $conn->query("INSERT INTO `tbl_motorcycle_color`(  `mainID`, `color_id`, `color`, `unit`) VALUES ('$ids','$color_id','$color','0')");
             $date_now=date("Y-m-d H:i:s");
             $conn->query("INSERT INTO `tbl_order`( `branch_order`, `branch_delivery`, `motor_id`, `brand`, `code`, `color_id`, `unit`, `status`, `date_order`, `note`,`user_id`) VALUES ('$branch_order','$branch_delivery','$motor_id','$brand','$code','$color_id','$getunit','wait_confirm','$date_now','$note','$myid')");
               

             }


           
         }else{
             $conn->query("INSERT INTO `tbl_motorcycle`(  `type`, `brand`, `name`, `code`, `branch_id`, `motor_id`) VALUES ('$type','$brand','$name','$code','$branch_order','$motor_id')");
             $sqli4=$conn->query("SELECT max(`id`) FROM `tbl_motorcycle` WHERE `branch_id`='$branch_order' ");
             list($max_id)=mysqli_fetch_row($sqli4);
             $conn->query("INSERT INTO `tbl_motorcycle_color`(  `mainID`, `color_id`, `color`, `unit`) VALUES ('$max_id','$color_id','$color','0')");
             $date_now=date("Y-m-d H:i:s");
                $conn->query("INSERT INTO `tbl_order`( `branch_order`, `branch_delivery`, `motor_id`, `brand`, `code`, `color_id`, `unit`, `status`, `date_order`, `note`,`user_id`) VALUES ('$branch_order','$branch_delivery','$motor_id','$brand','$code','$color_id','$getunit','wait_confirm','$date_now','$note','$myid')");
            // $arr['status']="error2";
         }


        
      echo json_encode($arr);

	break;
    
    
    
    case 'form_order_edit':
        $arr=array();
            $getunit=$_POST['getunit'];
            $order_id=$_POST['order_id'];
            if(empty($_POST['note']))
            {
                $note="ไม่ระบุ";

            }else{
                $note=$_POST['note'];

            }
         if(!empty($_POST['branch_id']))
         {
            $branch_delivery=$_POST['branch_id'];
            $txt=",`branch_order`='$branch_delivery'";
         }else{
            $txt="";

         }
            $date_now=date("Y-m-d");
         $conn->query("UPDATE `tbl_order` SET `unit`='$getunit',`note`='$note' $txt WHERE `id`='$order_id'");
           
      echo json_encode($arr);

	break;
    
    
    
    
    case 'form_confirm':
        $arr=array();
            $order_id=$_POST['order_id'];
            $note=$_POST['note'];
            $myid=$_SESSION['user-id'];
            $datetimenow=date("Y-m-d H:i:s");

            $sqli=$conn->query("SELECT `branch_order`,`branch_delivery`,`color_id`,`unit`,`motor_id`,`code` FROM `tbl_order` WHERE `id`='$order_id'");
            list($branch_order,$branch_delivery,$color_id,$unit,$motor_id,$code)=mysqli_fetch_row($sqli);


            //อัพเดทตัดสต๊อคสาขาส่ง
            $sqli1=$conn->query("SELECT `unit`,`color` FROM `tbl_motorcycle_color` WHERE `id`='$color_id'");
            list($last_unit,$color)=mysqli_fetch_row($sqli1);
            if($last_unit>=$unit)
            {
                $newunit=$last_unit-$unit;
                $conn->query("UPDATE `tbl_motorcycle_color` SET `unit`='$newunit' WHERE `id`='$color_id' ");
               
               
                $sqli1=$conn->query("SELECT `id` FROM `tbl_motorcycle` WHERE `branch_id`='$branch_order' and `code`='$code'");
                list($id_motor)=mysqli_fetch_row($sqli1);
                $sqli1=$conn->query("SELECT `id`,`unit` FROM `tbl_motorcycle_color` WHERE `mainID`='$id_motor' and `color`='$color'");
                list($id_color,$last_unit2)=mysqli_fetch_row($sqli1);
                $newunit2=$last_unit2+$unit;
                $conn->query("UPDATE `tbl_motorcycle_color` SET `unit`='$newunit2' WHERE `id`='$id_color' ");
    
    
    
             $conn->query("UPDATE `tbl_order` SET `status`='confirm' WHERE `id`='$order_id'");
             $conn->query("INSERT INTO `tbl_accept`( `order_id`, `user_id`, `status`, `note`, `date_accept`) VALUES ('$order_id','$myid','confirm','$note','$datetimenow')");
             $arr['tus']="success";

            }else{
             $arr['tus']="error";

            }
           
           
      echo json_encode($arr);

	break;
    case 'form_failed':
        $arr=array();
            $order_id=$_POST['order_id'];
            $note=$_POST['note'];
            $myid=$_SESSION['user-id'];
            $datetimenow=date("Y-m-d H:i:s");
         
         $conn->query("UPDATE `tbl_order` SET `status`='failed' WHERE `id`='$order_id'");
         $conn->query("INSERT INTO `tbl_accept`( `order_id`, `user_id`, `status`, `note`, `date_accept`) VALUES ('$order_id','$myid','failed','$note','$datetimenow')");
           
      echo json_encode($arr);

	break;
    case 'to_delivery':
        $arr=array();
            $order_id=$_POST['order_id'];
            $myid=$_SESSION['user-id'];
            $datetimenow=date("Y-m-d H:i:s");
         $conn->query("UPDATE `tbl_order` SET `status`='delivery' WHERE `id`='$order_id'");
         $conn->query("INSERT INTO `tbl_accept`( `order_id`, `user_id`, `status`, `note`, `date_accept`) VALUES ('$order_id','$myid','delivery','','$datetimenow')");
           
      echo json_encode($arr);

	break;
    case 'to_success':
        $arr=array();
            $order_id=$_POST['order_id'];
            $myid=$_SESSION['user-id'];
            $datetimenow=date("Y-m-d H:i:s");
         $conn->query("UPDATE `tbl_order` SET `status`='success' WHERE `id`='$order_id'");
         $conn->query("INSERT INTO `tbl_accept`( `order_id`, `user_id`, `status`, `note`, `date_accept`) VALUES ('$order_id','$myid','success','','$datetimenow')");
           
      echo json_encode($arr);

    break;
    
    
    case 'show_chart':
                $my_branch=$_POST['my_branch'];
                $m_stop=$_POST['m_stop'];
                $year=$_POST['year'];
                $brand=$_POST['brand'];
                $code_id=$_POST['code_id'];
                $color=$_POST['color'];
                $year=$year-543;
                if($code_id=="all")
                {
                    $result = $conn->query("SELECT sum(a.unit) as unit,b.name,c.color,MONTH(a.date_order)  as month FROM `tbl_order` a inner join tbl_motorcycle b on a.motor_id=b.id inner join tbl_motorcycle_color c on a.color_id=c.id where a.branch_order='$my_branch' and a.brand='$brand' and a.status='success' and ((MONTH(a.date_order) BETWEEN '$m_start' and '$m_stop' ) and YEAR(a.date_order)='$year') group by MONTH(a.date_order) ");
                }else{
                    if($color=="all")
                    {
                        $result = $conn->query("SELECT sum(a.unit) as unit,b.name,c.color,MONTH(a.date_order)  as month FROM `tbl_order` a inner join tbl_motorcycle b on a.motor_id=b.id inner join tbl_motorcycle_color c on a.color_id=c.id where a.branch_order='$my_branch' and a.brand='$brand' and a.code='$code_id' and a.status='success' and ((MONTH(a.date_order) BETWEEN '$m_start' and '$m_stop' ) and YEAR(a.date_order)='$year') group by MONTH(a.date_order) ");
                    }else{
                        $result = $conn->query("SELECT sum(a.unit) as unit,b.name,c.color,MONTH(a.date_order)  as month FROM `tbl_order` a inner join tbl_motorcycle b on a.motor_id=b.id inner join tbl_motorcycle_color c on a.color_id=c.id where a.branch_order='$my_branch' and a.brand='$brand' and a.code='$code_id' and a.color_id='$color' and a.status='success' and ((MONTH(a.date_order) BETWEEN '$m_start' and '$m_stop' ) and YEAR(a.date_order)='$year') group by MONTH(a.date_order) ");
                        
                    }

                }
        

        $data = array();
        foreach ($result as $row) {
            $data[] = $row;
        }
        echo json_encode($data); 

    break;
    case 'show_chart2':
                $my_branch=$_POST['my_branch'];
                $year=$_POST['year'];
                $brand=$_POST['brand'];
                $code_id=$_POST['code_id'];
                $color=$_POST['color'];
                $year=$year-543;
        $data = array();
        if($brand=="all")
        {
            $txtbrand="(a.brand='HONDA' or a.brand='YAMAHA' )";


        }else{
            $txtbrand="a.brand='$brand'";

        }

                if($code_id=="all")
                {
                    for ($i=1; $i <13 ; $i++) { 
                        $result = $conn->query("SELECT sum(a.unit) as unit,b.name,c.color,MONTH(a.date_order)  as month FROM `tbl_order` a inner join tbl_motorcycle b on a.motor_id=b.id inner join tbl_motorcycle_color c on a.color_id=c.id where a.branch_order='$my_branch' and $txtbrand and a.status='success' and ( YEAR(a.date_order)='$year' and MONTH(a.date_order)='$i') group by MONTH(a.date_order) ");
                         if($result->num_rows>0)
                         {
                            while ($row = $result->fetch_assoc()) {
                                array_push($data,$row);
                            }
                         }else{
                             $row=[
                                "unit"=>0,
                                "name"=>"",
                                "color"=>"",
                                "month"=>$i,
                             ]; 
                             array_push($data,$row);
                         }
                         
                    }
                  
                }else{
                    if($color=="all")
                    {

                        for ($i=1; $i <13 ; $i++) { 
                            $result = $conn->query("SELECT sum(a.unit) as unit,b.name,c.color,MONTH(a.date_order)  as month FROM `tbl_order` a inner join tbl_motorcycle b on a.motor_id=b.id inner join tbl_motorcycle_color c on a.color_id=c.id where a.branch_order='$my_branch' and  $txtbrand and a.code='$code_id' and a.status='success' and (  YEAR(a.date_order)='$year' and MONTH(a.date_order)='$i') group by MONTH(a.date_order) ");
                             if($result->num_rows>0)
                             {
                                while ($row = $result->fetch_assoc()) {
                                    array_push($data,$row);
                                }
                             }else{
                                 $row=[
                                    "unit"=>0,
                                    "name"=>"",
                                    "color"=>"",
                                    "month"=>$i,
                                 ]; 
                                 array_push($data,$row);
                             }
                             
                        }
                        
                    }else{
                        for ($i=1; $i <13 ; $i++) { 
                            $result = $conn->query("SELECT sum(a.unit) as unit,b.name,c.color,MONTH(a.date_order)  as month FROM `tbl_order` a inner join tbl_motorcycle b on a.motor_id=b.id inner join tbl_motorcycle_color c on a.color_id=c.id where a.branch_order='$my_branch' and  $txtbrand and a.code='$code_id' and a.color_id='$color' and a.status='success' and (  YEAR(a.date_order)='$year'  and MONTH(a.date_order)='$i') group by MONTH(a.date_order) ");
                            if($result->num_rows>0)
                            {
                               while ($row = $result->fetch_assoc()) {
                                   array_push($data,$row);
                               }
                            }else{
                                $row=[
                                   "unit"=>0,
                                   "name"=>"",
                                   "color"=>"",
                                   "month"=>$i,
                                ]; 
                                array_push($data,$row);
                            }
                            }

                       
                        
                    }

                }
        

        // foreach ($result as $row) {
        //     $data[] = $row;
        // }
        echo json_encode($data); 

    break;
  
  
    case 'show_chart3':
                $my_branch=$_POST['my_branch'];
                $year=$_POST['year'];
                $brand=$_POST['brand'];
                $code_id=$_POST['code_id'];
                $color=$_POST['color'];
                $year=$year-543;
                $data = array();
                if($brand=="all")
                {
                    $txtbrand="(a.brand='HONDA' or a.brand='YAMAHA' )";
        
        
                }else{
                    $txtbrand="a.brand='$brand'";
        
                }


                if($code_id=="all")
                {
                    for ($i=$year; $i >($year-6) ; $i--) { 
                        $result = $conn->query("SELECT sum(a.unit) as unit,b.name,c.color,YEAR(a.date_order)  as year FROM `tbl_order` a inner join tbl_motorcycle b on a.motor_id=b.id inner join tbl_motorcycle_color c on a.color_id=c.id where a.branch_order='$my_branch' and $txtbrand and a.status='success' and ( YEAR(a.date_order)='$i'  ) group by YEAR(a.date_order) ");
                         if($result->num_rows>0)
                         {
                            while ($row = $result->fetch_assoc()) {
                                array_push($data,$row);
                            }
                         }else{
                             $row=[
                                "unit"=>0,
                                "name"=>"",
                                "color"=>"",
                                "year"=>$i,
                             ]; 
                             array_push($data,$row);
                         }
                         
                    }
                  
                }else{
                    if($color=="all")
                    {

                        for ($i=$year; $i >($year-6) ; $i--) { 
                            $result = $conn->query("SELECT sum(a.unit) as unit,b.name,c.color,YEAR(a.date_order)  as year FROM `tbl_order` a inner join tbl_motorcycle b on a.motor_id=b.id inner join tbl_motorcycle_color c on a.color_id=c.id where a.branch_order='$my_branch' and $txtbrand and a.code='$code_id' and a.status='success' and (  YEAR(a.date_order)='$i'  ) group by YEAR(a.date_order) ");
                             if($result->num_rows>0)
                             {
                                while ($row = $result->fetch_assoc()) {
                                    array_push($data,$row);
                                }
                             }else{
                                 $row=[
                                    "unit"=>0,
                                    "name"=>"",
                                    "color"=>"",
                                    "year"=>$i,
                                 ]; 
                                 array_push($data,$row);
                             }
                             
                        }
                        
                    }else{
                        for ($i=$year; $i >($year-6) ; $i--) { 
                            $result = $conn->query("SELECT sum(a.unit) as unit,b.name,c.color,YEAR(a.date_order)  as year FROM `tbl_order` a inner join tbl_motorcycle b on a.motor_id=b.id inner join tbl_motorcycle_color c on a.color_id=c.id where a.branch_order='$my_branch' and $txtbrand and a.code='$code_id' and a.color_id='$color' and a.status='success' and (  YEAR(a.date_order)='$i' ) group by YEAR(a.date_order) ");
                            if($result->num_rows>0)
                            {
                               while ($row = $result->fetch_assoc()) {
                                   array_push($data,$row);
                               }
                            }else{
                                $row=[
                                   "unit"=>0,
                                   "name"=>"",
                                   "color"=>"",
                                   "year"=>$i,
                                ]; 
                                array_push($data,$row);
                            }
                            }

                       
                        
                    }

                }
        

        // foreach ($result as $row) {
        //     $data[] = $row;
        // }
        echo json_encode($data); 

    break;
    


    case 'check_my_order':
        $data = array();

                $my_branch=$_SESSION['user-branch'];
                $sqli=$conn->query("SELECT `id` FROM `tbl_order` WHERE `branch_delivery`='$my_branch' and (`status`='wait_confirm' or `status`='confirm')");
                $arr['num_data']=$sqli->num_rows;


        echo json_encode($arr);

	break;
    case 'load_code':
        $arr = array();
        $brand=$_POST['brand'];

        $sqli = $conn->query("SELECT `code`,`name` FROM `motorcycle_center` where `brand`='$brand' group by `code`");

        $arr['num_data']=$sqli->num_rows;
        while ($row = $sqli->fetch_assoc()) {
            array_push($arr,$row);
        }


        echo json_encode($arr);

	break;
	
	
	
	

	



	
	case 'del_data': $ids=$_POST['ids'];
	$types=$_POST['types'];

	if($types=="1") {
		
		$conn->query("DELETE FROM `tbl_employee` WHERE `id`='$ids'");
    }else if($types=="2")
    {
        $sqli=$conn->query("SELECT `id` FROM `tbl_branch` WHERE `zone_id`='$ids'");
        while ($row=$sqli->fetch_assoc()) {
            $branch_id=$row['id'];
            $myid=$_SESSION['user-id'];
		    $conn->query("DELETE FROM `tbl_employee` WHERE `branch`='$branch_id' and id !='$myid'");
        }
		$conn->query("DELETE FROM `tbl_branch` WHERE `zone_id`='$ids'");
		$conn->query("DELETE FROM `tbl_zone` WHERE `id`='$ids'");

    }else if($types=="3")
    {
        $myid=$_SESSION['user-id'];
        $conn->query("DELETE FROM `tbl_employee` WHERE `branch`='$ids' and id !='$myid'");
		$conn->query("DELETE FROM `tbl_branch` WHERE `zone_id`='$ids'");

    }else if($types=="4")
    {
		$conn->query("DELETE FROM `tbl_motorcycle_color` WHERE `mainID`='$ids'");
		$conn->query("DELETE FROM `tbl_motorcycle` WHERE `id`='$ids'");

    }else if($types=="5")
    {
		$conn->query("DELETE FROM `tbl_order` WHERE `id`='$ids'");

    }else if($types=="6")
    {
		$conn->query("DELETE FROM `tbl_log` WHERE `id`='$ids'");

    }else if($types=="7")
    {
		$conn->query("DELETE FROM `tbl_log` ");

    }
	
	
	
	
	

	break;







	case 'logout':
		unset($_SESSION['user-id']);
		unset($_SESSION['user-type']);
		unset($_SESSION['user-branch']);
		unset($_SESSION['user-fullname']);
		break;







		


}