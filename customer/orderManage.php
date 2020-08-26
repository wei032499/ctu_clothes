<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/clothes/functions/functions.php");
$permission  = checkPermission(null, 'A01');
if ($permission < 1) {
    echo "<script>alert('無此權限');history.back();</script>";
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
            $("nav li").eq(1).addClass("active");
        });
    </script>
    <section>
        <div class="container" style="margin: 20px auto">
            <div class="shadow bg-white " style="padding:0.15rem 1rem!important">
                <a href="/clothes/" class="text-dark">首頁</a> /
                <a href="/clothes/customer/" class="text-dark">顧客訂單管理</a> /
                <a href="/clothes/customer/orderManage.php" class="text-info">顧客訂單維護</a>
            </div>
        </div>
    </section>
    <section>
        <div class="container" style="margin: 10px auto">
            <div class="shadow p-3 mb-5 bg-white rounded" style="padding:2.5rem!important">
                <h1>顧客訂單維護</h1>
                <hr />
                <div class="border row" style="margin: 10px auto;padding:10px;overflow-x:hidden" id="searchBox">
                    <div class="row" style="margin: auto;width: 100%;">
                        <div class="row col-sm">
                            <div class="row col-sm" style="margin:10px auto">
                                <label for="" class="col-form-label" style="width: 100px;">訂單日期：</label>
                                <div class="col-sm row" style="min-width: 330px;">
                                    <input type="date" class="form-control col-sm" id="">
                                    <div style="margin: auto;"> ~ </div>
                                    <input type="date" class="form-control col-sm" id="">
                                </div>
                            </div>
                            <div class="row col-sm" style="margin:10px auto">
                                <label for="" class="col-form-label" style="width: 100px;">訂單編號：</label>
                                <div class="col-sm" style="min-width: 250px;">
                                    <input type="text" class="form-control" id="">
                                </div>
                            </div>
                        </div>
                        <div class="row col-sm">
                            <div class="row col-sm" style="margin:10px auto">
                                <label for="" class="col-form-label" style="width: 100px;">顧客姓名：</label>
                                <div class="col-sm" style="min-width: 250px;">
                                    <input type="text" class="form-control" id="">
                                </div>
                            </div>
                            <div class="row col-sm" style="margin:10px auto">
                                <label for="" class="col-form-label" style="width: 100px;">顧客電話：</label>
                                <div class="col-sm" style="min-width: 250px;">
                                    <input type="text" class="form-control" id="">
                                </div>
                            </div>
                        </div>
                        <div class="row col-sm" style="margin:auto; ">
                            <div class="col-sm" style="margin: auto;word-break: keep-all;text-align:center">
                                <input type="checkbox" class="form-check-input" id="checkCross">
                                <label class="form-check-label" for="checkCross">含註記刪除訂單</label>
                            </div>
                            <div class="row col-sm" style="margin:10px auto;justify-content:center;min-width: 250px;">
                                <button type="button" class="btn btn-success" style="white-space:nowrap;margin:auto 3px" onclick="search();">查詢</button>
                                <button type="button" class="btn btn-warning" style="white-space:nowrap;margin:auto 3px" onclick="resetSearch();">清除</button>
                                <button type="button" class="btn btn-primary" style="white-space:nowrap;margin:auto 3px" onclick="window.open('orderInfo.php','_self')">新增</button>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Modal -->
                <div class="modal fade" id="DELETEModal" tabindex="-1" role="dialog" aria-labelledby="DELETEModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="DELETEModalLabel">取消訂單</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <form id="orderDeleteForm" action="/clothes/ajax/manage_ajax.php" method="post">
                                <div class="modal-body">
                                    <input type="text" name="form" value="order" style="display:none" required />
                                    <div class="form-group">
                                        <label for="Order_Num">訂單編號</label>
                                        <input type="text" class="form-control" id="Order_Num" name="Order_Num" readonly required>
                                    </div>
                                    <div class="form-group">
                                        <label for="OrderReason">取消原因</label>
                                        <textarea class="form-control" id="OrderReason" name="OrderReason" required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger">確定</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <table id="orderTable" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>訂單編號</th>
                            <th>顧客姓名</th>
                            <th>訂單日期</th>
                            <th>件數</th>
                            <th>訂單總價</th>
                            <th>已付金額</th>
                            <th>訂單狀態</th>
                            <th>修改/刪除</th>
                            <th>修改時間</th>
                            <th>取消訂單</th>
                            <th>電話</th>
                            <th>手機</th>
                        </tr>
                    </thead>
                </table>

            </div>
        </div>
    </section>


    <script>
        $(function() {
            opt_order = {
                "ajax": {
                    "url": "/clothes/ajax/manage_ajax.php",
                    "type": "GET",
                    "data": {
                        form: "order"
                    }
                },
                "columns": [{
                        "data": "Order_Num"
                    },
                    {
                        "render": function(data, type, row, meta) {
                            if (row.Cust_Name === null)
                                return row.Cust_Num;
                            return row.Cust_Name;
                        }
                    },
                    {
                        "data": "Order_Date"
                    },
                    {
                        "data": "Order_Qty"
                    },
                    {
                        "render": function(data, type, row, meta) {
                            return "$" + row.Order_Amt;
                        }
                    },
                    {
                        "render": function(data, type, row, meta) {
                            return "$" + row.Order_Deposit;
                        }
                    },
                    {
                        "data": "OrderStatus_Name"
                    },
                    {
                        "render": function(data, type, row, meta) {
                            data = "<button type=\"button\" class=\"btn btn-warning \" onclick=\"window.open('orderInfo.php?id=" + row.Order_Num + "','_self');\" style=\"margin:1px\">修改</button>";

                            data += "<button type=\"button\" class=\"btn btn-danger \" onclick=\"deleteAlert('" + row.Order_Num + "','" + row.OrderReason + "')\" style=\"margin:1px\">刪除</button>";
                            return data;
                        }
                    },
                    {
                        "data": "Chgtime",
                        "visible": false,
                        "searchable": true

                    },
                    {
                        "data": "OrderCancel",
                        "visible": false,
                        "searchable": true

                    }, {
                        "data": "Cust_Tel",
                        "visible": false,
                        "searchable": true

                    }, {
                        "data": "Cust_Mobile",
                        "visible": false,
                        "searchable": true

                    }
                ],
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
                dom: 'lBrtip',
                buttons: [{
                    extend: <?php if ($permission >= 5) echo "'excelHtml5'";
                            else echo "null"; ?>,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 8, 9, 10, 11]
                    }
                }],
                "destroy": true,
                "bAutoWidth": false //solve width:0px
            }
            $('#orderTable').DataTable(opt_order).draw();
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var start = $('#searchBox input').eq(0).val();
                    var end = $('#searchBox input').eq(1).val();
                    var Order_Num = $('#searchBox input').eq(2).val();
                    var Cust_Name = $('#searchBox input').eq(3).val();
                    var Cust_phone = $('#searchBox input').eq(4).val().replace('-', '');
                    var checkbox = $('#searchBox input').eq(5).prop('checked');
                    var date = new Date(data[2]);

                    if ((checkbox || data[9] === '0') &&
                        (Order_Num == '' || data[0].includes(Order_Num)) &&
                        (Cust_Name == '' || data[1].includes(Cust_Name)) &&
                        (Cust_phone == '' || data[10].replace('-', '').includes(Cust_phone) || data[11].replace('-', '').includes(Cust_phone)) &&
                        (isNaN(date.getTime()) || (start == '' && end == '') || (start != '' && end != '' && date >= new Date(start) && date <= new Date(end)) ||
                            (start != '' && end == '' && date >= new Date(start)) || (start == '' && end != '' && date <= new Date(end)))) {
                        return true;
                    }
                    return false;
                }
            );
            $("#orderTable").wrap("<div style='overflow-x:auto'></div>");
        });

        function search() {

            $('#orderTable').DataTable().draw();

        }



        function resetSearch() {
            $('#searchBox input').eq(0).val('');
            $('#searchBox input').eq(1).val('');
            $('#searchBox input').eq(2).val('');
            $('#searchBox input').eq(3).val('');
            $('#searchBox input').eq(4).val('');
            search();
        }

        function deleteAlert(Order_Num, reason) {
            $.ajax({
                type: "DELETE",
                url: "/clothes/ajax/manage_ajax.php",
                data: {
                    form: 'order',
                    check: '1',
                    Order_Num: Order_Num
                },
                dataType: "json",
                success: function(json) {
                    if (json['status'] === "success") {
                        if (reason === "")
                            $("#orderDeleteForm button[type='submit']").css('display', '');
                        else
                            $("#orderDeleteForm button[type='submit']").css('display', 'none');
                        $("#orderDeleteForm input[name='Order_Num']").val(Order_Num);
                        $("#orderDeleteForm textarea[name='OrderReason']").val(reason);
                        $('#DELETEModal').modal('show');
                    } else
                        toastr.error(json.error, "ERROR");
                }
            });


        }

        $("#orderDeleteForm").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.

            $.ajax({
                type: "DELETE",
                url: "/clothes/ajax/manage_ajax.php",
                data: $("#orderDeleteForm").serialize(), // serializes the form's elements.
                dataType: "json",
                success: function(json) {
                    if (json['status'] === "success") {
                        $('#orderTable').DataTable().ajax.reload();
                        $('#DELETEModal').modal('hide');
                        $("#orderDeleteForm").trigger('reset');
                        toastr.success("刪除成功", "Success");
                    } else
                        toastr.error(json.error, "ERROR");
                }
            });

        });
    </script>
</body>

</html>