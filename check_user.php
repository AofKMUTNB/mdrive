<?php
session_start();
if($_SESSION['user-type']=="admin")
{
    echo "<script>window.location='index.php';</script>";
}else
{
    echo "<script>window.location='motorcycle_list.php';</script>";

}
?>