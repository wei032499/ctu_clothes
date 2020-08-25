<?php
session_start();
if (!isset($_SESSION['Emp_Num']) || !isset($_SESSION['role'])) {
    session_destroy();
    header("Location: /clothes/index.php");
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
            $("nav li").eq(0).addClass("active");
        });
    </script>

    <section>
        <div class="container" style="margin: 10px auto">
            <div class="shadow p-3 mb-5 bg-white rounded" style="padding:2.5rem!important">
                <h1>管理系統</h1>
                <hr>
                <div class="row">

                    <div class="col-sm" style="margin:10px auto;min-width: 200px;">
                        <div style="margin: auto;max-width:80%;height:100%">
                            <table style="text-align: center;margin: auto ">
                                <tbody>
                                    <tr>
                                        <th>員工編號：</th>
                                        <td><?php echo $_SESSION['Emp_Num']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>員工姓名：</th>
                                        <td><?php echo $_SESSION['name']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>門店代號：</th>
                                        <td><?php echo $_SESSION['Bran_Num']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>門店名稱：</th>
                                        <td><?php echo $_SESSION['Bran_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>系統權限：</th>
                                        <td><?php echo $_SESSION['Or_Name']; ?></td>
                                    </tr>

                                </tbody>
                            </table>

                        </div>
                    </div>
                    <div class="col-sm" style="margin:auto">
                        <div style="margin: auto;max-width:90%;width:250px">
                            <button type="button" class="btn btn-outline-primary btn-block" onclick="window.open('./customer/','_self')">A 顧客訂單管理</button>
                            <button type="button" class="btn btn-outline-secondary btn-block" onclick="window.open('./inventory/','_self')">B 用料庫存管理</button>
                            <button type="button" class="btn btn-outline-success btn-block" onclick="window.open('./staff/','_self')">C 人事薪資管理</button>
                            <button type="button" class="btn btn-outline-warning btn-block" onclick="window.open('./branch/','_self')">D 分店管理&emsp;&emsp;</button>
                            <button type="button" class="btn btn-outline-info btn-block" onclick="window.open('./pattern/','_self')">E 打版圖管理&emsp;</button>
                            <button type="button" class="btn btn-outline-dark btn-block" onclick="window.open('./system/','_self')">Z 系統維護&emsp;&emsp;</button>
                            <button type="button" class="btn btn-outline-danger btn-block" onclick="window.location.replace('ajax/manage_ajax.php?form=logout')">登出</button>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>
</body>

</html>