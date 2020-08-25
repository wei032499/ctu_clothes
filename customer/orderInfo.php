<?php
@require_once($_SERVER["DOCUMENT_ROOT"] . "/clothes/functions/functions.php");
if (isset($_GET['id'])) // 修改
{
    if (checkPermission(null, 'A01') < 1) {
        echo "<script>alert('無此權限');history.back();</script>";
        exit();
    }
} else // 新增 
{
    if (checkPermission(null, 'A01') < 2) {
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
                <a href="/clothes/customer/orderManage.php" class="text-dark">顧客訂單維護</a> /
                <a href="/clothes/customer/orderInfo.php" class="text-info">顧客訂單</a>
            </div>
        </div>
    </section>
    <section>

        <div class="container" style="margin: 10px auto">
            <div class="shadow p-3 mb-5 bg-white rounded" style="padding:2.5rem!important">
                <h1>顧客訂單</h1>
                <hr>
                <form id="orderForm" action="/clothes/ajax/manage_ajax.php" method="POST" style="margin:auto;width:90%">
                    <input type="text" name="form" value="order" style="display:none" />
                    <div style="width:max-content;margin:auto">
                        <div class="form-group row">
                            <label for="Order_Num" style="margin:auto 5px;width:100px;" class=" col-form-label">訂單編號</label>
                            <input type="text" class="form-control" style="max-width:200px;margin:auto" name="Order_Num" readonly>
                        </div>
                        <div class="form-group row">
                            <label for="Order_Date" style="margin:auto 5px;width:100px;" class=" col-form-label">訂單日期</label>
                            <input type="date" class="form-control" style="max-width:200px;margin:auto" name="Order_Date" value="<?php echo date("Y-m-d"); ?>" readonly required>
                        </div>

                        <div class="form-group row">
                            <label for="Cust_Birth" style="margin:auto 5px;width:100px;" class=" col-form-label">顧客</label>
                            <div class="col-sm" style="max-width:200px;margin:auto;padding:0px">
                                <input type="text" placeholder="搜尋顧客" class="form-control col-sm" style="max-width:200px;margin:5xp auto" id="searchCustomer">
                                <select class="form-control col-sm" style="max-width:200px;margin:5px auto" name="Cust_Num" required>
                                    <option disabled hidden selected></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="BodyM_Date" style="margin:auto 5px;width:100px;" class=" col-form-label">量身日期</label>
                            <input type="date" name="BodyM_Date" class="form-control readonly" style="max-width:200px;margin:auto;pointer-events: none" autocomplete="off" required>
                            <script>
                                $(".readonly").keydown(function(e) {
                                    e.preventDefault();
                                })
                            </script>
                        </div>
                        <div class="form-group row">
                            <label for="Plan_Date" style="margin:auto 5px;width:100px;" class=" col-form-label">預定交期</label>
                            <input type="date" class="form-control" style="max-width:200px;margin:auto" name="Plan_Date" value="<?php echo date('Y-m-d', strtotime('+14 day')); ?>" required>
                        </div>
                        <div class="form-group row">
                            <label for="DeliveryWay" style="margin:auto 5px;width:100px;" class=" col-form-label">預定交貨方式</label>
                            <select type="date" class="form-control" style="max-width:200px;margin:auto" name="DeliveryWay" required>
                                <option disabled hidden selected></option>
                            </select>
                        </div>
                        <div class="form-group row">
                            <label for="DeliveryAddr" style="margin:auto 5px;width:100px;" class=" col-form-label">送貨地點</label>
                            <div class="col-sm" style="max-width:200px;margin:auto;padding:0px">
                                <input class="form-control" type="text" style="max-width: 100px;margin:5px 0px" name="Order_Postal" placeholder="郵遞區號" required>
                                <textarea placeholder="地址" class="form-control" style="max-width:200px;margin:5px auto" name="DeliveryAddr" required></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Order_Qty" style="margin:auto 5px;width:100px;" class=" col-form-label">總件數</label>
                            <input type="number" min="0" class="form-control" style="max-width:200px;margin:auto" name="Order_Qty" readonly required>
                        </div>
                        <div class="form-group row">
                            <label for="Order_Amt" style="margin:auto 5px;width:100px;" class=" col-form-label">總金額</label>
                            <input type="number" min="0" class="form-control" style="max-width:200px;margin:auto" name="Order_Amt" readonly required>
                        </div>
                        <div class="form-group row">
                            <label for="Order_Deposit" style="margin:auto 5px;width:100px;" class=" col-form-label">付訂金額</label>
                            <input type="number" min="0" class="form-control" style="max-width:200px;margin:auto" name="Order_Deposit" required>
                        </div>
                    </div>

                    <hr />
                    <div style="overflow-x: auto;" class="collapse">
                        <table class="table table-hover" id="itemTable">
                            <thead style="text-align: center;">
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">品項</th>
                                    <th scope="col">塑身衣編號</th>
                                    <th scope="col">件數</th>
                                    <th scope="col">材質選擇</th>
                                    <th scope="col">顏色</th>
                                    <th scope="col">基底色</th>
                                    <th scope="col">塑身效果</th>
                                    <th scope="col">單價</th>
                                    <th scope="col">小計金額</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <script>
                                    function deleteRow(btn) {
                                        if ($(btn).parents('tr').find("input[name='Item_Num[]']").val() !== "") {
                                            return;
                                            url = new URL(window.location.href);
                                            for (pair of url.searchParams.entries()) {
                                                if (pair[0] === 'id') {
                                                    $.ajax({
                                                        type: 'DELETE',
                                                        url: '/clothes/ajax/manage_ajax.php',
                                                        data: {
                                                            form: 'orderitem',
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
                                        if ($("#itemTable tbody").eq(0).children('tr').length > 1 && confirm('確定刪除？')) {


                                            $(btn).parents('tr').remove();
                                            totalMoney();
                                        }
                                    }

                                    function addRow(btn) {
                                        $(btn).parent().children().children('tbody').append(rowHtml);
                                    }

                                    function calculate(tr) {
                                        var Design_Mate = tr.find("select[name='Design_Mate[]'] option:selected").text();
                                        var Item_Effect = tr.find("select[name='Item_Effect[]'] option:selected").text();

                                        var Design_Mate_Price = parseFloat(Design_Mate.split(' - $').pop());
                                        var Item_Effect_Price = parseFloat(Item_Effect.split(' - $').pop());
                                        var Item_EPrice = parseFloat(tr.find("input[name='Item_EPrice[]']").val());
                                        var Item_Price = Design_Mate_Price + Item_Effect_Price + Item_EPrice;
                                        tr.find("input[name='Item_Price[]']").val(Item_Price).change();
                                        var Item_Qty = parseFloat(tr.find("input[name='Item_Qty[]']").val());

                                        tr.find("input[name='Item_Amt[]']").val(Item_Price * Item_Qty).change();
                                        totalMoney();


                                    }

                                    function totalMoney() {
                                        var itemQtys = 0;
                                        var itemAmts = 0;
                                        for (i = 0; i < $("#orderForm input[name='Item_Amt[]']").length; i++) {
                                            itemQtys += parseFloat($("#orderForm input[name='Item_Qty[]']").eq(i).val());
                                            itemAmts += parseFloat($("#orderForm input[name='Item_Amt[]']").eq(i).val());
                                        }
                                        $("#orderForm input[name='Order_Qty']").val(itemQtys);
                                        $("#orderForm input[name='Order_Amt']").val(itemAmts);
                                    }
                                </script>
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
                                                            <label for="Item_Num">品項編號</label>
                                                            <input onchange="$(this).parents('tr').find('td').eq(1).text($(this).val())" placeholder="(自動編號)" type="text" class="form-control" id="Item_Num" name="Item_Num[]" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Design_Num">塑身衣編號</label>
                                                            <input onchange="$(this).parents('tr').find('td').eq(2).text($(this).val())" type="text" class="form-control" id="Design_Num" name="Design_Num[]" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Item_Price">單價</label>
                                                            <input onchange="$(this).parents('tr').find('td').eq(8).text('$'+$(this).val());" type="number" min="0" class="form-control" id="Item_Price" name="Item_Price[]" readonly required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Item_Qty">件數</label>
                                                            <input onchange="$(this).parents('tr').find('td').eq(3).text($(this).val());calculate($(this).parents('tr'))" type="number" min="1" class="form-control" id="Item_Qty" name="Item_Qty[]" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Design_Mate">材質選擇</label>
                                                            <select onchange="$(this).parents('tr').find('td').eq(4).text($(this).children(':selected').text());calculate($(this).parents('tr'))" class="form-control" id="Design_Mate" name="Design_Mate[]" required>
                                                                <option disabled hidden selected></option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Item_Color">顏色</label>
                                                            <select onchange="$(this).parents('tr').find('td').eq(5).text($(this).children(':selected').text())" class="form-control" id="Item_Color" name="Item_Color[]" required>
                                                                <option disabled hidden selected></option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Item_BgColor">基底色</label>
                                                            <select onchange="$(this).parents('tr').find('td').eq(6).text($(this).children(':selected').text())" class="form-control" id="Item_BgColor" name="Item_BgColor[]" required>
                                                                <option disabled hidden selected></option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Item_Effect">塑身效果</label>
                                                            <select onchange="$(this).parents('tr').find('td').eq(7).text($(this).children(':selected').text());calculate($(this).parents('tr'))" class="form-control" id="Item_Effect" name="Item_Effect[]" required>
                                                                <option disabled hidden selected></option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Item_Bside">乳側處理</label>
                                                            <select class="form-control" id="Item_Bside" name="Item_Bside[]" required>
                                                                <option disabled hidden selected></option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Item_Breast">乳房包覆</label>
                                                            <select class="form-control" id="Item_Breast" name="Item_Breast[]" required>
                                                                <option disabled hidden selected></option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Item_Spon">海綿需求</label>
                                                            <select class="form-control" id="Item_Spon" name="Item_Spon[]" required>
                                                                <option disabled hidden selected></option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Item_Cup">罩杯類型</label>
                                                            <select class="form-control" id="Item_Cup" name="Item_Cup[]" required>
                                                                <option disabled hidden selected></option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Item_Pocket">口袋需求</label>
                                                            <select class="form-control" id="Item_Pocket" name="Item_Pocket[]" required>
                                                                <option disabled hidden selected></option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Item_Strap">肩帶類型</label>
                                                            <select class="form-control" id="Item_Strap" name="Item_Strap[]" required>
                                                                <option disabled hidden selected></option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Item_Wear">釦鏈需求</label>
                                                            <select class="form-control" id="Item_Wear" name="Item_Wear[]" required>
                                                                <option disabled hidden selected></option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Item_Extra">特殊需求</label>
                                                            <textarea class="form-control" id="Item_Extra" name="Item_Extra[]"></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Item_EPrice">特殊需求加價(每單件)</label>
                                                            <input type="number" value="0" min="0" class="form-control" id="Item_EPrice" name="Item_EPrice[]" onchange="calculate($(this).parents('tr'))" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Item_Amt">小記金額</label>
                                                            <input onchange="$(this).parents('tr').find('td').eq(9).text('$' + $(this).val())" type="number" class="form-control" id="Item_Amt" name="Item_Amt[]" readonly required>
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
                    $("#orderForm").submit(function(e) {


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

                    function searchCustomer(obj) {
                        val = $("#searchCustomer").val();
                        obj.Cust_Tel = obj.Cust_Tel.replace('-', '');
                        obj.Cust_Mobile = obj.Cust_Mobile.replace('-', '');
                        if (val === '' || obj.Cust_Name.includes(val) || obj.Cust_Num.includes(val) || obj.Cust_Tel.includes(val) || obj.Cust_Mobile.includes(val))
                            return true;
                        return false;
                    }


                    /*$.ajax({
                        type: "GET",
                        url: "/clothes/ajax/manage_ajax.php",
                        data: {
                            form: 'syscodeinfo',
                            CT_No: 'A01'
                        }, // serializes the form's elements.
                        dataType: "json",
                        success: function(json) {
                            if (json['status'] === 'success') {
                                json['data'].forEach(element => $("#orderForm select[name='OrderStatus']").append($("<option></option>").attr("value", element.CI_No).text(element.CI_Name)));
                            } else {
                                toastr.error(json.error, "ERROR"); // show response from the php script.
                            }
                        }
                    });*/

                    var rowHtml = "";

                    $.when($.ajax({
                            type: "GET",
                            url: "/clothes/ajax/manage_ajax.php",
                            data: {
                                form: "customer"
                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json['status'] === 'success') {
                                    json['data'].forEach(element => $("#orderForm select[name='Cust_Num']").append($("<option></option>").attr("value", element.Cust_Num).text(element.Cust_Name)));

                                    $("#searchCustomer").on('keyup', function(e) {
                                        $("#orderForm input[name='BodyM_Date']").val('');
                                        objs = json['data'].filter(searchCustomer);
                                        $("#orderForm select[name='Cust_Num']").empty();
                                        objs.forEach(element => $("#orderForm select[name='Cust_Num']").append($("<option></option>").attr("value", element.Cust_Num).text(element.Cust_Name)));

                                    });
                                    $("#searchCustomer").on('change', function(e) {
                                        $("#orderForm select[name='Cust_Num']").on('change');
                                        $("#orderForm input[name='BodyM_Date']").val('');
                                        objs = json['data'].filter(searchCustomer);
                                        $("#orderForm select[name='Cust_Num']").empty();
                                        objs.forEach(element => {
                                            $("#orderForm select[name='Cust_Num']").append($("<option></option>").attr("value", element.Cust_Num).text(element.Cust_Name))
                                        });
                                        $("#orderForm select[name='Cust_Num']").change();
                                        $("#searchCustomer").val($("#orderForm select[name='Cust_Num']").val());
                                    });

                                    $("#orderForm select[name='Cust_Num']").change(function() {
                                        $("#orderForm input[name='BodyM_Date']").val('');
                                        if (!$("#searchCustomer").is(":focus"))
                                            $("#searchCustomer").val($("#orderForm select[name='Cust_Num']").val());

                                        obj = json['data'].find(element => element.Cust_Num === $("#orderForm select[name='Cust_Num']").val());
                                        $("#orderForm input[name='Order_Postal']").val(obj.Cust_Postal);
                                        $("#orderForm textarea[name='DeliveryAddr']").val(obj.Cust_Addr);
                                        $.ajax({
                                            type: "GET",
                                            url: "/clothes/ajax/manage_ajax.php",
                                            data: {
                                                form: "measurement",
                                                id: obj.Cust_Num,
                                                limit: 1
                                            }, // serializes the form's elements.
                                            dataType: "json",
                                            success: function(json) {
                                                if (json['status'] === 'success') {
                                                    if (json['data'].length === 0) {

                                                        toastr.error("查無量身資料!", "ERROR");
                                                    } else {
                                                        $("#orderForm input[name='BodyM_Date']").val(json['data'][0].BodyM_Date);
                                                    }
                                                } else {
                                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                                                    alert(json.error);
                                                    history.back();

                                                }



                                            }
                                        })
                                    });

                                } else {
                                    toastr.error(json.error, "ERROR"); // show response from the php script.

                                }

                            }
                        }),
                        $.ajax({
                            type: "GET",
                            url: "/clothes/ajax/manage_ajax.php",
                            data: {
                                form: 'syscodeinfo',
                                CT_No: 'A03'
                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json['status'] === 'success') {
                                    json['data'].forEach(element => $("#orderForm select[name='DeliveryWay']").append($("<option></option>").attr("value", element.CI_No).text(element.CI_Name)));
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
                                    json['data'].forEach(obj => $("#orderForm select[name='Design_Mate[]']").append($("<option></option>").attr("value", obj.CI_No).text(obj.CI_Name + " - $" + obj.CI_Value)));
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
                                        $("#orderForm select[name='Item_Color[]']").append($("<option></option>").attr("value", obj.CI_No).text(obj.CI_Name));
                                        $("#orderForm select[name='Item_BgColor[]']").append($("<option></option>").attr("value", obj.CI_No).text(obj.CI_Name));
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
                                        $("#orderForm select[name='Item_Effect[]']").append($("<option></option>").attr("value", obj.CI_No).text(obj.CI_Name + " - $" + obj.CI_Value));
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
                                        $("#orderForm select[name='Item_Bside[]']").append($("<option></option>").attr("value", obj.CI_No).text(obj.CI_Name));
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
                                        $("#orderForm select[name='Item_Breast[]']").append($("<option></option>").attr("value", obj.CI_No).text(obj.CI_Name));
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
                                        $("#orderForm select[name='Item_Spon[]']").append($("<option></option>").attr("value", obj.CI_No).text(obj.CI_Name));
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
                                        $("#orderForm select[name='Item_Cup[]']").append($("<option></option>").attr("value", obj.CI_No).text(obj.CI_Name));
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
                                        $("#orderForm select[name='Item_Pocket[]']").append($("<option></option>").attr("value", obj.CI_No).text(obj.CI_Name));
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
                                        $("#orderForm select[name='Item_Strap[]']").append($("<option></option>").attr("value", obj.CI_No).text(obj.CI_Name));
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
                                        $("#orderForm select[name='Item_Wear[]']").append($("<option></option>").attr("value", obj.CI_No).text(obj.CI_Name));
                                    });
                                } else
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                            }
                        })).done(function() {
                        rowHtml = "<tr>";
                        rowHtml += $(".collapse tbody tr").html();
                        rowHtml += "</tr>"


                        url = new URL(window.location.href);
                        for (pair of url.searchParams.entries()) {
                            if (pair[0] === 'id') {
                                $(".container").find("h1").eq(0).text("顧客訂單 - 修改");
                                initialInfo(pair[1]);
                                return;
                            }
                        }
                        $(".container").find("h1").eq(0).text("顧客訂單 - 新增");

                        $(".collapse").collapse('show');




                    });

                    function initialInfo(id) {
                        $("#submitBtn").text('更新');
                        $("#searchCustomer").off('change');
                        $("#searchCustomer").off('keyup');
                        $("#orderForm select[name='Cust_Num']").off('change');
                        $("#addRowBtn").css('display', 'none');
                        $("#orderForm select[name='Cust_Num']").parent().children().attr('readonly', true);
                        $('#orderForm').attr('method', "PUT");

                        var status = 0;
                        $.when($.ajax({
                            type: "GET",
                            url: "/clothes/ajax/manage_ajax.php",
                            data: {
                                form: "order",
                                id: id
                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json['status'] === 'success') {
                                    if (json['data'].length === 0) {
                                        alert("此訂單不存在!");
                                        history.back();
                                    } else {

                                        if (<?php echo "'" . $_SESSION['role'] . "'"; ?> !== '000' && json['data'][0].Bran_Num !== <?php echo "'" . $_SESSION['Bran_Num'] . "'"; ?>) {
                                            /*alert("非建檔分店人員，不可修改訂單");
                                            history.back();*/
                                            $(".container").find("h1").eq(0).text("顧客訂單 - 檢視");
                                            $("#submitBtn").css('display', 'none');
                                        }

                                        status = parseInt(json['data'][0].OrderStatus);




                                        $("#orderForm input[name='Order_Num']").val(json['data'][0].Order_Num);
                                        $("#orderForm input[name='Order_Date']").val(json['data'][0].Order_Date);
                                        $("#searchCustomer").val(json['data'][0].Cust_Num);
                                        $("#orderForm input[name='BodyM_Date']").val(json['data'][0].BodyM_Date);
                                        $("#orderForm input[name='Plan_Date']").val(json['data'][0].Plan_Date);
                                        $("#orderForm select[name='DeliveryWay']").val(json['data'][0].DeliveryWay);
                                        $("#orderForm input[name='Order_Postal']").val(json['data'][0].Order_Postal);
                                        $("#orderForm textarea[name='DeliveryAddr']").val(json['data'][0].DeliveryAddr);
                                        $("#orderForm input[name='Order_Qty']").val(json['data'][0].Order_Qty);
                                        $("#orderForm input[name='Order_Amt']").val(json['data'][0].Order_Amt);
                                        $("#orderForm input[name='Order_Deposit']").val(json['data'][0].Order_Deposit);
                                        $("#orderForm select[name='Cust_Num']").empty().append($("<option selected></option>").attr("value", json['data'][0].Cust_Num).text(json['data'][0].Cust_Name));
                                        $("#orderForm select[name='Cust_Num']").val(json['data'][0].Cust_Num);

                                    }
                                } else {
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                                    alert(json.error);
                                    history.back();

                                }



                            }
                        }), $.ajax({
                            type: "GET",
                            url: "/clothes/ajax/manage_ajax.php",
                            data: {
                                form: "orderitem",
                                id: id
                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json['status'] === 'success') {
                                    /*if (json['data'].length === 0) {
                                        alert("此訂單不存在!");
                                        history.back();
                                    } else {*/
                                    $("#itemTable tbody tr").eq(0).remove();

                                    var index = 0;
                                    json['data'].forEach(obj => {

                                        $("#itemTable tbody").append(rowHtml);
                                        $("#itemTable input[name='Item_Num[]']").eq(index).val(obj.Item_Num).change();
                                        $("#itemTable input[name='Design_Num[]']").eq(index).val(obj.Design_Num).change();
                                        //$("#itemTable input[name='Item_Price[]']").eq(index).val(obj.Item_Price).change();
                                        $("#itemTable input[name='Item_Qty[]']").eq(index).val(obj.Item_Qty).change();
                                        $("#itemTable select[name='Design_Mate[]']").eq(index).val(obj.Design_Mate).change();
                                        $("#itemTable select[name='Item_Color[]']").eq(index).val(obj.Item_Color).change();
                                        $("#itemTable select[name='Item_BgColor[]']").eq(index).val(obj.Item_BgColor).change();
                                        $("#itemTable select[name='Item_Effect[]']").eq(index).val(obj.Item_Effect).change();
                                        $("#itemTable select[name='Item_Bside[]']").eq(index).val(obj.Item_Bside).change();
                                        $("#itemTable select[name='Item_Breast[]']").eq(index).val(obj.Item_Breast).change();
                                        $("#itemTable select[name='Item_Spon[]']").eq(index).val(obj.Item_Spon).change();
                                        $("#itemTable select[name='Item_Cup[]']").eq(index).val(obj.Item_Cup).change();
                                        $("#itemTable select[name='Item_Pocket[]']").eq(index).val(obj.Item_Pocket).change();
                                        $("#itemTable select[name='Item_Strap[]']").eq(index).val(obj.Item_Strap).change();
                                        $("#itemTable select[name='Item_Wear[]']").eq(index).val(obj.Item_Wear).change();
                                        $("#itemTable textarea[name='Item_Extra[]']").eq(index).val(obj.Item_Extra).change();
                                        $("#itemTable input[name='Item_EPrice[]']").eq(index).val(obj.Item_EPrice).change();
                                        $("#itemTable input[name='Item_Amt[]']").eq(index).val(obj.Item_Amt).change();
                                        index += 1;
                                    });


                                    //}
                                } else {
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                                    alert(json.error);
                                    history.back();

                                }



                            }
                        })).done(function() {
                            if (status > 0) {
                                $("#orderForm input[name='Order_Deposit']").attr('disabled', true);
                                $("#itemTable input[name='Design_Num[]']").attr('disabled', true);
                                $("#itemTable select[name='Design_Mate[]']").attr('disabled', true);
                                $("#itemTable select[name='Item_Color[]']").attr('disabled', true);
                                $("#itemTable select[name='Item_BgColor[]']").attr('disabled', true);
                                $("#itemTable select[name='Item_Effect[]']").attr('disabled', true);
                            }

                            if (status >= 1) {
                                for (i = 0; i < $("#itemTable input[name='Item_Qty[]']").length; i++) {
                                    min = $("#itemTable input[name='Item_Qty[]']").eq(i).val();
                                    $("#itemTable input[name='Item_Qty[]']").eq(i).attr('min', min);
                                }
                            }

                            $(".collapse").collapse('show');


                        });




                    }
                </script>

            </div>
        </div>
    </section>
</body>

</html>