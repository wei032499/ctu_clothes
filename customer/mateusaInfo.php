<?php
@require_once($_SERVER["DOCUMENT_ROOT"] . "/clothes/functions/functions.php");
if (isset($_GET['id'])) // 修改
{
    if (checkPermission(null, 'A05') < 1) {
        echo "<script>alert('無此權限');history.back();</script>";
        exit();
    }
} else // 新增 
{
    if (checkPermission(null, 'A05') < 2) {
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
            $("nav li").eq(1).addClass("active");
        });
    </script>
    <section>
        <div class="container" style="margin: 20px auto">
            <div class="shadow bg-white " style="padding:0.15rem 1rem!important">
                <a href="/clothes/" class="text-dark">首頁</a> /
                <a href="/clothes/customer/" class="text-dark">顧客訂單管理</a> /
                <a href="/clothes/customer/mateusaManage.php" class="text-dark">派工用料維護</a> /
                <a href="/clothes/customer/mateusaInfo.php" class="text-info">派工用料單</a>
            </div>
        </div>
    </section>
    <section>

        <div class="container" style="margin: 10px auto">
            <div class="shadow p-3 mb-5 bg-white rounded" style="padding:2.5rem!important">
                <h1>派工用料單</h1>
                <hr>
                <form id="mateusaForm" action="/clothes/ajax/manage_ajax.php" method="POST" style="margin:auto;width:90%">
                    <input type="text" name="form" value="mateusa" style="display:none" />
                    <div style="width:max-content;margin:auto">
                        <div class="form-group row">
                            <label for="WU_Num" style="margin:auto 5px;width:100px;" class=" col-form-label">派工用料單號</label>
                            <input type="text" class="form-control" style="max-width:200px;margin:auto" name="WU_Num" required>
                        </div>
                        <div class="form-group row">
                            <label for="WU_Date" style="margin:auto 5px;width:100px;" class=" col-form-label">派工用料日期</label>
                            <input type="date" class="form-control" style="max-width:200px;margin:auto" name="WU_Date" required>
                        </div>

                        <div class="form-group row">
                            <label for="Work_Num" style="margin:auto 5px;width:100px;" class=" col-form-label">派工單號</label>
                            <select class="form-control col-sm" style="max-width:200px;margin:5px auto" name="Work_Num" onchange="initWorking(this)" required>
                                <option disabled hidden selected></option>
                            </select>
                        </div>
                        <div class="form-group row">
                            <label for="Emp_Name" style="margin:auto 5px;width:100px;" class=" col-form-label">加工人員</label>
                            <input type="text" class="form-control" style="max-width:200px;margin:auto" name="Emp_Name" disabled>
                        </div>
                        <div class="form-group row">
                            <label for="Order_Num" style="margin:auto 5px;width:100px;" class=" col-form-label">訂單編號</label>
                            <input type="text" class="form-control" style="max-width:200px;margin:auto" name="Order_Num" disabled>
                        </div>
                        <div class="form-group row">
                            <label for="Item_Num" style="margin:auto 5px;width:100px;" class=" col-form-label">品項</label>
                            <input type="text" class="form-control" style="max-width:200px;margin:auto" name="Item_Num" disabled>
                        </div>
                        <div class="form-group row">
                            <label for="Design_Num" style="margin:auto 5px;width:100px;" class=" col-form-label">塑身衣編號</label>
                            <input type="text" class="form-control" style="max-width:200px;margin:auto" name="Design_Num" disabled>
                        </div>
                        <div class="form-group row">
                            <label for="Work_Qty" style="margin:auto 5px;width:100px;" class=" col-form-label">件數</label>
                            <input type="number" min="0" class="form-control" style="max-width:200px;margin:auto" name="Work_Qty" disabled>
                        </div>
                        <hr />
                        <div class="form-group row">
                            <label style="margin:auto 5px;width:100px;" for="Design_Mate">材質選擇</label>
                            <select class="form-control" id="Design_Mate" style="max-width:200px;margin:auto" name="Design_Mate" disabled>
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group row">
                            <label style="margin:auto 5px;width:100px;" for="Item_Color">顏色</label>
                            <select class="form-control" id="Item_Color" style="max-width:200px;margin:auto" name="Item_Color" disabled>
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group row">
                            <label style="margin:auto 5px;width:100px;" for="Item_BgColor">基底色</label>
                            <select class="form-control" id="Item_BgColor" style="max-width:200px;margin:auto" name="Item_BgColor" disabled>
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group row">
                            <label style="margin:auto 5px;width:100px;" for="Item_Effect">塑身效果</label>
                            <select type="text" class="form-control" id="Item_Effect" style="max-width:200px;margin:auto;display:none" name="Item_Effect" onchange="$('#Item_Effect_Textarea').val($(this).children('option:selected').text())" disabled></textarea>
                                <option value=""></option>
                            </select>
                            <textarea class="form-control" id="Item_Effect_Textarea" style="max-width:200px;margin:auto" disabled></textarea>
                        </div>
                        <div class="form-group row">
                            <label style="margin:auto 5px;width:100px;" for="Item_Bside">乳側處理</label>
                            <select class="form-control" id="Item_Bside" style="max-width:200px;margin:auto" name="Item_Bside" disabled>
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group row">
                            <label style="margin:auto 5px;width:100px;" for="Item_Breast">乳房包覆</label>
                            <select class="form-control" id="Item_Breast" style="max-width:200px;margin:auto" name="Item_Breast" disabled>
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group row">
                            <label style="margin:auto 5px;width:100px;" for="Item_Cup">罩杯類型</label>
                            <select class="form-control" id="Item_Cup" style="max-width:200px;margin:auto" name="Item_Cup" disabled>
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group row">
                            <label style="margin:auto 5px;width:100px;" for="Item_Strap">肩帶類型</label>
                            <select class="form-control" id="Item_Strap" style="max-width:200px;margin:auto" name="Item_Strap" disabled>
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group row">
                            <label style="margin:auto 5px;width:100px;" for="Item_Spon">海綿需求</label>
                            <select class="form-control" id="Item_Spon" style="max-width:200px;margin:auto" name="Item_Spon" disabled>
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group row">
                            <label style="margin:auto 5px;width:100px;" for="Item_Pocket">口袋需求</label>
                            <select class="form-control" id="Item_Pocket" style="max-width:200px;margin:auto" name="Item_Pocket" disabled>
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group row">
                            <label style="margin:auto 5px;width:100px;" for="Item_Wear">釦鏈需求</label>
                            <select class="form-control" id="Item_Wear" style="max-width:200px;margin:auto" name="Item_Wear" disabled>
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group row">
                            <label style="margin:auto 5px;width:100px;" for="Item_Extra">特殊需求</label>
                            <textarea class="form-control" id="Item_Extra" style="max-width:200px;margin:auto" name="Item_Extra" disabled></textarea>
                        </div>
                    </div>

                    <hr />
                    <div style="overflow-x: auto;" class="collapse">
                        <table class="table table-hover" id="materialTable">
                            <thead style="text-align: center;">
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">品項</th>
                                    <th scope="col">用料編號</th>
                                    <th scope="col">用料名稱</th>
                                    <th scope="col">單位</th>
                                    <th scope="col">單件用量</th>
                                    <th scope="col">件數</th>
                                    <th scope="col">扣帳數量</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="vertical-align: middle;">
                                        <button type="button" class="btn-sm btn-danger" style="padding: 0px 10px;" onclick="deleteRow(this)">X</button>
                                    </td>
                                    <td style="vertical-align: middle;text-align: center;">--</td>
                                    <td style="vertical-align: middle;text-align: center;">--</td>
                                    <td style="vertical-align: middle;text-align: center;">--</td>
                                    <td style="vertical-align: middle;text-align: center;">--</td>
                                    <td style="vertical-align: middle;text-align: center;">--</td>
                                    <td style="vertical-align: middle;text-align: center;">--</td>
                                    <td style="vertical-align: middle;text-align: center;">--</td>
                                    <td style="vertical-align: middle;">
                                        <button type="button" class="btn-sm btn-warning" onclick="$(this).parent().children('.modal').modal('show');" style="word-break: keep-all;">明細</button>
                                        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="true" data-keyboard="false">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">品項明細</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="WU_Item">派料品項</label>
                                                            <input onchange="$(this).parents('tr').find('td').eq(1).text($(this).val())" placeholder="(自動編號)" type="text" class="form-control" id="WU_Item" name="WU_Item[]" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Mate_Num">用料編號</label>
                                                            <!--料品編號-->
                                                            <input onchange="$(this).parents('tr').find('td').eq(2).text($(this).val())" placeholder="(自動產生)" type="text" class="form-control" id="Mate_Num" name="Mate_Num[]" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="CT_No">用料大類</label>
                                                            <select class="form-control" id="CT_No" name="CT_No[]" onchange="setSubSelect(this)" required>
                                                                <option disabled hidden selected></option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="CI_No">用料小類</label>
                                                            <select class="form-control" id="CI_No" name="CI_No[]" onchange="setMaterialName(this)" required>
                                                                <option disabled hidden selected></option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Mate_Name">用料名稱</label>
                                                            <select onchange="$(this).parents('tr').find('td').eq(3).text($(this).children(':selected').text());setUnit(this)" class="form-control" id="Mate_Name" name="Mate_Name[]" required>
                                                                <option disabled hidden selected></option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Mate_Unit">單位</label>
                                                            <select onchange="$(this).parents('tr').find('td').eq(4).text($(this).children(':selected').text());" onkeyup="" type="text" class="form-control" id="Mate_Unit" name="Mate_Unit[]" disabled>
                                                                <option disabled hidden selected></option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="WU_Unit">單件用量</label>
                                                            <input type="number" min="0" step="0.001" onchange="$(this).parents('tr').find('td').eq(5).text($(this).val());calculate($(this).parents('tr'));" class="form-control" id="WU_Unit" name="WU_Unit[]" required>

                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Work_Qty">件數</label>
                                                            <input type="number" min="0" onchange="$(this).parents('tr').find('td').eq(6).text($(this).val());calculate($(this).parents('tr'));" class="form-control" id="Work_Qty" name="Work_Qty[]" disabled>

                                                        </div>
                                                        <div class="form-group">
                                                            <label for="WU_Qty">扣帳數量</label>
                                                            <input type="number" min="0" onchange="$(this).parents('tr').find('td').eq(7).text($(this).val())" class="form-control" id="WU_Qty" name="WU_Qty[]" readonly required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button id="addRowBtn" type="button" class="btn btn-info" style="margin:5px" onclick="addRow(this)">新增品項</button>


                    </div>
                    <div style="width:max-content;margin:auto">
                        <button id="submitBtn" style="margin:auto 5px" type="submit" class="btn btn-success">新增</button>
                        <button style="margin:auto 5px" type="button" class="btn btn-danger" onclick="history.back();">取消</button>
                    </div>
                </form>

                <script>
                    function deleteRow(btn) {
                        if ($(btn).parents('tr').find("input[name='WU_Item[]']").val() !== "") {
                            return;
                            url = new URL(window.location.href);
                            for (pair of url.searchParams.entries()) {
                                if (pair[0] === 'id') {
                                    $.ajax({
                                        type: 'DELETE',
                                        url: '/clothes/ajax/manage_ajax.php',
                                        data: {
                                            form: 'mateusaitem',
                                            id: pair[1],
                                            Item_Num: $(btn).parents('tr').find("input[name='Item_Num[]']").val()

                                        }, // serializes the form's elements.
                                        dataType: "json",
                                        success: function(json) {
                                            if (json['status'] === "success") {
                                                $(btn).parents('tr').remove();
                                                totalMoney();
                                            } else
                                                toastr.error(json.error, "ERROR"); // show response from the php script.
                                        }
                                    })
                                    return;
                                }
                            }
                        }
                        if ($("#materialTable tbody").eq(0).children('tr').length > 1 && confirm('確定刪除？')) {


                            $(btn).parents('tr').remove();
                            totalMoney();
                        }
                    }

                    function addRow(btn) {
                        $(btn).parent().children().children('tbody').append(rowHtml);

                        var index = $("#mateusaForm select[name='Work_Num']").val();
                        if (typeof Working_Array[index] !== 'undefined')
                            $("#mateusaForm input[name='Work_Qty[]']").val(Working_Array[index].Work_Qty).change();
                    }

                    function calculate(tr) {

                        var WU_Unit = tr.find("input[name='WU_Unit[]'").val();
                        var Work_Qty = tr.find("input[name='Work_Qty[]'").val();
                        tr.find("input[name='WU_Qty[]'").val(WU_Unit * Work_Qty).change();




                    }


                    $("#mateusaForm").submit(function(e) {


                        var form = $(this);
                        var url = form.attr('action');
                        var method = form.attr('method');

                        $.ajax({
                            type: method,
                            url: url,
                            data: form.serialize(), // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json.hasOwnProperty('status') && json['status'] === "success") {
                                    toastr.success("新增成功", "Success");
                                    history.back();

                                } else
                                    toastr.error(json.error, "ERROR"); // show response from the php script.


                            }
                        });

                        e.preventDefault(); // avoid to execute the actual submit of the form.


                    });



                    var CI_Array = new Array();
                    var CT_No_Array = ['B01', 'B02', 'B03', 'B04', 'B05', 'B06'];
                    var Material_Array = new Array();

                    function setSubSelect(obj) {
                        var index = $(obj).val();
                        $(obj).parents(".modal-body").find('#CI_No').empty().append('<option disabled hidden selected></option>');
                        for (i = 0; i < CI_Array[index].length; i++)
                            $(obj).parents(".modal-body").find('#CI_No').append($("<option></option>").attr("value", CI_Array[index][i]['CI_No']).text(CI_Array[index][i]['CI_Name']));

                    }

                    function setMaterialName(obj) {
                        Material_Array = new Array();
                        var index = $(obj).val();
                        $(obj).parents(".modal-body").find("#Mate_Name").empty().append('<option disabled hidden selected></option>');
                        $.ajax({
                            type: 'GET',
                            url: '/clothes/ajax/manage_ajax.php',
                            data: {
                                form: "material",
                                CT_No: $(obj).parents(".modal-body").find('#CT_No').val(),
                                CI_No: $(obj).val()
                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json.hasOwnProperty('error'))
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                                else {
                                    json['data'].forEach(element => {
                                        $(obj).parents(".modal-body").find("#Mate_Name").append($("<option></option>").attr("value", element.Mate_Num).text(element.Mate_Name));
                                        Material_Array[element.Mate_Num] = element;

                                    });
                                }

                            }
                        });
                    }

                    function setUnit(obj) {
                        var url = new URL(window.location.href);
                        for (pair of url.searchParams.entries()) {
                            if (pair[0] === 'id') {
                                return;
                            }
                        }
                        var index = $(obj).val();
                        $(obj).parents(".modal-body").find("input[name='Mate_Num[]']").val(index).change();
                        $(obj).parents(".modal-body").find("select[name='Mate_Unit[]']").val(Material_Array[index].Mate_Unit).change();

                    }

                    var rowHtml = "";

                    function initForm() {

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
                            $.ajax({
                                type: 'GET',
                                url: '/clothes/ajax/manage_ajax.php',
                                data: {
                                    form: "syscodetype",
                                    CT_No: CT_No_Array[zz]
                                }, // serializes the form's elements.
                                dataType: "json",
                                success: function(json) {
                                    if (json.hasOwnProperty('error'))
                                        toastr.error(json.error, "ERROR"); // show response from the php script.
                                    else {
                                        $('#CT_No').append($("<option></option>").attr("value", CT_No_Array[zz]).text(json['data'][0]['CT_Name']));
                                    }

                                }
                            });
                        }


                    };
                    var Working_Array = new Array();

                    function initWorking(obj) {

                        var index = $(obj).val();
                        $("#mateusaForm input[name='Emp_Name']").val(Working_Array[index].Emp_Name);
                        $("#mateusaForm input[name='Order_Num']").val(Working_Array[index].Order_Num);
                        $("#mateusaForm input[name='Item_Num']").val(Working_Array[index].Item_Num);
                        $("#mateusaForm input[name='Work_Qty']").val(Working_Array[index].Work_Qty);
                        $("#mateusaForm input[name='Work_Qty[]']").val(Working_Array[index].Work_Qty).change();

                        $.ajax({
                            type: "GET",
                            url: "/clothes/ajax/manage_ajax.php",
                            data: {
                                form: 'orderitem',
                                Order_Num: Working_Array[index].Order_Num,
                                Item_Num: Working_Array[index].Item_Num
                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json['status'] === 'success') {
                                    $("#mateusaForm input[name='Design_Num']").val(json['data'][0].Design_Num);
                                    $("#mateusaForm select[name='Design_Mate']").val(json['data'][0].Design_Mate);
                                    $("#mateusaForm select[name='Item_Color']").val(json['data'][0].Item_Color);
                                    $("#mateusaForm select[name='Item_BgColor']").val(json['data'][0].Item_BgColor);
                                    $("#mateusaForm select[name='Item_Effect']").val(json['data'][0].Item_Effect).change();
                                    $("#mateusaForm select[name='Item_Bside']").val(json['data'][0].Item_Bside);
                                    $("#mateusaForm select[name='Item_Breast']").val(json['data'][0].Item_Breast);
                                    $("#mateusaForm select[name='Item_Cup']").val(json['data'][0].Item_Cup);
                                    $("#mateusaForm select[name='Item_Strap']").val(json['data'][0].Item_Strap);
                                    $("#mateusaForm select[name='Item_Spon']").val(json['data'][0].Item_Spon);
                                    $("#mateusaForm select[name='Item_Pocket']").val(json['data'][0].Item_Pocket);
                                    $("#mateusaForm select[name='Item_Wear']").val(json['data'][0].Item_Wear);
                                    $("#mateusaForm textarea[name='Item_Extra']").val(json['data'][0].Item_Extra);

                                } else {
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                                }
                            }
                        });
                    }


                    $.when(initForm(),
                        $.ajax({
                            type: "GET",
                            url: "/clothes/ajax/manage_ajax.php",
                            data: {
                                form: 'syscodeinfo',
                                CT_No: 'B08'
                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json['status'] === 'success') {
                                    json['data'].forEach(element => $("#mateusaForm select[name='Mate_Unit[]']").append($("<option></option>").attr("value", element.CI_No).text(element.CI_Name)));
                                } else {
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                                }
                            }
                        }), $.ajax({
                            type: "GET",
                            url: "/clothes/ajax/manage_ajax.php",
                            data: {
                                form: 'working'
                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json['status'] === 'success') {
                                    json['data'].forEach(element => {
                                        $("#mateusaForm select[name='Work_Num']").append($("<option></option>").attr("value", element.Work_Num).text(element.Work_Num));
                                        Working_Array[element.Work_Num] = element;
                                    });
                                } else {
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                                }
                            }
                        }), $.ajax({
                            type: 'GET',
                            url: '/clothes/ajax/manage_ajax.php',
                            data: {
                                form: 'syscodeinfo',
                                CT_No: 'B01'

                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json['status'] === "success") {
                                    json['data'].forEach(obj => $("#mateusaForm select[name='Design_Mate']").append($("<option></option>").attr("value", obj.CI_No).text(obj.CI_Name + " - $" + obj.CI_Value)));
                                } else
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                            }
                        }), $.ajax({
                            type: 'GET',
                            url: '/clothes/ajax/manage_ajax.php',
                            data: {
                                form: 'syscodeinfo',
                                CT_No: 'B07'

                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json['status'] === "success") {
                                    json['data'].forEach(obj => {
                                        $("#mateusaForm select[name='Item_Color']").append($("<option></option>").attr("value", obj.CI_No).text(obj.CI_Name));
                                        $("#mateusaForm select[name='Item_BgColor']").append($("<option></option>").attr("value", obj.CI_No).text(obj.CI_Name));
                                    });
                                } else
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                            }
                        }), $.ajax({
                            type: 'GET',
                            url: '/clothes/ajax/manage_ajax.php',
                            data: {
                                form: 'syscodeinfo',
                                CT_No: 'A04'

                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json['status'] === "success") {
                                    json['data'].forEach(obj => {
                                        $("#mateusaForm select[name='Item_Effect']").append($("<option></option>").attr("value", obj.CI_No).text(obj.CI_Name + " - $" + obj.CI_Value));
                                    });
                                } else
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                            }
                        }), $.ajax({
                            type: 'GET',
                            url: '/clothes/ajax/manage_ajax.php',
                            data: {
                                form: 'syscodeinfo',
                                CT_No: 'A05'

                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json['status'] === "success") {
                                    json['data'].forEach(obj => {
                                        $("#mateusaForm select[name='Item_Bside']").append($("<option></option>").attr("value", obj.CI_No).text(obj.CI_Name));
                                    });
                                } else
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                            }
                        }), $.ajax({
                            type: 'GET',
                            url: '/clothes/ajax/manage_ajax.php',
                            data: {
                                form: 'syscodeinfo',
                                CT_No: 'A06'

                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json['status'] === "success") {
                                    json['data'].forEach(obj => {
                                        $("#mateusaForm select[name='Item_Breast']").append($("<option></option>").attr("value", obj.CI_No).text(obj.CI_Name));
                                    });
                                } else
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                            }
                        }), $.ajax({
                            type: 'GET',
                            url: '/clothes/ajax/manage_ajax.php',
                            data: {
                                form: 'syscodeinfo',
                                CT_No: 'A07'

                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json['status'] === "success") {
                                    json['data'].forEach(obj => {
                                        $("#mateusaForm select[name='Item_Spon']").append($("<option></option>").attr("value", obj.CI_No).text(obj.CI_Name));
                                    });
                                } else
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                            }
                        }), $.ajax({
                            type: 'GET',
                            url: '/clothes/ajax/manage_ajax.php',
                            data: {
                                form: 'syscodeinfo',
                                CT_No: 'A08'

                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json['status'] === "success") {
                                    json['data'].forEach(obj => {
                                        $("#mateusaForm select[name='Item_Cup']").append($("<option></option>").attr("value", obj.CI_No).text(obj.CI_Name));
                                    });
                                } else
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                            }
                        }), $.ajax({
                            type: 'GET',
                            url: '/clothes/ajax/manage_ajax.php',
                            data: {
                                form: 'syscodeinfo',
                                CT_No: 'A09'

                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json['status'] === "success") {
                                    json['data'].forEach(obj => {
                                        $("#mateusaForm select[name='Item_Pocket']").append($("<option></option>").attr("value", obj.CI_No).text(obj.CI_Name));
                                    });
                                } else
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                            }
                        }), $.ajax({
                            type: 'GET',
                            url: '/clothes/ajax/manage_ajax.php',
                            data: {
                                form: 'syscodeinfo',
                                CT_No: 'A10'

                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json['status'] === "success") {
                                    json['data'].forEach(obj => {
                                        $("#mateusaForm select[name='Item_Strap']").append($("<option></option>").attr("value", obj.CI_No).text(obj.CI_Name));
                                    });
                                } else
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                            }
                        }), $.ajax({
                            type: 'GET',
                            url: '/clothes/ajax/manage_ajax.php',
                            data: {
                                form: 'syscodeinfo',
                                CT_No: 'A11'

                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json['status'] === "success") {
                                    json['data'].forEach(obj => {
                                        $("#mateusaForm select[name='Item_Wear']").append($("<option></option>").attr("value", obj.CI_No).text(obj.CI_Name));
                                    });
                                } else
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                            }
                        })).done(function() {


                        rowHtml = "<tr>";
                        rowHtml += $(".collapse tbody tr").html();
                        rowHtml += "</tr>"


                        var url = new URL(window.location.href);
                        for (pair of url.searchParams.entries()) {
                            if (pair[0] === 'id') {
                                initialInfo(pair[1]);
                                return;
                            }
                        }

                        $(".collapse").collapse('show');




                    });

                    function initialInfo(id) {
                        $("#submitBtn").text('更新');
                        $("#addRowBtn").css('display', 'none');
                        $("#mateusaForm input[name='WU_Num']").attr('readonly', true);
                        $("#mateusaForm input[name='WU_Date']").attr('disabled', true);
                        $("#mateusaForm select[name='Work_Num']").attr('disabled', true);
                        $('#mateusaForm').attr('method', "PUT");

                        $.when($.ajax({
                            type: "GET",
                            url: "/clothes/ajax/manage_ajax.php",
                            data: {
                                form: "mateusa",
                                id: id
                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json['status'] === 'success') {
                                    if (json['data'].length === 0) {
                                        alert("此訂單不存在!");
                                        history.back();
                                    } else {



                                        $("#materialTable tbody tr").eq(0).remove();

                                        var index = 0;
                                        json['data'].forEach(obj => {
                                            $("#materialTable tbody").append(rowHtml);
                                            $("#materialTable input[name='WU_Item[]']").eq(index).val(obj.WU_Item).change();
                                            $("#materialTable input[name='Mate_Num[]']").eq(index).val(obj.Mate_Num).change();
                                            $("#materialTable select[name='CT_No[]']").eq(index).val(obj.CT_No).change();
                                            $("#materialTable select[name='CI_No[]']").eq(index).val(obj.CI_No).change();
                                            $("#materialTable input[name='WU_Qty[]']").eq(index).val(obj.WU_Qty).change();
                                            $("#materialTable select[name='Mate_Unit[]']").eq(index).val(obj.Mate_Unit).change();
                                            $("#materialTable input[name='WU_Unit[]']").eq(index).val(obj.WU_Unit).change();
                                            $("#materialTable select[name='Mate_Name[]']").eq(index).empty().append($("<option selected></option>").attr("value", json['data'][0].Mate_Num).text(json['data'][0].Mate_Name)).change();

                                            index += 1;
                                        });

                                        $("#mateusaForm input[name='WU_Num']").val(json['data'][0].WU_Num);
                                        $("#mateusaForm input[name='WU_Date']").val(json['data'][0].WU_Date);
                                        $("#mateusaForm select[name='Work_Num']").val(json['data'][0].Work_Num).change();
                                        $("#mateusaForm select[name='Work_Qty']").val(json['data'][0].Work_Qty).change();




                                    }
                                } else {
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                                    alert(json.error);
                                    history.back();

                                }



                            }
                        })).done(function() {
                            $("#mateusaForm select[name='CT_No[]']").attr('disabled', true);
                            $("#mateusaForm select[name='CI_No[]']").attr('disabled', true);
                            $("#mateusaForm select[name='Mate_Name[]']").attr('disabled', true);
                            $("#mateusaForm input[name='Mate_Num[]']").attr('disabled', true);

                            $(".collapse").collapse('show');


                        });




                    }
                </script>

            </div>
        </div>
    </section>
</body>

</html>