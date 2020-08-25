<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/clothes/functions/functions.php");
$permission  = checkPermission(null, 'A04');
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
                <a href="/clothes/customer/workingManage.php" class="text-info">訂單派工維護</a>
            </div>
        </div>
    </section>
    <section>
        <div class="container" style="margin: 10px auto">
            <div class="shadow p-3 mb-5 bg-white rounded" style="padding:2.5rem!important">
                <h1>訂單派工維護</h1>
                <hr />
                <div class="border " style="margin: 10px auto;padding:10px;overflow-x:hidden" id="searchBox">
                    <div class="row" style="margin: auto;width: 100%;">
                        <div class="row col-sm" style="margin:10px auto">
                            <label for="" class="col-form-label" style="width: 100px;">派工類型：</label>
                            <div class="col-sm" style="min-width: 200px;">
                                <select type="text" class="form-control" style="width: 200px;">
                                    <option selected></option>
                                </select>
                            </div>
                        </div>
                        <div class="row col-sm" style="margin:10px auto">
                            <label for="" class="col-form-label" style="width: 100px;">加工人員：</label>
                            <div class="col-sm" style="min-width: 200px;">
                                <input type="text" class="form-control" style="width: 200px;">
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin: auto;width: 100%;">
                        <div class="row col-sm" style="margin:10px auto">
                            <label for="" class="col-form-label" style="width: 100px;">派工日期：</label>
                            <div class="row col-sm" style="min-width: 200px;">
                                <input type="date" class="form-control col-sm" style="min-width: 165px;">
                                <div style="margin: auto;width:30px;text-align:center">~</div>
                                <input type="date" class="form-control col-sm" style="min-width: 165px;">
                            </div>
                        </div>
                        <div class="row col-sm" style="margin:10px auto">
                            <label for="" class="col-form-label" style="width: 100px;">完工日期：</label>
                            <div class="row col-sm" style="min-width: 200px;">
                                <input type="date" class="form-control col-sm" style="min-width: 165px;">
                                <div style="margin: auto;width:30px;text-align:center">~</div>
                                <input type="date" class="form-control col-sm" style="min-width: 165px;">
                            </div>
                        </div>
                    </div>

                    <div class="row " style="margin:10px auto;justify-content:center;min-width: 200px;">
                        <button type="button" class="btn btn-success" style="white-space:nowrap;margin:auto 3px" onclick="search();">查詢</button>
                        <button type="button" class="btn btn-warning" style="white-space:nowrap;margin:auto 3px" onclick="resetSearch();">清除</button>
                        <button type="button" class="btn btn-primary" style="white-space:nowrap;margin:auto 3px" onclick="window.open('workingInfo.php','_self')">新增</button>
                    </div>
                </div>

                <table id="workingTable" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>派工單號</th>
                            <th>派工日期</th>
                            <th>完工日期</th>
                            <th>來源進貨單</th>
                            <th>目的進料單</th>
                            <th>訂單編號</th>
                            <th>品項</th>
                            <th>加工人員</th>
                            <th>件數</th>
                            <th>完工</th>
                            <th>派工類型</th>
                            <th>最後修改日期</th>
                            <th>修改/刪除</th>
                        </tr>
                    </thead>
                </table>

            </div>
        </div>
    </section>


    <script>
        $.ajax({
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
                        $("#searchBox select").eq(0).append($("<option></option>").attr("value", obj.CI_No).text(obj.CI_Name));
                    });
                } else
                    toastr.error(json.error, "ERROR"); // show response from the php script.
            }
        })
        $(function() {
            opt_working = {
                "ajax": {
                    "url": "/clothes/ajax/manage_ajax.php",
                    "type": "GET",
                    "data": {
                        form: "working"
                    }
                },
                "columns": [{
                        "data": "Work_Num"
                    },
                    {
                        "data": "Work_Date"
                    },
                    {

                        "render": function(data, type, row, meta) {
                            if (row.Okay_Date === "0000-00-00")
                                return "";

                            return row.Okay_Date;
                        }
                    },
                    {
                        "data": "Sour_Po"
                    },
                    {
                        "data": "Dest_Po"
                    },
                    {
                        "data": "Order_Num"
                    },
                    {
                        "data": "Item_Num"
                    },
                    {
                        "data": "Emp_Name"
                    },
                    {
                        "data": "Work_Qty"
                    },
                    {
                        "render": function(data, type, row, meta) {
                            if (row.Work_Status === 1)
                                return "Y";

                            return "N";
                        }
                    },
                    {
                        "data": "Work_Type",
                        "visible": false,
                        "searchable": true

                    },
                    {
                        "data": "Chgtime",
                        "visible": false,
                        "searchable": true

                    }, {
                        "render": function(data, type, row, meta) {
                            if (row.Work_Status === 0) {
                                data = "<button type=\"button\" class=\"btn btn-warning \" onclick=\"window.open('workingInfo.php?id=" + row.Work_Num + "','_self');\" style=\"margin:1px\">修改</button>";
                                data += "<button type=\"button\" class=\"btn btn-danger \" onclick=\"deleteData('working','" + row.Work_Num + "')\" style=\"margin:1px\">刪除</button>";
                                data += "<button type=\"button\" class=\"btn btn-success \" onclick=\"workFinish('" + row.Work_Num + "')\" style=\"margin:1px\">完工</button>";
                            } else
                                data = "<button type=\"button\" class=\"btn btn-info \" onclick=\"window.open('workingInfo.php?id=" + row.Work_Num + "','_self');\" style=\"margin:1px\">檢視</button>";


                            return data;
                            return "";
                        }
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
                            else echo "null"; ?>
                }],
                "destroy": true,
                "bAutoWidth": false //solve width:0px
            }
            $('#workingTable').DataTable(opt_working).draw();
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var Work_Type = $('#searchBox select').eq(0).val();
                    var Emp_Name = $('#searchBox input').eq(0).val();
                    var Work_Date_Start = $('#searchBox input').eq(1).val();
                    var Work_Date_End = $('#searchBox input').eq(2).val();
                    var Work_Date = new Date(data[1]);
                    var Okay_Date_Start = $('#searchBox input').eq(3).val();
                    var Okay_Date_End = $('#searchBox input').eq(4).val();
                    var Okay_Date = new Date(data[2]);

                    //console.log(Work_Type, Emp_Name, Work_Date_Start, Work_Date_End, Work_Date, Okay_Date_Start, Okay_Date_End, Okay_Date);


                    if ((Work_Type == '' || data[10].includes(Work_Type)) &&
                        (Emp_Name == '' || data[7].includes(Emp_Name)) &&
                        (isNaN(Work_Date.getTime()) || (Work_Date_Start == '' && Work_Date_End == '') || (Work_Date_Start != '' && Work_Date_End != '' && Work_Date >= new Date(Work_Date_Start) && Work_Date <= new Date(Work_Date_End)) ||
                            (Work_Date_Start != '' && Work_Date_End == '' && Work_Date >= new Date(Work_Date_Start)) || (Work_Date_Start == '' && Work_Date_End != '' && Work_Date <= new Date(Work_Date_End))) &&
                        (isNaN(Okay_Date.getTime()) || (Okay_Date_Start == '' && Okay_Date_End == '') || (Okay_Date_Start != '' && Okay_Date_End != '' && Okay_Date >= new Date(Okay_Date_Start) && Okay_Date <= new Date(Okay_Date_End)) ||
                            (Okay_Date_Start != '' && Okay_Date_End == '' && Okay_Date >= new Date(Okay_Date_Start)) || (Okay_Date_Start == '' && Okay_Date_End != '' && Okay_Date <= new Date(Okay_Date_End)))) {
                        return true;
                    }
                    return false;

                }
            );

            $("#workingTable").wrap("<div style='overflow-x:auto'></div>");
        });

        function search() {
            $('#workingTable').DataTable().draw();
        }



        function resetSearch() {
            $('#searchBox input').eq(0).val('');
            $('#searchBox input').eq(1).val('');
            $('#searchBox input').eq(2).val('');
            $('#searchBox input').eq(3).val('');
            $('#searchBox input').eq(4).val('');
            $('#searchBox select').eq(0).val('');
            search();
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
                        if (json['status'] === "success") {
                            toastr.success("刪除成功", "Success");
                        } else
                            toastr.error(json.error, "ERROR");
                        $('#workingTable').DataTable().ajax.reload();

                    }
                });
            }

        }

        function workFinish(id) {
            if (confirm('確定完工？')) {
                $.ajax({
                    type: "PUT",
                    url: "/clothes/ajax/manage_ajax.php",
                    data: {
                        form: "working",
                        Work_Num: id,
                        Work_Status: 1
                    },
                    dataType: "json",
                    success: function(json) {
                        if (json['status'] === "success") {
                            toastr.success(id + " 完工", "Success");
                        } else
                            toastr.error(json.error, "ERROR");
                        $('#workingTable').DataTable().ajax.reload();

                    }
                });
            }

        }
    </script>
</body>

</html>