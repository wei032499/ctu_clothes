<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/clothes/functions/functions.php");
if (isset($_GET['id'])) // 修改
{
    if (checkPermission(null, 'B03') < 3) {
        echo "<script>alert('無此權限');history.back();</script>";
        exit();
    }
} else // 新增 
{
    if (checkPermission(null, 'B03') < 2) {
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
                <a href="/clothes/inventory/purchaseManage.php" class="text-dark">用料進貨維護</a> /
                <a href="/clothes/inventory/purchaseInfo.php" class="text-info">用料進貨單</a>
            </div>
        </div>
    </section>
    <section>
        <div class="container" style="margin: 10px auto">
            <div class="shadow p-3 mb-5 bg-white rounded" style="padding:2.5rem!important">
                <h1>用料進貨單</h1>
                <hr>
                <?php $date = date('Y-m-d'); ?>
                <form id="purchaseForm" action="/clothes/ajax/manage_ajax.php" method="post" style="margin:auto;width:90%">
                    <input type="text" name="form" value="purchase" style="display:none" required />
                    <div class="form-group row" style="justify-content: center;">
                        <label for="Pur_Num" style="margin-right:5px;width:200px;" class="col-form-label">進貨編號</label>
                        <input id="Pur_Num" type="text" class="form-control" style="min-width:100px;max-width: 200px;" name="Pur_Num" readonly>
                    </div>
                    <div class="form-group row" style="justify-content: center;">
                        <label for="Pur_Date" style="margin-right:5px;width:200px;" class="col-form-label">進貨日期</label>
                        <input id="Pur_Date" type="date" class="form-control" style="min-width:100px;max-width: 200px;" name="Pur_Date" max="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    <div class="form-group row" style="justify-content: center;">
                        <label for="CT_No" style="margin-right:5px;width:200px;" class="col-form-label">用料大類</label>
                        <select id="CT_No" class="form-control" style="min-width:100px;max-width: 200px;" name="CT_No" onchange="setSubSelect(this)">
                            <option disabled hidden selected></option>
                        </select>
                        <script>
                            function setSubSelect(obj) {
                                $("form select[name='Mate_Num']").empty();
                                index = $(obj).children('option:selected').val();
                                $('#CI_No').empty().append('<option disabled hidden selected></option>');
                                for (i = 0; i < CI_Array[index].length; i++)
                                    $('#CI_No').append($("<option></option>").attr("value", CI_Array[index][i]['CI_No']).text(CI_Array[index][i]['CI_Name']));

                            }
                        </script>
                    </div>
                    <div class="form-group row" style="justify-content: center;">
                        <label for="CI_No" style="margin-right:5px;width:200px;" class="col-form-label">用料小類</label>
                        <select id="CI_No" class="form-control" style="min-width:100px;max-width: 200px;" name="CI_No" onchange="setMateName();">
                            <option disabled hidden selected></option>
                        </select>

                    </div>
                    <div class="form-group row" style="justify-content: center;">
                        <label for="Mate_Color" style="margin-right:5px;width:200px;" class="col-form-label">顏色</label>
                        <select id="Mate_Color" class="form-control" style="min-width:100px;max-width: 200px;" name="Mate_Color" onchange="setMateName();">
                            <option disabled hidden selected></option>
                        </select>
                    </div>
                    <div class="form-group row" style="justify-content: center;">
                        <label for="Mate_Num" style="margin-right:5px;width:200px;" class="col-form-label">用料名稱</label>
                        <select id="Mate_Num" type="text" class="form-control" style="min-width:100px;max-width: 200px;" name="Mate_Num" onchange="setUnit()" required></select>
                    </div>
                    <div class="form-group row" style="justify-content: center;">
                        <label for="Pur_Qty" style="margin-right:5px;width:200px;" class="col-form-label">進貨數量</label>
                        <input id="Pur_Qty" type="number" min="0" class="form-control" style="min-width:100px;max-width: 200px;" name="Pur_Qty" required>
                    </div>
                    <div class="form-group row" style="justify-content: center;">
                        <label for="Pur_Unit" style="margin-right:5px;width:200px;" class="col-form-label">單位</label>
                        <input type="text" id="Pur_Unit" class="form-control" style="min-width:100px;max-width: 200px;" name="Pur_Unit" disabled>

                    </div>
                    <div class="form-group row" style="justify-content: center;">
                        <label for="Pur_Price" style="margin-right:5px;width:200px;" class="col-form-label">單價</label>
                        <input id="Pur_Price" type="number" min="0" class="form-control" style="min-width:100px;max-width: 200px;" name="Pur_Price" required>
                    </div>
                    <div class="form-group row" style="justify-content: center;">
                        <label for="Supply_Num" style="margin-right:5px;width:200px;" class="col-form-label">供應商</label>
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
                        <button id="delete_btn" style="margin:auto 5px auto auto;display:none" type="button" class="btn btn-danger" onclick="deleteData('purchase','<?php echo $_GET['id']; ?>')">刪除</button>
                        <button id="back_btn" style="margin:auto auto auto 5px" type="button" class="btn btn-warning" onclick="history.back()">返回</button>
                    </div>
                </form>
                <script>
                    function initialInfo(id) {
                        //$("#submit_btn").html("更新");
                        $("#submit_btn").css('display', 'none');
                        $("#delete_btn").css('display', '');
                        $('form').attr('method', "GET");
                        $.ajax({
                            type: "GET",
                            url: "/clothes/ajax/manage_ajax.php",
                            data: {
                                form: "purchase",
                                Pur_Num: id
                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json.status === "error")
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                                else if (json.status === "success") {
                                    if (json.data.length === 1) {
                                        $("input[name='Pur_Num']").val(json['data'][0].Pur_Num);
                                        $("input[name='Pur_Date']").val(json['data'][0].Pur_Date);
                                        $("form select[name='CT_No']").val(json['data'][0].CT_No);
                                        setSubSelect($("#CT_No"));
                                        $("form select[name='CI_No']").val(json['data'][0].CI_No);
                                        $("form select[name='Mate_Color']").val(json['data'][0].Mate_Color_Code);
                                        $("input[name='Pur_Qty']").val(json['data'][0].Pur_Qty);
                                        $("input[name='Pur_Price']").val(json['data'][0].Pur_Price);
                                        $("form select[name='Pur_Unit']").val(json['data'][0].Pur_Unit);
                                        $("form select[name='Mate_Num']").empty().append($("<option></option>").attr("value", json.data[0].Mate_Num).text(json.data[0].Mate_Name));
                                        $("form select[name='Supply_Num']").val(json['data'][0].Supply_Num);
                                        $("input[name='Addtime']").val(json['data'][0].Addtime);
                                    } else {
                                        alert("此供應商不存在!");
                                        window.location.replace("purchaseManage.php");
                                    }
                                } else {
                                    toastr.error("error", "ERROR"); // show response from the php script.
                                    alert("error");
                                    window.location.replace("purchaseManage.php");
                                }


                            }
                        });
                    }
                    var CT_Array = ['B01', 'B02', 'B03', 'B04', 'B05', 'B06'];
                    var CI_Array = new Array();
                    //var Material_Array = new Array();
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
                                form: "supply"
                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json.hasOwnProperty('status') && json['status'] === "success") {
                                    for (i = 0; i < json['data'].length; i++) {
                                        $('#Supply_Num').append($("<option></option>").attr("value", json['data'][i]['Supply_Num']).text(json['data'][i]['Supply_Name']));
                                    }
                                } else
                                    toastr.error(json.error, "ERROR"); // show response from the php script.


                            }
                        });
                        for (z = 0; z < 6; z++) {
                            const zz = z;
                            $.ajax({
                                type: 'GET',
                                url: '/clothes/ajax/manage_ajax.php',
                                data: {
                                    form: "syscodeinfo",
                                    CT_No: CT_Array[zz]
                                }, // serializes the form's elements.
                                dataType: "json",
                                success: function(json) {

                                    if (json.hasOwnProperty('status') && json['status'] === "success") {
                                        CI_Array[CT_Array[zz]] = json['data'];

                                    } else
                                        toastr.error(json.error, "ERROR"); // show response from the php script.


                                }
                            });
                            $('#CT_No').append($("<option></option>").attr("value", CT_Array[zz]));
                            $.ajax({
                                type: 'GET',
                                url: '/clothes/ajax/manage_ajax.php',
                                data: {
                                    form: "syscodetype",
                                    CT_No: CT_Array[zz]
                                }, // serializes the form's elements.
                                dataType: "json",
                                success: function(json) {

                                    if (json.hasOwnProperty('status') && json['status'] === "success") {
                                        $('#CT_No option').eq(zz + 1).text(json['data'][0]['CT_Name']);
                                    } else
                                        toastr.error(json.error, "ERROR"); // show response from the php script.


                                }
                            });
                        }
                        url = new URL(window.location.href);
                        for (pair of url.searchParams.entries()) {
                            if (pair[0] == 'id') {
                                $(".container").find("h1").eq(0).text("用料進貨單 - 檢視");
                                initialInfo(pair[1]);
                                return;
                            }
                        }
                        $(".container").find("h1").eq(0).text("用料進貨單 - 新增");


                    });

                    $("#purchaseForm").submit(function(e) {

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
                                    window.location.replace("purchaseManage.php");
                                }
                            }
                        });

                        e.preventDefault(); // avoid to execute the actual submit of the form.
                    });

                    var unit = Array();

                    function setUnit() {
                        $("form input[name='Pur_Unit']").val(unit[$("form select[name='Mate_Num']").val()]);
                    }

                    function setMateName() {
                        unit = Array();
                        $("form select[name='Mate_Num']").empty();
                        if ($("form select[name='Mate_Color']").val() != null && $("form select[name='CT_No']").val() != null && $("form select[name='CI_No']").val() != null)
                            $.ajax({
                                type: 'GET',
                                url: '/clothes/ajax/manage_ajax.php',
                                data: {
                                    form: "material",
                                    Mate_Color: $("form select[name='Mate_Color']").val(),
                                    CT_No: $("form select[name='CT_No']").val(),
                                    CI_No: $("form select[name='CI_No']").val()
                                }, // serializes the form's elements.
                                dataType: "json",
                                success: function(json) {

                                    if (json.hasOwnProperty('status') && json['status'] === "success") {
                                        $("form select[name='Mate_Num']").empty().append($("<option disabled hidden selected></option>"));
                                        for (i = 0; i < json['data'].length; i++) {
                                            unit[json['data'][i].Mate_Num] = json['data'][i].Mate_Unit_Name;
                                            $("form select[name='Mate_Num']").append($("<option></option>").attr("value", json['data'][i].Mate_Num).text(json['data'][i].Mate_Name));
                                        }

                                    } else
                                        toastr.error(json.error, "ERROR"); // show response from the php script.


                                }
                            });
                        /*
                        for (i = 0; i < json['data'].length; i++) {

                                            if (!Material_Array.includes(json.data[i].CT_No))
                                                Material_Array[json.data[i].CT_No] = new Array();
                                            Material_Array[json.data[i].CT_No][json.data[i].CI_No] = new Array();
                                            Material_Array[json.data[i].CT_No][json.data[i].CI_No].Mate_Num = json.data[i].Mate_Num;
                                            Material_Array[json.data[i].CT_No][json.data[i].CI_No].Mate_Name = json.data[i].Mate_Name;
                                            console.log(Material_Array, "!!!!!!!!!");
                                        }
                        try {

                            var CT_No = $("form select[name='CT_No']").val();
                            var CI_No = $("form select[name='CI_No']").val();
                            $("form select[name='Mate_Num']").empty().append($("<option></option>").attr("value", Material_Array[CT_No][CI_No].Mate_Num).text(Material_Array[CT_No][CI_No].Mate_Name));
                        } catch (e) {
                            console.log(e);
                        }*/
                    }



                    function deleteData(form, id) {
                        if (confirm('刪除資料？')) {
                            $.ajax({
                                type: "DELETE",
                                url: "/clothes/ajax/manage_ajax.php",
                                data: {
                                    form: form,
                                    id: id
                                },
                                dataType: "json",
                                success: function(json) {
                                    if (json.hasOwnProperty('status') && json.status === "success") {
                                        toastr.success("刪除成功", "Success");
                                        window.location.replace("purchaseManage.php");
                                    } else {
                                        toastr.error(json.error, "ERROR"); // show response from the php script.

                                    }



                                }
                            });
                        }

                    }
                </script>

            </div>
        </div>
    </section>
</body>

</html>