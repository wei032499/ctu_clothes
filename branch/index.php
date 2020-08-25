<?php
session_start();
if (!isset($_SESSION['Emp_Num']) || !isset($_SESSION['role'])) {
    session_destroy();
    header("Location: /clothes/index.php?redirect=branch");
    exit();
}
?>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />
    <meta http-equiv="Content-Language" content="zh-TW">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="Shortcut Icon" type="image/x-icon" href="/clothes/images/icon.svg" />
    <title>衣服訂做網</title>
    <script src="/clothes/js/jquery-3.5.1.min.js"></script>
    <script src="/clothes/js/popper.min.js"></script>

    <link rel="stylesheet" href="/clothes/css/bootstrap.min.css">
    <script src="/clothes/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="/clothes/css/toastr.min.css">
    <script src="/clothes/js/toastr.min.js"></script>

    <link rel="stylesheet" type="text/css" href="/clothes/DataTables/datatables.min.css" />

    <script type="text/javascript" src="/clothes/DataTables/datatables.min.js"></script>

</head>

<body>
    <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/clothes/navbar.php"); ?>
    <script>
        $(function() {
            $("nav li").eq(4).addClass("active");
        });
    </script>
    <section>
        <div class="container" style="margin: 20px auto">
            <div class="shadow bg-white " style="padding:0.15rem 1rem!important">
                <a href="/clothes/" class="text-dark">首頁</a> /
                <a href="/clothes/branch/" class="text-info">分店管理</a>
            </div>
        </div>
    </section>
    <section>
        <div class="container" style="margin: 10px auto">
            <div class="shadow p-3 mb-5 bg-white rounded" style="padding:2.5rem!important">
                <h1>分店管理</h1>
                <hr>
                <div class="row">
                    <div class="col-sm" style="margin:auto">
                        <div style="margin: auto;max-width:90%;width:250px">
                            <button type="button" class="btn btn-outline-primary btn-block" onclick="window.open('branchManage.php','_self')">D01 分店基本資料維護</button>
                            <button type="button" class="btn btn-outline-success btn-block" onclick="window.open('expenditureManage.php','_self')">D02 分店費用報支維護</button>
                            <button type="button" class="btn btn-outline-danger btn-block" onclick="window.open('/clothes/','_self')">主選單</button>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>
</body>

</html>