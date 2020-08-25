<?php
@require_once($_SERVER["DOCUMENT_ROOT"] . "/clothes/functions/functions.php");
if (isset($_GET['id'])) // 修改
{
    if (checkPermission(null, 'A04') < 1) {
        echo "<script>alert('無此權限');history.back();</script>";
        exit();
    }
} else // 新增 
{
    if (checkPermission(null, 'A04') < 2) {
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
                <a href="/clothes/customer/workingManage.php" class="text-dark">訂單派工維護</a> /
                <a href="/clothes/customer/workingInfo.php" class="text-info">訂單派工單</a>
            </div>
        </div>
    </section>
    <section>
        <div class="container" style="margin: 10px auto">
            <div class="shadow p-3 mb-5 bg-white rounded" style="padding:2.5rem!important">
                <h1>訂單派工單</h1>
                <hr>
                <form id="workingForm" action="/clothes/ajax/manage_ajax.php" method="POST" style="margin:auto;width:90%">
                    <input type="text" name="form" value="working" style="display:none" />
                    <div style="width:max-content;margin:auto">
                        <div class="form-group row" style="justify-content: center;">
                            <label for="Work_Num" style="margin:auto 5px;width:100px;" class=" col-form-label">派工單號</label>
                            <input type="text" class="form-control" placeholder="(自動產生)" style="max-width: 200px;margin-left:5px" name="Work_Num" readonly>
                        </div>
                        <div class="form-group row" style="justify-content: center;">
                            <label for="Work_Type" style="margin:auto 5px;width:100px;" class=" col-form-label">派工類型</label>
                            <select type="text" class="form-control" style="max-width: 200px;margin-left:5px" name="Work_Type" required>
                            </select>
                        </div>
                        <div class="form-group row" style="justify-content: center;">
                            <label for="Work_Date" style="margin:auto 5px;width:100px;" class=" col-form-label">派工日期</label>
                            <input type="date" class="form-control" style="max-width: 200px;margin-left:5px" name="Work_Date" value="<?php echo date("Y-m-d"); ?>" required>
                        </div>
                        <hr />
                        <div class="form-group row" style="justify-content: center;">
                            <label for="Sour_Po" style="margin:auto 5px;width:100px;" class=" col-form-label">來源進料單</label>
                            <input type="text" class="form-control" style="max-width: 200px;margin-left:5px" name="Sour_Po" required disabled>
                        </div>
                        <div class="form-group row" style="justify-content: center;">
                            <label for="Dest_Po" style="margin:auto 5px;width:100px;" class=" col-form-label">目的進料單</label>
                            <input type="text" class="form-control" style="max-width: 200px;margin-left:5px" name="Dest_Po" required disabled>
                        </div>
                        <hr />
                        <div class="form-group row" style="justify-content: center;">
                            <label for="Order_Num" style="margin:auto 5px;width:100px;" class=" col-form-label">訂單編號</label>
                            <select type="text" class="form-control" style="max-width: 200px;margin-left:5px" name="Order_Num" required>
                                <option hidden disabled selected></option>
                            </select>
                        </div>
                        <div class="form-group row" style="justify-content: center;">
                            <label for="Cust_Name" style="margin:auto 5px;width:100px;" class=" col-form-label">顧客姓名</label>
                            <input type="text" class="form-control" style="max-width: 200px;margin-left:5px" name="Cust_Name" disabled>
                        </div>
                        <div class="form-group row" style="justify-content: center;">
                            <label for="Item_Num" style="margin:auto 5px;width:100px;" class=" col-form-label">訂單品項</label>
                            <select type="text" class="form-control" style="max-width: 200px;margin-left:5px" name="Item_Num" required>
                                <option hidden disabled selected></option>
                            </select>
                        </div>
                        <div class="form-group row" style="justify-content: center;">
                            <label for="Item_Qty" style="margin:auto 5px;width:100px;" class=" col-form-label">品項數量</label>
                            <input type="text" class="form-control" style="max-width: 200px;margin-left:5px" name="Item_Qty" disabled>
                        </div>
                        <div class="form-group row" style="justify-content: center;">
                            <label for="Item_Work_Qty" style="margin:auto 5px;width:100px;" class=" col-form-label">已派工件數</label>
                            <input type="text" class="form-control" style="max-width: 200px;margin-left:5px" name="Item_Work_Qty" disabled>
                        </div>
                        <div class="form-group row" style="justify-content: center;">
                            <label for="Plan_Arrive" style="margin:auto 5px;width:100px;" class=" col-form-label">預定到貨日</label>
                            <input type="date" class="form-control" style="max-width: 200px;margin-left:5px" name="Plan_Arrive" required>
                        </div>
                        <div class="form-group row" style="justify-content: center;">
                            <label for="Work_Emp" style="margin:auto 5px;width:100px;" class=" col-form-label">加工人員</label>
                            <select type="text" class="form-control" style="max-width: 200px;margin-left:5px" name="Work_Emp" required>
                                <option hidden disabled selected></option>
                            </select>
                        </div>
                        <div class="form-group row" style="justify-content: center;">
                            <label for="Work_Price" style="margin:auto 5px;width:100px;" class=" col-form-label">加工單價</label>
                            <input type="number" min="0" class="form-control" style="max-width: 200px;margin-left:5px" name="Work_Price" required>
                        </div>
                        <div class="form-group row" style="justify-content: center;">
                            <label for="Work_Qty" style="margin:auto 5px;width:100px;" class=" col-form-label">加工件數</label>
                            <input type="number" min="0" class="form-control" style="max-width: 200px;margin-left:5px" name="Work_Qty" required>
                        </div>
                        <div class="form-group row" style="justify-content: center;">
                            <label for="Work_Memo" style="margin:auto 5px;width:100px;" class=" col-form-label">加工備註</label>
                            <textarea class="form-control" style="max-width: 200px;margin-left:5px" name="Work_Memo"></textarea>
                        </div>
                        <hr />
                        <div class="form-group row" style="justify-content: center;">
                            <label for="ProtoM_Num" style="margin:auto 5px;width:100px;" class=" col-form-label">原型圖編號</label>
                            <input type="text" class="form-control" style="max-width: 200px;margin-left:5px" name="ProtoM_Num">
                        </div>
                        <div class="form-group row" style="justify-content: center;">
                            <label for="Cust_Num" style="margin:auto 5px;width:100px;" class=" col-form-label">客製圖編號</label>
                            <input type="text" class="form-control" style="max-width: 200px;margin-left:5px" name="Cust_Num">
                        </div>
                        <div class="form-group row" style="justify-content: center;">
                            <label for="Addtime" style="margin:auto 5px;width:100px;" class=" col-form-label">建檔時間</label>
                            <input type="text" class="form-control" style="max-width: 200px;margin-left:5px" name="Addtime" disabled>
                        </div>
                    </div>
                    <div style="width:max-content;margin:auto">
                        <button id="submitBtn" style="margin:auto 5px" type="submit" class="btn btn-success">新增</button>
                        <button style="margin:auto 5px" type="button" class="btn btn-danger" onclick="history.back();">取消</button>
                    </div>

                </form>

                <script>
                    $("#workingForm").submit(function(e) {

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



                    $("#workingForm select[name='Work_Type']").change(function() {
                        if ($(this).val() === '00A') {
                            $("#workingForm input[name='Sour_Po']").attr('disabled', 'disabled');
                            $("#workingForm input[name='Dest_Po']").attr('disabled', 'disabled');
                            $("#workingForm select[name='Order_Num']").removeAttr('disabled');
                            $("#workingForm select[name='Item_Num']").removeAttr('disabled');
                            $("#workingForm input[name='Work_Qty']").removeAttr('disabled');
                            $("#workingForm input[name='Plan_Arrive']").removeAttr('disabled');
                            $("#workingForm select[name='Work_Emp']").removeAttr('disabled');
                            $("#workingForm input[name='Work_Price']").removeAttr('disabled');
                            $("#workingForm textarea[name='Work_Memo']").removeAttr('disabled');
                            $("#workingForm input[name='ProtoM_Num']").removeAttr('disabled');
                            $("#workingForm input[name='Cust_Num']").removeAttr('disabled');

                            $("#workingForm input[name='Sour_Po']").val('');
                            $("#workingForm input[name='Dest_Po']").val('');

                        } else if ($(this).val() === '00B') {
                            $("#workingForm input[name='Sour_Po']").removeAttr('disabled');
                            $("#workingForm input[name='Dest_Po']").removeAttr('disabled');
                            $("#workingForm select[name='Order_Num']").attr('disabled', 'disabled');
                            $("#workingForm select[name='Item_Num']").attr('disabled', 'disabled');
                            $("#workingForm input[name='Work_Qty']").attr('disabled', 'disabled');
                            $("#workingForm input[name='Plan_Arrive']").attr('disabled', 'disabled');
                            $("#workingForm select[name='Work_Emp']").attr('disabled', 'disabled');
                            $("#workingForm input[name='Work_Price']").attr('disabled', 'disabled');
                            $("#workingForm textarea[name='Work_Memo']").attr('disabled', 'disabled');
                            $("#workingForm input[name='ProtoM_Num']").attr('disabled', 'disabled');
                            $("#workingForm input[name='Cust_Num']").attr('disabled', 'disabled');

                            $("#workingForm select[name='Order_Num']").val('');
                            $("#workingForm select[name='Item_Num']").val('');
                            $("#workingForm input[name='Work_Qty']").val('');
                            $("#workingForm input[name='Plan_Arrive']").val('');
                            $("#workingForm select[name='Work_Emp']").val('');
                            $("#workingForm input[name='Work_Price']").val('');
                            $("#workingForm textarea[name='Work_Memo']").val('');
                            $("#workingForm input[name='ProtoM_Num']").val('');
                            $("#workingForm input[name='Cust_Num']").val('');
                        }
                    })

                    function initialInfo(id) {
                        $('#workingForm').attr('method', "PUT");
                        //$("#record").css('display', '');
                        $("#submitBtn").text('更新');

                        $.ajax({
                            type: "GET",
                            url: "/clothes/ajax/manage_ajax.php",
                            data: {
                                form: "working",
                                id: id
                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json['status'] === 'success') {
                                    if (json['data'].length === 0) {
                                        alert("此派工單不存在!");
                                        history.go(-1);
                                    } else {
                                        if (json['data'][0].Work_Status === 0) {
                                            $(".container").find("h1").eq(0).text("訂單派工單 - 修改");
                                        } else {
                                            $(".container").find("h1").eq(0).text("訂單派工單 - 檢視");
                                            $("#submitBtn").css('display', 'none');
                                        }

                                        $("#workingForm input[name='Work_Num']").val(json['data'][0].Work_Num);
                                        $("#workingForm select[name='Work_Type']").val(json['data'][0].Work_Type).change();
                                        $("#workingForm input[name='Work_Date']").val(json['data'][0].Work_Date);
                                        $("#workingForm input[name='Sour_Po']").val(json['data'][0].Sour_Po);
                                        $("#workingForm input[name='Dest_Po']").val(json['data'][0].Dest_Po);
                                        $("#workingForm select[name='Order_Num']").val(json['data'][0].Order_Num).change();
                                        $("#workingForm select[name='Item_Num']").val(json['data'][0].Item_Num).change();
                                        $("#workingForm input[name='Plan_Arrive']").val(json['data'][0].Plan_Arrive);
                                        $("#workingForm select[name='Work_Emp']").val(json['data'][0].Work_Emp).change();
                                        $("#workingForm input[name='Work_Price']").val(json['data'][0].Work_Price);
                                        $("#workingForm input[name='Work_Qty']").val(json['data'][0].Work_Qty);
                                        $("#workingForm textarea[name='Work_Memo']").val(json['data'][0].Work_Memo);
                                        $("#workingForm input[name='ProtoM_Num']").val(json['data'][0].ProtoM_Num);
                                        $("#workingForm input[name='Cust_Num']").val(json['data'][0].Cust_Num);
                                        $("#workingForm input[name='Addtime']").val(json['data'][0].Addtime);

                                        $("#workingForm input[name='Item_Work_Qty']").val(parseInt($("#workingForm input[name='Item_Qty']").val()) - parseInt(json['data'][0].Work_Qty));
                                        $("#workingForm input[name='Work_Qty']").attr('max', parseInt($("#workingForm input[name='Item_Qty']").val()) - parseInt($("#workingForm input[name='Item_Work_Qty']").val()));


                                        if (json['data'][0].Work_Type === '00A') {
                                            $("#workingForm select[name='Work_Type']").attr('disabled', 'disabled');
                                            $("#workingForm input[name='Work_Date']").attr('disabled', 'disabled');
                                            $("#workingForm input[name='Sour_Po']").attr('disabled', 'disabled');
                                            $("#workingForm input[name='Dest_Po']").attr('disabled', 'disabled');
                                            $("#workingForm select[name='Order_Num']").attr('disabled', 'disabled');
                                            $("#workingForm select[name='Item_Num']").attr('disabled', 'disabled');
                                            $("#workingForm select[name='Work_Emp']").attr('disabled', 'disabled');
                                            $("#workingForm textarea[name='Work_Memo']").attr('disabled', 'disabled');
                                            $("#workingForm input[name='ProtoM_Num']").attr('disabled', 'disabled');
                                            $("#workingForm input[name='Cust_Num']").attr('disabled', 'disabled');
                                        } else if (json['data'][0].Work_Type === '00B') {
                                            $("#workingForm select[name='Work_Type']").attr('disabled', 'disabled');
                                            $("#workingForm input[name='Work_Date']").attr('disabled', 'disabled');
                                            $("#workingForm select[name='Order_Num']").attr('disabled', 'disabled');
                                            $("#workingForm select[name='Item_Num']").attr('disabled', 'disabled');
                                            $("#workingForm input[name='Work_Qty']").attr('disabled', 'disabled');
                                            $("#workingForm input[name='Plan_Arrive']").attr('disabled', 'disabled');
                                            $("#workingForm select[name='Work_Emp']").attr('disabled', 'disabled');
                                            $("#workingForm input[name='Work_Price']").attr('disabled', 'disabled');
                                            $("#workingForm textarea[name='Work_Memo']").attr('disabled', 'disabled');
                                            $("#workingForm input[name='ProtoM_Num']").attr('disabled', 'disabled');
                                            $("#workingForm input[name='Cust_Num']").attr('disabled', 'disabled');
                                        } else {
                                            alert("ERROR!");
                                            history.go(-1);
                                        }
                                    }
                                } else {
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                                    alert(json.error);
                                    history.go(-1);

                                }



                            }
                        });


                    }


                    $.when($.ajax({
                            type: 'GET',
                            url: '/clothes/ajax/manage_ajax.php',
                            data: {
                                form: 'syscodeinfo',
                                CT_No: 'A12'

                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json['status'] === "success") {
                                    json['data'].forEach(obj => {
                                        $("#workingForm select[name='Work_Type']").append($("<option></option>").attr("value", obj.CI_No).text(obj.CI_Name));
                                    });
                                } else
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                            }
                        }), $.ajax({
                            type: 'GET',
                            url: '/clothes/ajax/manage_ajax.php',
                            data: {
                                form: 'order',
                                OrderStatus: '002'

                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json['status'] === "success") {
                                    var order = {};
                                    var orderItems = {};
                                    json['data'].forEach(obj => {
                                        $("#workingForm select[name='Order_Num']").append($("<option></option>").attr("value", obj.Order_Num).text(obj.Order_Num));
                                        order[obj.Order_Num] = obj;
                                        $.ajax({
                                            type: 'GET',
                                            url: '/clothes/ajax/manage_ajax.php',
                                            data: {
                                                form: 'orderitem',
                                                id: obj.Order_Num

                                            }, // serializes the form's elements.
                                            dataType: "json",
                                            success: function(json) {
                                                if (json['status'] === "success") {
                                                    json['data'].forEach(obj => {
                                                        if (typeof orderItems[obj.Order_Num] === 'undefined') {
                                                            orderItems[obj.Order_Num] = {};
                                                        }
                                                        orderItems[obj.Order_Num][obj.Item_Num] = obj;

                                                    });

                                                } else
                                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                                            }
                                        });
                                    });
                                    $("#workingForm select[name='Order_Num']").change(function() {
                                        if (typeof order[$(this).val()] !== 'undefined') {
                                            $("#workingForm input[name='Cust_Name']").val(order[$(this).val()].Cust_Name);
                                            $("#workingForm input[name='Plan_Arrive']").attr('max', order[$(this).val()].Plan_Date);
                                            $("#workingForm select[name='Item_Num']").empty().append($("<option hidden selected disabled></option>")).change();

                                            for (key in orderItems[$(this).val()]) {
                                                $("#workingForm select[name='Item_Num']").append($("<option></option>").attr("value", orderItems[$(this).val()][key].Item_Num).text(orderItems[$(this).val()][key].Item_Num));

                                            }
                                        }
                                    })

                                    $("#workingForm select[name='Item_Num']").change(function() {
                                        $("#workingForm input[name='Work_Qty']").val('');

                                        if (typeof orderItems[$("#workingForm select[name='Order_Num']").val()] !== 'undefined') {
                                            var item = orderItems[$("#workingForm select[name='Order_Num']").val()][$("#workingForm select[name='Item_Num']").val()];
                                            if (typeof item !== 'undefined') {
                                                $("#workingForm input[name='Item_Qty']").val(item.Item_Qty);
                                                $("#workingForm input[name='Item_Work_Qty']").val(item.Work_Qty);
                                            } else {
                                                $("#workingForm input[name='Item_Qty']").val('');
                                                $("#workingForm input[name='Item_Work_Qty']").val('');
                                            }
                                        } else {
                                            $("#workingForm input[name='Item_Qty']").val('');
                                            $("#workingForm input[name='Item_Work_Qty']").val('');
                                        }

                                        $("#workingForm input[name='Work_Qty']").attr('max', parseInt($("#workingForm input[name='Item_Qty']").val()) - parseInt($("#workingForm input[name='Item_Work_Qty']").val()));

                                    })

                                } else
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                            }
                        }),
                        $.ajax({
                            type: 'GET',
                            url: '/clothes/ajax/manage_ajax.php',
                            data: {
                                form: 'employee'

                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json['status'] === "success") {
                                    json['data'].forEach(obj => {
                                        $("#workingForm select[name='Work_Emp']").append($("<option></option>").attr("value", obj.Emp_Num).text(obj.Emp_Num + " " + obj.Emp_Name));
                                    });
                                } else
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                            }
                        })).done(function() {
                        var id = null;
                        url = new URL(window.location.href);
                        for (pair of url.searchParams.entries()) {
                            if (pair[0] === 'id') {
                                id = pair[1];
                                break;
                            }
                        }
                        if (id === null) {
                            $(".container").find("h1").eq(0).text("訂單派工單 - 新增");
                            return;
                        } else if (id !== "")
                            initialInfo(id);
                        else {
                            alert("此派工單不存在!");
                            history.go(-1);
                        }



                    });
                </script>

            </div>
        </div>
    </section>
</body>

</html>