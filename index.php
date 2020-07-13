<?php
require_once("_system/config.php");
require_once("_system/database.php");
$datenow = date("Y-m-d H:i:s");
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting System</title>
    <link rel="stylesheet" type="text/css" href="asset/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="asset/css/mdb.css">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap" type="text/css" rel="stylesheet">
    <link href="asset/fontawesome/css/all.min.css" rel="stylesheet" type="text/css">
    <script src="asset/js/jquery.js"></script>
    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.14.0/dist/sweetalert2.all.min.js"></script>
    <style>
        body {
            font-family: 'Kanit', sans-serif;
        }

        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        [class*="col-"] {
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <?php
    include('_element/navbar.php'); ?>
    <div class="container" style="margin-bottom: 30px; margin-top: 30px;">
        <?php if (!$_GET) {
            $_GET["page"] = 'home';
        }
        if (!$_GET["page"]) {
            $_GET["page"] = "home";
        }
        if ($_GET["page"] == "home") {
            include_once __DIR__ . '/_page/home.php';
        } elseif ($_GET['page'] == "detail") {
            include_once __DIR__ . '/_page/detail.php';
        } elseif ($_GET['page'] == "vote") {
            include_once __DIR__ . '/_page/vote.php';
        } elseif ($_GET['page'] == "result") {
            include_once __DIR__ . '/_page/result.php';
        } elseif ($_GET['page'] == "login") {
            include_once __DIR__ . '/_page/login.php';
        } elseif ($_GET['page'] == "logout") {
            include_once __DIR__ . '/_page/logout.php';
        } else {
            echo '<div class="container"><div class="alert alert-danger" role="alert"><i class="fas fa-exclamation-triangle"></i> ไม่พบหน้าที่ท่านร้องขอ กำลังพาท่านกลับไปหน้าหลัก...</div></div>';
            echo '<meta http-equiv="refresh" content="3;URL=?page=home"';
        } ?>
    </div>
    <?php
    include('_element/footer.php');
    include('_element/script.php');
    ?>
</body>

</html>