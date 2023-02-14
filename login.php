<!doctype html>
<html class="no-js" lang="en">
<?php
include("conf.php");
// if(!empty($_SESSION['user-id'])){echo "<script>window.location='index.php'</script>";}

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
    <!-- header-area-start --> <!--ส่วนหัว-->
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
                        <h2>เข้าสู่ระบบ</h2>
                        <p>กรุณาเข้าสู่ระบบ เพื่อเข้าใช้งานระบบแอปพลิเคชันตรวจสอบคลังและสั่งจองรถจักรยานยนต์</p>
                    </div>
                </div>
                <div class="offset-lg-3 col-lg-6 col-md-12 col-12">
                    <div class="login-form">
                        <div class="single-login">
                            <label><h6>Username or email<span>*</span></h6></label>
                            <input type="text" name="username" id="username" />
                        </div>
                        <div class="single-login">
                            <label><h6>Passwords <span>*</span></h6></label>
                            <input type="password" name="password"  id="password" class="inputpsw" />
                            <i class="fa fa-eye buttonview"></i>
                        </div>
                        <div class="single-login single-login-2 text-center">
                            <a onclick="login()">login</a>  <br>
                            <input id="rememberme" type="checkbox" name="rememberme" value="forever">
                            <span>Remember me</span>
                        </div>
                        <div class="text-center">
                        <a href="forget_password.php">ลืมรหัสผ่าน?</a></div>
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
 
        function login() {
                if ($("#username").val() == "") {
                    $("#username").focus();
                    return false;
                } else if ($("#password").val() == "") {
                    $("#password").focus();
                    return false;
                } else {
                    $.ajax({ 
                        url: "sql.php",
                        type: "POST",
                        data: {
                            act: "login",
                            username: $("#username").val(),
                            password: $("#password").val()
                        },
                        success: function (data) {
                            var obj = JSON.parse(data);
                            if (obj.tus == "success") {
                                alert_success(
                                    "success",
                                    "Success",
                                    "ยินดีต้อนรับเข้าสู่ระบบ ",
                                    "check_user.php"
                                );

                            } else {
                                alert_success("error", "Not Found", "Username หรือ Password ไม่ถูกต้อง", "false");


                            }
                        }
                    });

                }

            }

$('.buttonview').on('click', function() { $('.inputpsw').attr('type', 'text'); })
    .on('mouseout', function() { $('.inputpsw').attr('type', 'password'); });
    </script>
    <style>
    .buttonview{
        position: absolute;
    right: 55px;
    bottom: 170px;
    }


    @media only screen and (max-width: 767.98px) {
        .buttonview{
        position: absolute;
    right: 55px;
    bottom: 170px;
    }
}

    </style>