<!doctype html>
<html class="no-js" lang="en">
<?php
include("conf.php");

if(!empty($_SESSION['user-id'])){echo "<script>window.location='index.php'</script>";}

?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title> M DRIVE – เอ็มไดร์ฟ ฮอนด้า ธนบุรี</title>

    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">

    <!-- all css here -->
    <!-- bootstrap v3.3.6 css -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- animate css -->
    <link rel="stylesheet" href="css/animate.css">
    <!-- meanmenu css -->
    <link rel="stylesheet" href="css/meanmenu.min.css">
    <!-- owl.carousel css -->
    <link rel="stylesheet" href="css/owl.carousel.css">
    <!-- font-awesome css -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- flexslider.css-->
    <link rel="stylesheet" href="css/flexslider.css">
    <!-- chosen.min.css-->
    <link rel="stylesheet" href="css/chosen.min.css">
    <!-- style css -->
    <link rel="stylesheet" href="style.css">
    <!-- responsive css -->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- modernizr css -->
    <script src="js/vendor/modernizr-2.8.3.min.js"></script>
    <script src="sweetalert2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="sweetalert2/dist/sweetalert2.min.css">
    <script src="controller.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>

<body class="home-6">
    <!-- header-area-start -->
    <header>

        <div class="header-mid-area ptb-40">
            <div class="container">
                <div class="row">

                    <div class="col-lg-12">
                        <div class="logo-area text-center logo-xs-mrg">
                            <a href="index.php"><img src="img/logo/5.png" alt="logo" /></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </header>

    <div class="user-login-area mt-40 mb-40">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="login-title text-center mb-30">
                        <h2>ลืมรหัสผ่าน</h2>
                        <p>กรุณากรอก Username เพื่อรับรหัสผ่านของท่าน</p>
                    </div>
                </div>
                <div class="offset-lg-3 col-lg-6 col-md-12 col-12">
                    <div class="login-form">
                        <div class="single-login">
                            <label>Username<span>*</span></label>
                            <input type="text" name="username" id="username" />
                        </div>
                        
                        <div class="single-login single-login-2">
                            <a onclick="forget_password()" id="txt1">ส่งรหัสผ่าน</a>
                           
                        </div>
                        <a href="login.php">เข้าสู่ระบบ?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- user-login-area-end -->
    <!-- footer-area-start -->
    <?php
    include("footer.php");

    ?>



    <script>
        function forget_password() {
                if ($("#email").val() == "") {
                    $("#email").focus();
                    return false;
                } else {
                    $("#txt1").html("กำลังโหลด...");
                    $.ajax({
                        url: "send_mail/forget_password.php",
                        type: "POST",
                        data: {
                            act: "forget_password",
                            username: $("#username").val()
                        },
                        success: function (data) {
                            console.log(data);

                           var obj=JSON.parse(data);

                            if(obj.tus=="error")
                            {
                                alert_success(
                                    "error",
                                    "Not Found",
                                    "ระบบไม่สามารถส่งรหัสไปยังอีเมลได้ กรุณาติดต่อแอดมินหรือลองใหม่อีกครั้ง",
                                    "false"
                                );
                                 $("#txt1").html("ส่งรหัสผ่าน");

                            }else{
                                alert_success(
                                    "success",
                                    "Success",
                                    "ระบบได้ส่งรหัสผ่านไปยัง "+obj.tus+" เรียบร้อยแล้ว",
                                    "login.php"
                                );
                            }
                            
                        }
                    });

                }

            }
    </script>