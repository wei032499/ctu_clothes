<?php
@require_once($_SERVER["DOCUMENT_ROOT"] . "/clothes/functions/functions.php");
if (isset($_GET['id'])) // 修改
{
    if (checkPermission(null, 'A02') < 1) {
        echo "<script>alert('無此權限');history.back();</script>";
        exit();
    }
} else // 新增 
{
    if (checkPermission(null, 'A02') < 2) {
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
                <a href="/clothes/customer/customerManage.php" class="text-dark">顧客基本資料維護</a> /
                <a href="/clothes/customer/customerInfo.php" class="text-info">顧客基本資料表</a>
            </div>
        </div>
    </section>
    <section>
        <div class="container" style="margin: 10px auto">
            <div class="shadow p-3 mb-5 bg-white rounded" style="padding:2.5rem!important">
                <h1>顧客基本資料表</h1>
                <hr>
                <form id="customerForm" action="/clothes/ajax/manage_ajax.php" method="POST" style="margin:auto;width:90%">
                    <input type="text" name="form" value="customer" style="display:none" />
                    <div style="width:max-content;margin:auto">
                        <div class="form-group row" style="justify-content: center;">
                            <label for="Cust_Num" style="margin:auto 5px;width:100px;" class=" col-form-label">顧客編號</label>
                            <input type="text" class="form-control" style="max-width: 200px;margin-left:5px" name="Cust_Num" readonly>
                        </div>
                        <div class="form-group row" style="justify-content: center;">
                            <label for="Cust_Name" style="margin:auto 5px;width:100px;" class=" col-form-label">姓名</label>
                            <input type="text" class="form-control" style="max-width: 200px;margin-left:5px" name="Cust_Name" required>
                        </div>
                        <div class="form-group row" style="justify-content: center;">
                            <label for="Cust_Birth" style="margin:auto 5px;width:100px;" class=" col-form-label">生日</label>
                            <input type="date" class="form-control" style="max-width: 200px;margin-left:5px" name="Cust_Birth" required>
                        </div>
                        <div class="form-group row" style="justify-content: center;">
                            <label for="Cust_Postal" style="margin:auto 5px;width:100px;" class=" col-form-label">郵遞區號</label>
                            <input type="text" class="form-control" style="max-width: 200px;margin-left:5px" name="Cust_Postal" required>
                        </div>
                        <div class="form-group row" style="justify-content: center;">
                            <label for="Cust_Addr" style="margin:auto 5px;width:100px;" class=" col-form-label">地址</label>
                            <textarea class="form-control" style="max-width: 200px;margin-left:5px" name="Cust_Addr" required></textarea>
                        </div>
                        <div class="form-group row" style="justify-content: center;">
                            <label for="tel" style="margin:auto 5px;width:100px;" class=" col-form-label">電話</label>
                            <input type="tel" pattern="[\d|-]+" class="form-control" style="max-width: 200px;margin-left:5px" name="Cust_Tel">
                        </div>
                        <div class="form-group row" style="justify-content: center;">
                            <label for="phone" style="margin:auto 5px;width:100px;" class=" col-form-label">手機</label>
                            <input type="tel" pattern="[\d|-]+" class="form-control" style="max-width: 200px;margin-left:5px" name="Cust_Mobile" required>
                        </div>
                        <div class="form-group row" style="justify-content: center;">
                            <label for="Cust_Email" style="margin:auto 5px;width:100px;" class=" col-form-label">Email</label>
                            <input type="email" class="form-control" style="max-width: 200px;margin-left:5px" name="Cust_Email" required>
                        </div>
                        <div class="form-group row" style="justify-content: center;">
                            <label for="Cust_Memo" style="margin:auto 5px;width:100px;" class=" col-form-label">特殊備註</label>
                            <textarea class="form-control" style="max-width: 200px;margin-left:5px" name="Cust_Memo"></textarea>
                        </div>
                        <div class="form-group row" style="justify-content: center;">
                            <label for="Bran_Name" style="margin:auto 5px;width:100px;" class=" col-form-label">建檔分店</label>
                            <input type="text" class="form-control" style="max-width: 200px;margin-left:5px" name="Bran_Name" disabled>
                        </div>
                        <div class="form-group row" style="justify-content: center;">
                            <label for="Addtime" style="margin:auto 5px;width:100px;" class=" col-form-label">建檔時間</label>
                            <input type="text" class="form-control" style="max-width: 200px;margin-left:5px" name="Addtime" disabled>
                        </div>
                    </div>
                    <input type="text" name="Bran_num" value="<?php echo @$_GET['bran']; ?>" style="display:none" />
                    <div style="width:max-content;margin:auto">

                        <?php
                        if (isset($_GET['id'])) {
                            echo "<button style=\"margin:auto 5px\" type=\"submit\" class=\"btn btn-success\">更新</button>";
                            //echo "<button style=\"margin:auto 5px\" onclick=\"window.open('measurementInfo.php?id=" . $_GET['id'] . "','_self');\" class=\"btn btn-info\">新增尺寸表</button>";
                        } else
                            echo "<button style=\"margin:auto 5px\" type=\"submit\" class=\"btn btn-success\">新增</button>";

                        ?>

                        <button style="margin:auto 5px" type="button" class="btn btn-danger" onclick="history.back();">取消</button>
                    </div>
                    <hr />
                    <div id="record" style="display: none;">
                        <div class="form-group row">
                            <h5>量身紀錄</h5>
                            <button type="button" class="btn btn-sm btn-primary" style="margin:auto 10px" onclick="window.open('measurementInfo.php?id=<?php echo $_GET['id']; ?>','_self');">新增量身</button>

                        </div>

                        <table id="measurementTable" class="table table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>量身日期</th>
                                    <th>量身人員</th>
                                    <th>訂單筆數</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                </form>

                <script>
                    $(function() {
                        var url = new URL(window.location.href);
                        for (pair of url.searchParams.entries()) {
                            if (pair[0] === 'id') {
                                initialInfo(pair[1]);
                                $(".container").find("h1").eq(0).append(" - 修改");
                                return;
                            }
                        }
                        $(".container").find("h1").eq(0).append(" - 新增");
                    });
                    $("#customerForm").submit(function(e) {

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

                    function initialInfo(id) {
                        $('#customerForm').attr('method', "PUT");
                        $("#record").css('display', '');
                        $.ajax({
                            type: "GET",
                            url: "/clothes/ajax/manage_ajax.php",
                            data: {
                                form: "customer",
                                id: id
                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json['status'] === 'success') {
                                    if (json['data'].length === 0) {
                                        alert("此顧客不存在!");
                                        history.go(-1);
                                    } else {
                                        $("#customerForm input[name='Cust_Num']").val(json['data'][0].Cust_Num);
                                        $("#customerForm input[name='Cust_Name']").val(json['data'][0].Cust_Name);
                                        $("#customerForm input[name='Cust_Birth']").val(json['data'][0].Cust_Birth);
                                        $("#customerForm input[name='Cust_Postal']").val(json['data'][0].Cust_Postal);
                                        $("#customerForm textarea[name='Cust_Addr']").val(json['data'][0].Cust_Addr);
                                        $("#customerForm input[name='Cust_Tel']").val(json['data'][0].Cust_Tel);
                                        $("#customerForm input[name='Cust_Mobile']").val(json['data'][0].Cust_Mobile);
                                        $("#customerForm input[name='Cust_Email']").val(json['data'][0].Cust_Email);
                                        $("#customerForm textarea[name='Cust_Memo']").val(json['data'][0].Cust_Memo);
                                        $("#customerForm input[name='Bran_Name']").val(json['data'][0].Bran_Name);
                                        $("#customerForm input[name='Addtime']").val(json['data'][0].Addtime);
                                    }
                                } else {
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                                    alert(json.error);
                                    history.go(-1);

                                }



                            }
                        });




                        opt_measurement = {
                            "ajax": {
                                "url": "/clothes/ajax/manage_ajax.php",
                                "type": "GET",
                                "data": {
                                    form: "measurement",
                                    id: id
                                }
                            },
                            "columns": [{
                                    "data": "BodyM_Date"
                                },

                                {
                                    "data": "Emp_Name"
                                },

                                {
                                    "data": "Order_Count"
                                }

                            ],
                            "searching": false,
                            "lengthMenu": [
                                [5, 10, 15, 20, -1],
                                [5, 10, 15, 20, "All"]
                            ],
                            "order": [
                                [0, "desc"]
                            ],
                            "language": {
                                "decimal": "",
                                "emptyTable": "No data available in table",
                                "info": "顯示第 _START_ 筆到第 _END_ 筆，所有資料共_TOTAL_筆",
                                "infoEmpty": "", //Showing 0 to 0 of 0 entries
                                "infoFiltered": "", //(filtered from _MAX_ total entries)
                                "infoPostFix": "",
                                "thousands": ",",
                                "lengthMenu": "顯示 _MENU_ 筆資料",
                                "loadingRecords": "Loading...",
                                "processing": "Processing...",
                                "search": "搜尋:",
                                "zeroRecords": "查無資料", //No matching records found
                                "paginate": {
                                    "first": "First",
                                    "last": "Last",
                                    "next": ">",
                                    "previous": "<"
                                },
                                "aria": {
                                    "sortAscending": ": activate to sort column ascending",
                                    "sortDescending": ": activate to sort column descending"
                                },



                            },

                            "destroy": true,
                            "bAutoWidth": false //solve width:0px
                        }
                        $('#measurementTable').DataTable(opt_measurement).draw();

                        $("#measurementTable").wrap("<div style='overflow-x:auto'></div>");

                    }
                </script>

            </div>
        </div>
    </section>
</body>

</html>