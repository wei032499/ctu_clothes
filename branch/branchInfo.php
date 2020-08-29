<?php
@require_once($_SERVER["DOCUMENT_ROOT"] . "/clothes/functions/functions.php");
if (isset($_GET['id'])) // 修改
{
    if (checkPermission($_GET['id'], 'D01') < 1) {
        echo "<script>alert('無此權限');history.back();</script>";
        exit();
    }
} else // 新增 
{
    if (checkPermission(null, 'D01') < 2) {
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
            $("nav li").eq(4).addClass("active");
        });
    </script>
    <section>
        <div class="container" style="margin: 20px auto">
            <div class="shadow bg-white " style="padding:0.15rem 1rem!important">
                <a href="/clothes/" class="text-dark">首頁</a> /
                <a href="/clothes/branch/" class="text-dark">分店管理</a> /
                <a href="/clothes/branch/branchManage.php" class="text-dark">分店基本資料維護</a> /
                <a href="/clothes/branch/branchInfo.php" class="text-info">分店基本資料表</a>
            </div>
        </div>
    </section>
    <section>
        <div class="container" style="margin: 10px auto">
            <div class="shadow p-3 mb-5 bg-white rounded" style="padding:2.5rem!important">
                <h1>分店基本資料表</h1>
                <hr>
                <form id="branchForm" action="/clothes/ajax/manage_ajax.php" method="post" style="margin:auto;width:90%">
                    <input type="text" name="form" value="branch" style="display:none" />
                    <div class="row" style="margin:5px auto">
                        <div class="col-sm row" style="text-align: center;margin:auto">
                            <div style="align-self: center;margin:5px 0px;white-space:nowrap">分店編號：</div>
                            <input placeholder="大寫字母&數字(共4碼)" type="text" pattern="[\d|A-Z]+" maxlength="4" class="form-control col-sm" style="align-self: center;margin:5px auto;min-width:100px" name="Bran_Num" required>
                        </div>
                        <div class="col-sm row" style="text-align: center;margin:auto">
                            <div style="align-self: center;margin:5px 0px;white-space:nowrap">分店名稱：</div>
                            <input type="text" class="form-control col-sm" style="align-self: center;margin:5px auto;;min-width:100px" name="Bran_Name" required>
                        </div>
                        <div class="col-sm row" style="text-align: center;margin:auto">
                            <div style="align-self: center;margin:5px 0px;white-space:nowrap">設立日期：</div>
                            <input type="date" class="form-control col-sm" style="align-self: center;margin:5px auto;;min-width:100px" name="Bran_Start" required>
                        </div>
                    </div>
                    <div class="row" style="margin:10px auto">
                        <div class="col-sm row" style="text-align: center;margin:auto">
                            <div style="align-self: center;margin:5px 0px;white-space:nowrap">地&emsp;址：</div>
                            <input type="text" class="form-control col-sm" style="align-self: center;margin:5px auto;;min-width:200px" name="Bran_Addr" required>
                        </div>
                        <div class="col-sm-4 row" style="text-align: center;margin:auto">
                            <div style="align-self: center;margin:5px 0px;white-space:nowrap">電&emsp;話：</div>
                            <input type="tel" pattern="[\d|-]+" class="form-control col-sm" style="align-self: center;margin:5px auto;;min-width:100px" name="Bran_Tel" required>
                        </div>
                    </div>
                    <div class="row" style="margin:10px auto">
                        <div class="col-sm row" style="text-align: center;margin:auto">
                            <div style="align-self: center;margin:5px 0px;white-space:nowrap">店&emsp;長：</div>
                            <input type="text" class="form-control col-sm" style="align-self: center;margin:5px auto;;min-width:100px" name="Bran_Supr" required>
                        </div>
                        <div class="col-sm row" style="text-align: center;margin:auto">
                            <div style="align-self: center;margin:5px 0px;white-space:nowrap">押&emsp;金：</div>
                            <input type="number" min="0" step="1" class="form-control col-sm" style="align-self: center;margin:5px auto;;min-width:100px" name="Bran_Depo" required>
                        </div>
                        <div class="col-sm row" style="text-align: center;margin:auto">
                            <div style="align-self: center;margin:5px 0px;white-space:nowrap">裝潢費：</div>
                            <input type="number" min="0" step="1" class="form-control col-sm" style="align-self: center;margin:5px auto;;min-width:100px" name="Bran_Deco" required>
                        </div>
                    </div>
                    <div class="row" style="margin:10px auto">
                        <div class="col-sm row" style="text-align: center;margin:auto">
                            <div style="margin:5px 0px;white-space:nowrap">租約注意事項：</div>
                            <textarea class="form-control col-sm" name="Bran_Memo"></textarea>
                        </div>

                    </div>
                    <div style="width:max-content;margin:auto">
                        <button id="submit_btn" style="margin:auto 5px" type="submit" class="btn btn-success">新增</button>
                        <button style="margin:auto 5px" type="button" class="btn btn-danger" onclick="history.back();">取消</button>
                    </div>

                </form>

                <script>
                    $("#branchForm").submit(function(e) {

                        var form = $(this);
                        var url = form.attr('action');
                        var method = form.attr('method');

                        $.ajax({
                            type: method,
                            url: url,
                            data: form.serialize(), // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json.hasOwnProperty('status')) {
                                    if (json.status === "success") {
                                        toastr.success("新增成功", "Success");
                                        window.location.replace("branchManage.php");
                                    } else
                                        toastr.error(json.error, "ERROR"); // show response from the php script.

                                } else
                                    toastr.error("error", "ERROR");

                            }
                        });

                        e.preventDefault(); // avoid to execute the actual submit of the form.
                    });

                    function initialInfo(id) {
                        $("#submit_btn").html("更新");
                        $("#branchForm input").eq(1).attr('readonly', 'true');
                        $.ajax({
                            type: "GET",
                            url: "/clothes/ajax/manage_ajax.php",
                            data: {
                                form: "branch",
                                id: id
                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json.hasOwnProperty('status')) {
                                    if (json.status === "success") {
                                        if (json['data'].length == 0) {
                                            alert("此分店不存在!");
                                            window.location.replace("branchManage.php");
                                        } else {
                                            if (json.hasOwnProperty('error'))
                                                toastr.error(json.error, "ERROR"); // show response from the php script.
                                            else {
                                                $('form')[0][1].value = json['data'][0].Bran_Num;
                                                $('form')[0][2].value = json['data'][0].Bran_Name;
                                                $('form')[0][3].value = json['data'][0].Bran_Start;
                                                $('form')[0][4].value = json['data'][0].Bran_Addr;
                                                $('form')[0][5].value = json['data'][0].Bran_Tel;
                                                $('form')[0][6].value = json['data'][0].Bran_Supr;
                                                $('form')[0][7].value = json['data'][0].Bran_Depo;
                                                $('form')[0][8].value = json['data'][0].Bran_Deco;
                                                $('form')[0][9].value = json['data'][0].Bran_Memo;
                                                $('form').attr('method', "PUT");
                                            }
                                        }
                                    } else
                                        toastr.error(json.error, "ERROR"); // show response from the php script.

                                } else
                                    toastr.error("error", "ERROR");




                            }
                        });
                    }
                    $(function() {
                        url = new URL(window.location.href);
                        for (pair of url.searchParams.entries()) {
                            if (pair[0] == 'id') {
                                $(".container").find("h1").eq(0).text("分店基本資料表 - 修改");
                                initialInfo(pair[1]);
                                return;
                            }
                        }
                        $(".container").find("h1").eq(0).text("分店基本資料表 - 新增");
                    })
                </script>

            </div>
        </div>
    </section>
</body>

</html>