<?php
@require_once($_SERVER["DOCUMENT_ROOT"] . "/clothes/functions/functions.php");
if (isset($_GET['id'])) // 修改
{
    if (checkPermission(null, 'A06') < 1) {
        echo "<script>alert('無此權限');history.back();</script>";
        exit();
    }
} else // 新增 
{
    if (checkPermission(null, 'A06') < 2) {
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
                <a href="/clothes/customer/orderStatusManage.php" class="text-dark">訂單狀態維護</a> /
                <a href="/clothes/customer/orderStatusInfo.php" class="text-info">訂單狀態</a>
            </div>
        </div>
    </section>
    <section>

        <div class="container" style="margin: 10px auto">
            <div class="shadow p-3 mb-5 bg-white rounded" style="padding:2.5rem!important">
                <h1>訂單狀態</h1>
                <hr>
                <form id="orderForm" action="/clothes/ajax/manage_ajax.php" method="PUT" style="margin:auto;width:90%">
                    <input type="text" name="form" value="orderstatus" style="display:none" />
                    <div style="width:max-content;margin:auto">
                        <div class="form-group row">
                            <label for="Order_Num" style="margin:auto 5px;width:100px;" class=" col-form-label">訂單編號</label>
                            <input type="text" class="form-control" style="max-width:200px;margin:auto" name="Order_Num" readonly>
                        </div>
                        <div class="form-group row">
                            <label for="Cust_Birth" style="margin:auto 5px;width:100px;" class=" col-form-label">顧客</label>
                            <div class="col-sm" style="max-width:200px;margin:auto;padding:0px">
                                <input type="text" placeholder="搜尋顧客" class="form-control col-sm" style="max-width:200px;margin:5xp auto" id="searchCustomer" disabled>
                                <select class="form-control col-sm" style="max-width:200px;margin:5px auto" name="Cust_Num" disabled>
                                    <option disabled hidden selected></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="OrderStatus" style="margin:auto 5px;width:100px;" class=" col-form-label">訂單狀態</label>
                            <select class="form-control" style="max-width:200px;margin:auto" name="OrderStatus" required>
                                <option disabled hidden selected></option>
                            </select>
                        </div>

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




                    $.when(
                        $.ajax({
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
                        })).done(function() {


                        url = new URL(window.location.href);
                        for (pair of url.searchParams.entries()) {
                            if (pair[0] === 'id') {
                                initialInfo(pair[1]);
                                return;
                            }
                        }

                        window.location.replace('/clothes/customer/orderStatusManage.php');





                    });

                    function initialInfo(id) {
                        $("#submitBtn").text('更新');
                        $('#orderForm').attr('method', "PUT");

                        $.ajax({
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

                                        $("#orderForm input[name='Order_Num']").val(json['data'][0].Order_Num);
                                        $("#searchCustomer").val(json['data'][0].Cust_Num);
                                        $("#orderForm select[name='OrderStatus']").val(json['data'][0].OrderStatus);
                                        $("#orderForm select[name='Cust_Num']").empty().append($("<option selected></option>").attr("value", json['data'][0].Cust_Num).text(json['data'][0].Cust_Name));
                                        $("#orderForm select[name='Cust_Num']").val(json['data'][0].Cust_Num);

                                    }
                                } else {
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                                    alert(json.error);
                                    history.back();

                                }



                            }
                        })



                    }
                </script>

            </div>
        </div>
    </section>
</body>

</html>