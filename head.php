<!doctype html>
<html class="no-js" lang="en">
<?php
include("conf.php");
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- Primary Meta Tags -->
<title>M DRIVE – เอ็มไดร์ฟ ฮอนด้า ธนบุรี</title>
<meta name="title" content="M DRIVE – เอ็มไดร์ฟ ฮอนด้า ธนบุรี">
<meta name="description" content="M DRIVE – เอ็มไดร์ฟ ฮอนด้า ธนบุรี">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="https://anirutplodprong.com/login.php">
<meta property="og:title" content="M DRIVE – เอ็มไดร์ฟ ฮอนด้า ธนบุรี">
<meta property="og:description" content="M DRIVE – เอ็มไดร์ฟ ฮอนด้า ธนบุรี">
<meta property="og:image" content="https://anirutplodprong.com/img/logo/5.png">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="https://anirutplodprong.com/login.php">
<meta property="twitter:title" content="M DRIVE – เอ็มไดร์ฟ ฮอนด้า ธนบุรี">
<meta property="twitter:description" content="M DRIVE – เอ็มไดร์ฟ ฮอนด้า ธนบุรี">
<meta property="twitter:image" content="https://anirutplodprong.com/img/logo/5.png">
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
    <link rel="stylesheet" href="style.css?v=1.3">
    <!-- responsive css -->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- modernizr css -->
    <script src="js/vendor/modernizr-2.8.3.min.js"></script>
    <script src="sweetalert2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="sweetalert2/dist/sweetalert2.min.css">
    <script src="controller.js"></script>

    <script src="excellentexport.js"></script>
    <script src="tableHTMLExport.js"></script>

    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/Chart.min.js"></script>



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
        <!-- header-mid-area-end -->
        <!-- main-menu-area-start -->
        <!--เปิดในคอม-->
        <div class="main-menu-area d-md-none d-none d-lg-block" id="header-sticky">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="menu-center-wrap">
                            <div class="menu-area">
                                <nav>
                                    <?php
                                    if($_SESSION['user-type']=="admin") //คอมแอดมิน
                                    {
                                        ?>
                                    <ul>
                                        <li class=""><a href="index.php">พนักงาน</a></li>
                                        <li><a href="#"></span>พื้นที่จัดจำหน่าย <i class="fa fa-angle-down"></i></a>
                                            <div class="sub-menu">
                                                <ul>
                                                    <li class=""><a href="zone_list.php">โซน</a></li>
                                                    <li class=""><a href="branch_list.php">สาขา</a></li>
                                                    <li class=""><a href="motorcycle.php">รายการรถ</a></li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li><a href="search.php">ค้นหารถสั่งจอง</a></li>

                                        <li><a href="#"></span>รายงาน <i class="fa fa-angle-down"></i></a>
                                            <div class="sub-menu">
                                                <ul>
                                                    <li class=""><a href="order_list_admin.php">การสั่งจอง</a></li>
                                                    <li class=""><a
                                                            href="order_check_list_admin.php">การรับเรื่องจอง</a></li>
                                                </ul>
                                            </div>
                                        </li>



                                        <li class=""><a href="log_file.php">ประวัติการเข้าใช้งาน</a></li>
                                        <li><a href="#"><span class="fa fa-user"></span>
                                                <?=$_SESSION['user-fullname']?> (<?=$_SESSION['user-type']?>) <i
                                                    class="fa fa-angle-down"></i></a>
                                            <div class="sub-menu">
                                                <ul>
                                                    <li><a href="profile.php">แก้ไขข้อมูลส่วนตัว</a></li>
                                                    <li><a onclick="logout()">ออกจากระบบ</a></li>
                                                </ul>
                                            </div>
                                        </li>

                                    </ul>
                                    <?php

                                    }else if($_SESSION['user-type']=="staff") //คอมคลัง
                                    {
                                        ?>
                                    <ul>
                                        <li class=""><a href="motorcycle_list.php">รถจักรยานยนต์</a></li>
                                        <li><a href="search.php">ค้นหารถ</a></li>
                                        <li><a href="order_list.php">การสั่งจอง </a></li>
                                        <li><a href="order_check_list.php">การรับเรื่องจอง <span id="noti1"
                                                    class="noti1"></span></a>
                                        </li>
                                        <?php
                                        $b=$_SESSION['user-branch'];
                                        $s=$conn->query("SELECT `id`,`txt` FROM `tbl_notication` WHERE `branch_id`='$b' AND `statis`='0'");
                                       
                                        ?>
                                        <li><a href="#"><span class="fa fa-bell"></span> <?php if($s->num_rows>0){ ?>
                                                <span class="noti3"><?=$s->num_rows?></span><?php } ?></a>

                                            <?php
                                                if($s->num_rows>0)
                                                {
                                                    ?>
                                                    <div class="sub-menu" style=" width: 500px;    word-break: normal;">

                                                        <ul>
                                                            <?php
                                                            while ($a=$s->fetch_assoc()) {
                                                                ?>
                                                            <li><a onclick="read_noti(<?=$a['id']?>)" style=" border-bottom: solid 1px #eee; "><?=$a['txt']?></a></li>
                                                            <?php
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>
                                            <?php
                                                }
                                                ?>
                                        </li>
                                        <li><a href="#"><span class="fa fa-user"></span>
                                                <?=$_SESSION['user-fullname']?> (<?=$_SESSION['user-type']?>) <i
                                                    class="fa fa-angle-down"></i></a>
                                            <div class="sub-menu">
                                                <ul>
                                                    <li><a href="profile.php">แก้ไขข้อมูลส่วนตัว</a></li>
                                                    <li><a onclick="logout()">ออกจากระบบ</a></li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                    <?php

                                    }else if($_SESSION['user-type']=="sale") //คอมขาย
                                    {
                                        ?>
                                    <ul>
                                        <li class=""><a href="motorcycle_list.php">รถจักรยานยนต์</a></li>
                                        <li><a href="search.php">ค้นหารถ</a></li>
                                        <li><a href="order_list.php">การสั่งจอง</a></li>
                                        <li><a href="order_check_list.php">การรับเรื่องจอง <span id="noti1"
                                                    class="noti1"></span></a></li>
                                                    <?php
                                        $b=$_SESSION['user-branch'];
                                        $s=$conn->query("SELECT `id`,`txt` FROM `tbl_notication` WHERE `branch_id`='$b' AND `statis`='0'");
                                       
                                        ?>
                                        <li><a href="#"><span class="fa fa-bell"></span> <?php if($s->num_rows>0){ ?>
                                                <span class="noti3"><?=$s->num_rows?></span><?php } ?></a>

                                            <?php
                                                if($s->num_rows>0)
                                                {
                                                    ?>
                                                    <div class="sub-menu">

                                                        <ul>
                                                            <?php
                                                            while ($a=$s->fetch_assoc()) {
                                                                ?>
                                                            <li><a onclick="read_noti(<?=$a['id']?>)"><?=$a['txt']?></a></li>
                                                            <?php
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>
                                            <?php
                                                }
                                                ?>
                                        </li>
                                        
                                        <li><a href="#"><span class="fa fa-user"></span>
                                                <?=$_SESSION['user-fullname']?> (<?=$_SESSION['user-type']?>) <i
                                                    class="fa fa-angle-down"></i></a>
                                            <div class="sub-menu">
                                                <ul>
                                                    <li><a href="profile.php">แก้ไขข้อมูลส่วนตัว</a></li>
                                                    <li><a onclick="logout()">ออกจากระบบ</a></li>
                                                </ul>
                                            </div>
                                        </li>

                                    </ul>
                                    <?php

                                    }else{
                                        ?>
                                    <script>
                                        window.location = "login.php"
                                    </script>
                                    <?php
                                    }

                                    ?>

                                </nav>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main-menu-area-end -->
        <!-- mobile-menu-area-start -->
        <!--เปิดในโทรศัพท์-->
        <div class="mobile-menu-area d-lg-none d-block fix">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mobile-menu">
                            <nav id="mobile-menu-active">
                                <?php
                                    if($_SESSION['user-type']=="admin")          //มือถือแอดมิน
                                    {
                                        ?>
                                <ul id="nav">
                                    <li class=""><a href="index.php">พนักงาน</a></li>
                                    <li class=""><a href="zone_list.php">โซน</a></li>
                                    <li class=""><a href="branch_list.php">สาขา</a></li>
                                    <li><a href="search.php">ค้นหารถสั่งจอง</a></li>
                                    <li class=""><a href="log_file.php">ประวัติการเข้าใช้งาน</a></li>
                                    <li><a href="profile.php">แก้ไขข้อมูลส่วนตัว</a></li>
                                    <li><a onclick="logout()">ออกจากระบบ</a></li>

                                </ul>
                                <?php

                                    }else if($_SESSION['user-type']=="staff")    //มือถือคลัง
                                    {
                                        ?>
                                <ul id="nav">
                                    <li class=""><a href="motorcycle_list.php">รถจักรยานยนต์</a></li>
                                    <li><a href="search.php">ค้นหารถ</a></li>
                                    <li><a href="order_list.php">การสั่งจอง </a></li>
                                    <li><a href="order_check_list.php">การรับเรื่องจอง <span id="noti1"
                                                class="noti1"></span></a>
                                    </li>
                                    <li><a href="profile.php">แก้ไขข้อมูลส่วนตัว</a></li>
                                    <li><a onclick="logout()">ออกจากระบบ</a></li>
                                </ul>
                                <?php

                                    }else if($_SESSION['user-type']=="sale")     //มือถือขาย
                                    {
                                        ?>
                                <ul id="nav">
                                    <li class=""><a href="motorcycle_list.php">รถจักรยานยนต์</a></li>
                                    <li><a href="search.php">ค้นหารถ</a></li>
                                    <li><a href="order_list.php">การสั่งจอง</a></li>
                                    <li><a href="order_check_list.php">การรับเรื่องจอง <span id="noti1"
                                                class="noti1"></span></a></li>
                                    <li><a href="profile.php">แก้ไขข้อมูลส่วนตัว</a></li>
                                    <li><a onclick="logout()">ออกจากระบบ</a></li>

                                </ul>
                                <?php

                                    }else{
                                        ?>
                                <script>
                                    window.location = "login.php"
                                </script>
                                <?php
                                    }

                                    ?>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- mobile-menu-area-end -->
    </header>
    <!-- header-area-end -->
    <!-- slider-area-start -->