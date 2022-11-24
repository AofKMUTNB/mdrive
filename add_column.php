
<?php
$id=$_POST['id']+1;

echo '<div class="col-lg-2 form-group" id="c'.$id.'">
<span>สี </span>
<input type="text" class="form-control" id="color['.$id.']" name="color['.$id.']" required>

<span>จำนวน </span>
<div class="row">
    <div class="col-md-3 col-2 text-right p-0 pr-2">
        <a onclick="minus('.$id.')"><span class="fa fa-minus-square f20 mt-2"></span></a>
    </div>
    <div class="col-md-6 col-8 p-0  text-center">
        <input type="number" class="form-control" name="unit['.$id.']" id="unit'.$id.'" min="1" value="0" required>
    </div>
    <div class="col-md-3 col-2 text-left p-0 pl-2">
        <a onclick="plus('.$id.')"><span class="fa fa-plus-square f20 mt-2"></span></a>
    </div>
    <div class="col-12 text-center mt-2">
    <button class="btn btn-danger" onclick="del_column('.$id.')" type="button"><span class="fa fa-trash"></span></button>
    </div>

</div>
</div>';
?>

