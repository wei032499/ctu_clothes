<?php
@require_once($_SERVER["DOCUMENT_ROOT"] . "/clothes/functions/functions.php");
if (isset($_GET['id'])) // 修改
{
    if (checkPermission(null, 'B02') < 3) {
        echo "<script>alert('無此權限');history.back();</script>";
        exit();
    }
} else // 新增 
{
    if (checkPermission(null, 'B02') < 2) {
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
                <a href="/clothes/inventory/materialManage.php" class="text-dark">用料品項維護</a> /
                <a href="/clothes/inventory/materialInfo.php" class="text-info">用料品項單</a>
            </div>
        </div>
    </section>
    <section>
        <div class="container" style="margin: 10px auto">
            <div class="shadow p-3 mb-5 bg-white rounded" style="padding:2.5rem!important">
                <h1>用料品項單</h1>
                <hr>
                <?php $date = date('Y-m-d'); ?>
                <form id="materialForm" action="/clothes/ajax/manage_ajax.php" method="post" style="margin:auto;width:90%">
                    <input type="text" name="form" value="material" style="display:none" required />
                    <div class="form-group row" style="justify-content: center;">
                        <label for="Mate_Num" style="margin-right:5px;width:200px;" class="col-form-label">用料編號</label>
                        <input id="Mate_Num" type="text" class="form-control" style="min-width:100px;max-width: 200px;" name="Mate_Num" readonly>
                    </div>
                    <div class="form-group row" style="justify-content: center;">
                        <label for="Mate_Name" style="margin-right:5px;width:200px;" class="col-form-label">用料名稱</label>
                        <input id="Mate_Name" type="text" class="form-control" style="min-width:100px;max-width: 200px;" name="Mate_Name" required>
                    </div>
                    <div class="form-group row" style="justify-content: center;">
                        <label for="CT_No" style="margin-right:5px;width:200px;" class="col-form-label">材料大類</label>
                        <select id="CT_No" class="form-control" style="min-width:100px;max-width: 200px;" name="CT_No" onchange="setSubSelect(this)" required>
                            <option disabled hidden selected></option>
                        </select>
                        <script>
                            function setSubSelect(obj) {
                                var index = $(obj).children('option:selected').val();
                                $('#CI_No').empty().append('<option disabled hidden selected></option>');
                                for (i = 0; i < CI_Array[index].length; i++)
                                    $('#CI_No').append($("<option></option>").attr("value", CI_Array[index][i]['CI_No']).text(CI_Array[index][i]['CI_Name']));

                            }
                        </script>
                    </div>
                    <div class="form-group row" style="justify-content: center;">
                        <label for="CI_No" style="margin-right:5px;width:200px;" class="col-form-label">材料小類</label>
                        <select id="CI_No" class="form-control" style="min-width:100px;max-width: 200px;" name="CI_No" required>
                            <option disabled hidden selected></option>
                        </select>
                    </div>
                    <div class="form-group row" style="justify-content: center;">
                        <label for="Mate_Color" style="margin-right:5px;width:200px;" class="col-form-label">顏色</label>
                        <select id="Mate_Color" class="form-control" style="min-width:100px;max-width: 200px;" name="Mate_Color" required>
                            <option disabled hidden selected></option>
                        </select>
                    </div>
                    <div class="form-group row" style="justify-content: center;">
                        <label for="Safe_Qty" style="margin-right:5px;width:200px;" class="col-form-label">安全存量</label>
                        <input id="Safe_Qty" type="number" min="0" class="form-control" style="min-width:100px;max-width: 200px;" name="Safe_Qty" required>
                    </div>
                    <div class="form-group row" style="justify-content: center;">
                        <label for="Mate_Unit" style="margin-right:5px;width:200px;" class="col-form-label">單位</label>
                        <select id="Mate_Unit" class="form-control" style="min-width:100px;max-width: 200px;" name="Mate_Unit" required>
                            <option disabled hidden selected></option>
                        </select>
                    </div>
                    <div class="form-group row" style="justify-content: center;">
                        <label for="Supply_Num" style="margin-right:5px;width:200px;" class="col-form-label">預設供應商</label>
                        <select id="Supply_Num" class="form-control" style="min-width:100px;max-width: 200px;" name="Supply_Num" required>
                            <option disabled hidden selected></option>
                        </select>
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
                                form: "material",
                                id: id
                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if ($.isArray(json) && json.length == 0 || json['data'].length == 0) {
                                    alert("此供應商不存在!");
                                    window.location.replace("materialManage.php");
                                } else {
                                    if (json.hasOwnProperty('error'))
                                        toastr.error(json.error, "ERROR"); // show response from the php script.
                                    else {
                                        $('form')[0][1].value = json['data'][0].Mate_Num;
                                        $('form')[0][2].value = json['data'][0].Mate_Name;
                                        $('form select').eq(0).val(json['data'][0].CT_No);
                                        setSubSelect($("#CT_No"));
                                        $('form')[0][4].value = json['data'][0].CI_No;
                                        $('form')[0][5].value = json['data'][0].Mate_Color;
                                        $('form')[0][6].value = json['data'][0].Safe_Qty;
                                        $('form')[0][7].value = json['data'][0].Mate_Unit;
                                        $('form')[0][8].value = json['data'][0].Supply_Num;
                                        $('form')[0][9].value = json['data'][0].Addtime;
                                    }
                                }



                            }
                        });
                    }
                    var CI_Array = new Array();
                    var CT_No_Array = ['B01', 'B02', 'B03', 'B04', 'B05', 'B06'];
                    $(function() {

                        $.ajax({
                            type: 'GET',
                            url: '/clothes/ajax/manage_ajax.php',
                            data: {
                                form: "syscodeinfo",
                                CT_No: "B07"
                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json.hasOwnProperty('error'))
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                                else {
                                    for (i = 0; i < json['data'].length; i++) {
                                        $('#Mate_Color').append($("<option></option>").attr("value", json['data'][i]['CI_No']).text(json['data'][i]['CI_Name']));
                                    }
                                }

                            }
                        });
                        $.ajax({
                            type: 'GET',
                            url: '/clothes/ajax/manage_ajax.php',
                            data: {
                                form: "syscodeinfo",
                                CT_No: "B08"
                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json.hasOwnProperty('error'))
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                                else {
                                    for (i = 0; i < json['data'].length; i++) {
                                        $('#Mate_Unit').append($("<option></option>").attr("value", json['data'][i]['CI_No']).text(json['data'][i]['CI_Name']));
                                    }
                                }

                            }
                        });
                        $.ajax({
                            type: 'GET',
                            url: '/clothes/ajax/manage_ajax.php',
                            data: {
                                form: "supply"
                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json.hasOwnProperty('error'))
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                                else {
                                    for (i = 0; i < json['data'].length; i++) {
                                        $('#Supply_Num').append($("<option></option>").attr("value", json['data'][i]['Supply_Num']).text(json['data'][i]['Supply_Name']));
                                    }
                                }

                            }
                        });
                        for (z = 0; z < 6; z++) {
                            const zz = z;
                            $.ajax({
                                type: 'GET',
                                url: '/clothes/ajax/manage_ajax.php',
                                data: {
                                    form: "syscodeinfo",
                                    CT_No: CT_No_Array[zz]
                                }, // serializes the form's elements.
                                dataType: "json",
                                success: function(json) {
                                    if (json.hasOwnProperty('error'))
                                        toastr.error(json.error, "ERROR"); // show response from the php script.
                                    else {
                                        CI_Array[CT_No_Array[zz]] = json['data'];

                                    }

                                }
                            });
                            $('#CT_No').append($("<option></option>").attr("value", CT_No_Array[zz]));
                            $.ajax({
                                type: 'GET',
                                url: '/clothes/ajax/manage_ajax.php',
                                data: {
                                    form: "syscodetype",
                                    CT_No: CT_No_Array[zz]
                                }, // serializes the form's elements.
                                dataType: "json",
                                success: function(json) {
                                    console.log(zz);
                                    if (json.hasOwnProperty('error'))
                                        toastr.error(json.error, "ERROR"); // show response from the php script.
                                    else {
                                        $('#CT_No option').eq(zz + 1).text(json['data'][0]['CT_Name']);
                                    }

                                }
                            });
                        }
                        url = new URL(window.location.href);
                        for (pair of url.searchParams.entries()) {
                            if (pair[0] == 'id') {
                                $(".container").find("h1").eq(0).text("用料品項單 - 修改");
                                initialInfo(pair[1]);
                                return;
                            }
                        }
                        $(".container").find("h1").eq(0).text("用料品項單 - 新增");


                    });

                    $("#materialForm").submit(function(e) {

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
                                    window.location.replace("materialManage.php");
                                }
                            }
                        });

                        e.preventDefault(); // avoid to execute the actual submit of the form.
                    });

                    function back() {
                        if (confirm('確定取消？')) {
                            window.location.replace("materialManage.php");
                        }

                    }
                </script>

            </div>
        </div>
    </section>
</body>

</html>