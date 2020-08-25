<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/clothes/functions/functions.php");
if (isset($_GET['id'])) // 修改
{
    if (checkPermission(null, 'B01') < 3) {
        echo "<script>alert('無此權限');history.back();</script>";
        exit();
    }
} else // 新增 
{
    if (checkPermission(null, 'B01') < 2) {
        echo "<script>alert('無此權限');history.back();</script>";
        exit();
    }
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
            $("nav li").eq(2).addClass("active");
        });
    </script>
    <section>
        <div class="container" style="margin: 20px auto">
            <div class="shadow bg-white " style="padding:0.15rem 1rem!important">
                <a href="/clothes/" class="text-dark">首頁</a> /
                <a href="/clothes/inventory/" class="text-dark">用料庫存管理</a> /
                <a href="/clothes/inventory/supplyManage.php" class="text-dark">供應商資料維護</a> /
                <a href="/clothes/inventory/supplyInfo.php" class="text-info">供應商資料表</a>
            </div>
        </div>
    </section>
    <section>
        <div class="container" style="margin: 10px auto">
            <div class="shadow p-3 mb-5 bg-white rounded" style="padding:2.5rem!important">
                <h1>供應商資料表</h1>
                <hr>
                <?php $date = date('Y-m-d'); ?>
                <form id="supplyForm" action="/clothes/ajax/manage_ajax.php" method="post" style="margin:auto;width:90%">
                    <input type="text" name="form" value="supply" style="display:none" required />
                    <div class="form-group row" style="justify-content: center;">
                        <label for="Supply_Num" style="margin-right:5px;width:200px;" class="col-form-label">供應商編號</label>
                        <input id="Supply_Num" type="text" class="form-control" style="min-width:100px;max-width: 200px;" name="Supply_Num" readonly>
                    </div>
                    <div class="form-group row" style="justify-content: center;">
                        <label for="Cate" style="margin-right:5px;width:200px;" class="col-form-label">供應商類別</label>
                        <select id="Cate" class="form-control" style="min-width:100px;max-width: 200px;" name="Cate" required>
                            <option disabled hidden selected></option>
                        </select>
                    </div>
                    <div class="form-group row" style="justify-content: center;">
                        <label for="Supply_Name" style="margin-right:5px;width:200px;" class="col-form-label">供應商名稱</label>
                        <input id="Supply_Name" type="text" class="form-control" style="min-width:100px;max-width: 200px;" name="Supply_Name" required>
                    </div>
                    <div class="form-group row" style="justify-content: center;">
                        <label for="Supply_Tel" style="margin-right:5px;width:200px;" class="col-form-label">電話</label>
                        <input id="Supply_Tel" type="text" pattern="[\d|-]+" class="form-control" style="min-width:100px;max-width: 200px;" name="Supply_Tel" required>
                    </div>
                    <div class="form-group row" style="justify-content: center;">
                        <label for="Supply_Mobi" style="margin-right:5px;width:200px;" class="col-form-label">手機</label>
                        <input id="Supply_Mobi" type="text" pattern="[\d|-]+" class="form-control" style="min-width:100px;max-width: 200px;" name="Supply_Mobi" required>
                    </div>
                    <div class="form-group row" style="justify-content: center;">
                        <label for="Supply_Adrs" style="margin-right:5px;width:200px;" class="col-form-label">地址</label>
                        <input id="Supply_Adrs" type="text" class="form-control" style="min-width:100px;max-width: 200px;" name="Supply_Adrs" required>
                    </div>
                    <div class="form-group row" style="justify-content: center;">
                        <label for="Supply_Respon" style="margin-right:5px;width:200px;" class="col-form-label">負責人員</label>
                        <input id="Supply_Respon" type="text" class="form-control" style="min-width:100px;max-width: 200px;" name="Supply_Respon" required>
                    </div>
                    <div class="form-group row" style="justify-content: center;">
                        <label for="Addtime" style="margin-right:5px;width:200px;" class="col-form-label">建檔時間</label>
                        <input id="Addtime" type="text" class="form-control" style="min-width:100px;max-width: 200px;" name="Addtime" disabled>
                    </div>
                    <div class="form-group row" style="justify-content: center;">
                        <button id="submit_btn" style="margin:auto 5px auto auto" type="submit" class="btn btn-success">新增</button>
                        <button style="margin:auto auto auto 5px" type="button" class="btn btn-danger" onclick="back()">取消</button>
                    </div>
                </form>
                <script>
                    function initialInfo(id) {
                        $("#submit_btn").html("更新");
                        $('form').attr('method', "PUT");
                        $.ajax({
                            type: "GET",
                            url: "/clothes/ajax/manage_ajax.php",
                            data: {
                                form: "supply",
                                Supply_Num: id
                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if ($.isArray(json) && json.length == 0 || json['data'].length == 0) {
                                    alert("此供應商不存在!");
                                    window.location.replace("supplyManage.php");
                                } else {
                                    if (json.hasOwnProperty('error'))
                                        toastr.error(json.error, "ERROR"); // show response from the php script.
                                    else {
                                        $('form')[0][1].value = json['data'][0].Supply_Num;
                                        $('form')[0][2].value = json['data'][0].Cate;
                                        $('form')[0][3].value = json['data'][0].Supply_Name;
                                        $('form')[0][4].value = json['data'][0].Supply_Tel;
                                        $('form')[0][5].value = json['data'][0].Supply_Mobi;
                                        $('form')[0][6].value = json['data'][0].Supply_Adrs;
                                        $('form')[0][7].value = json['data'][0].Supply_Respon;
                                        $('form')[0][8].value = json['data'][0].Addtime;
                                    }
                                }



                            }
                        });
                    }

                    $.when($.ajax({
                        type: 'GET',
                        url: '/clothes/ajax/manage_ajax.php',
                        data: {
                            form: "syscodeinfo",
                            CT_No: 'B09'
                        }, // serializes the form's elements.
                        dataType: "json",
                        success: function(json) {
                            if (json.hasOwnProperty('error'))
                                toastr.error(json.error, "ERROR"); // show response from the php script.
                            else {
                                for (i = 0; i < json['data'].length; i++) {
                                    $($('form')[0][2]).append($("<option></option>").attr("value", json['data'][i]['CI_No']).text(json['data'][i]['CI_Name']));
                                }
                            }

                        }
                    })).done(function() {
                        url = new URL(window.location.href);
                        for (pair of url.searchParams.entries()) {
                            if (pair[0] == 'id') {
                                $(".container").find("h1").eq(0).text("供應商資料表 - 修改");
                                initialInfo(pair[1]);
                                return;
                            }
                        }
                        $(".container").find("h1").eq(0).text("供應商資料表 - 新增");

                    });

                    $("#supplyForm").submit(function(e) {

                        var form = $(this);
                        var url = form.attr('action');
                        var method = form.attr('method');

                        $.ajax({
                            type: method,
                            url: url,
                            data: form.serialize(), // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json.hasOwnProperty('error'))
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                                else {
                                    toastr.success("新增成功", "Success");
                                    window.location.replace("supplyManage.php");
                                }
                            }
                        });

                        e.preventDefault(); // avoid to execute the actual submit of the form.
                    });

                    function back() {
                        if (confirm('確定取消？')) {
                            window.location.replace("supplyManage.php");
                        }

                    }
                </script>

            </div>
        </div>
    </section>
</body>

</html>