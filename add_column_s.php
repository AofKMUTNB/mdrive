
<?php
include("conf.php");
$id=$_POST['id']+1;
$motor_id=$_POST['motor_id'];
$table="<option value=''>เลือก</option>";
$sqli=$conn->query("SELECT `color_id`, `motor_id`, `color_name`, `stock` FROM `motorcycle_color_center` WHERE `motor_id`='$motor_id'");
 while ($row=$sqli->fetch_assoc()) {
    $table.="<option value='".$row['color_id']."'>".$row['color_name']."</option>";
 }



$txt ='<div class="col-lg-2 form-group" id="c'.$id.'">
<span>สี <i id="txt'.$id.'" style="color:red;"></i></span>
<input type="hidden" name="max_unit'.$id.'" id="max_unit'.$id.'" >
<select class="form-control color" id="color'.$id.'" name="color['.$id.']"  onchange="change_color('.$id.')"> 
'.$table.'</select>
<span>จำนวน </span>
<div class="row">
    <div class="col-md-3 col-2 text-right p-0 pr-2">
        <a onclick="minus('.$id.')"><span class="fa fa-minus-square f20 mt-2"></span></a>
    </div>
    <div class="col-md-6 col-8 p-0  text-center">
        <input type="number" class="form-control" onchange="chang_unit('.$id.')" name="unit['.$id.']" id="unit'.$id.'" min="1" value="0" required>
    </div>
    <div class="col-md-3 col-2 text-left p-0 pl-2">
        <a onclick="plus('.$id.')"><span class="fa fa-plus-square f20 mt-2"></span></a>
    </div>
    <div class="col-12 text-center mt-2">
    <button class="btn btn-danger" onclick="del_column('.$id.')" type="button"><span class="fa fa-trash"></span></button>
    </div>

</div>
</div>';
echo $txt;
?>

