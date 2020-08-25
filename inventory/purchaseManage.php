<?php
@require_once($_SERVER["DOCUMENT_ROOT"] . "/clothes/functions/functions.php");
$permission = checkPermission(null, 'B03');
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
            $("nav li").eq(2).addClass("active");
        });
    </script>
    <section>
        <div class="container" style="margin: 20px auto">
            <div class="shadow bg-white " style="padding:0.15rem 1rem!important">
                <a href="/clothes/" class="text-dark">首頁</a> /
                <a href="/clothes/inventory/" class="text-dark">用料庫存管理</a> /
                <a href="/clothes/inventory/purchaseInfo.php" class="text-info">用料進貨維護</a>
            </div>
        </div>
    </section>
    <section>
        <div class="container" style="margin: 10px auto">
            <div class="shadow p-3 mb-5 bg-white rounded" style="padding:2.5rem!important">
                <h1>用料進貨維護</h1>
                <hr>
                <div class="border row" style="margin: 10px auto;padding-top:10px;padding-bottom:10px" id="searchBox">
                    <div class="row col-sm" style="margin:10px auto">
                        <label for="" class="col-form-label" style="width: 100px;">用料名稱：</label>
                        <div class="col-sm" style="min-width: 150px;">
                            <input type="text" class="form-control" id="" placeholder="用料名稱">
                        </div>
                    </div>
                    <div class="row col-sm" style="margin:10px auto">
                        <label for="" class="col-form-label" style="width: 100px;">供應商：</label>
                        <div class="col-sm" style="min-width: 150px;">
                            <select class="form-control">
                                <option selected></option>
                            </select>

                        </div>
                    </div>
                    <div class="row col-sm" style="margin:10px auto">
                        <label for="" class="col-form-label" style="width: 100px;">進貨日期：</label>
                        <div class="col-sm row" style="min-width: 350px;">
                            <input type="date" class="form-control col-sm" id="date_start" placeholder="開始日期">
                            <div style="margin: auto;">&nbsp;~&nbsp;</div>
                            <input type="date" class="form-control col-sm" id="date_end" placeholder="結束日期">
                        </div>
                    </div>
                    <div class="row col-sm" style="margin:10px auto;justify-content:center;min-width: 200px;">
                        <button type="button" class="btn btn-success" style="white-space:nowrap;margin:auto 3px" onclick="search();">查詢</button>
                        <button type="button" class="btn btn-warning" style="white-space:nowrap;margin:auto 3px" onclick="resetSearch();">清除</button>
                        <button type="button" class="btn btn-primary" style="white-space:nowrap;margin:auto 3px" onclick="window.open('purchaseInfo.php','_self')">新增</button>
                    </div>
                </div>


                <table id="purchaseTable" class="table table-hover table-bordered" style="margin:5px auto">
                    <thead>
                        <tr>
                            <th>進貨日期</th>
                            <th>用料名稱</th>
                            <th>顏色</th>
                            <th>單價</th>
                            <th>單位</th>
                            <th>數量</th>
                            <th>總計</th>
                            <th>供應商名稱</th>
                            <th>修改/刪除</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>

                </table>
                <script>
                    $(function() {
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
                                        $('#searchBox select').eq(0).append($("<option></option>").attr("value", json['data'][i]['Supply_Num']).text(json['data'][i]['Supply_Name']));
                                    }
                                }

                            }
                        });

                    });
                    $(function() {
                        opt = {
                            "ajax": {
                                "url": "/clothes/ajax/manage_ajax.php",
                                "type": "GET",
                                "data": {
                                    form: "purchase"
                                }
                            },
                            "columns": [{
                                    "data": "Pur_Date"
                                },
                                {
                                    "data": "Mate_Name"
                                },
                                {
                                    "data": "Mate_Color_Name"
                                },
                                {
                                    "render": function(data, type, row, meta) {
                                        return "$" + row.Pur_Price;
                                    }
                                },
                                {
                                    "data": "Pur_Unit_Name"
                                }, {
                                    "data": "Pur_Qty"
                                },
                                {
                                    "render": function(data, type, row, meta) {
                                        return "$" + row.Pur_Amt;
                                    }
                                },
                                {
                                    "data": "Supply_Name"
                                },
                                {
                                    "render": function(data, type, row, meta) {
                                        data = "<button type=\"button\" class=\"btn btn-info \" onclick=\"window.open('purchaseInfo.php?id=" + row.Pur_Num + "','_self');\" style=\"margin:1px\">檢視</button>";
                                        data += "<button type=\"button\" class=\"btn btn-danger \" onclick=\"deleteData('purchase','" + row.Pur_Num + "')\" style=\"margin:1px\">刪除</button>";
                                        return data;
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
                        $('#purchaseTable').DataTable(opt);
                        $.fn.dataTable.ext.search.push(
                            function(settings, data, dataIndex) {
                                var supply = $('#searchBox select option:selected').eq(0).text();
                                var materialName = $('#searchBox input').eq(0).val();
                                var start = $('#searchBox input').eq(1).val();
                                var end = $('#searchBox input').eq(2).val();
                                var date = new Date(data[0]);

                                if ((supply == '' || data[7] == supply) &&
                                    (materialName == '' || data[1] == materialName) &&
                                    (isNaN(date.getTime()) || (start == '' && end == '') || (start != '' && end != '' && date >= new Date(start) && date <= new Date(end)) ||
                                        (start != '' && end == '' && date >= new Date(start)) || (start == '' && end != '' && date <= new Date(end)))) {
                                    return true;
                                }
                                return false;
                            }
                        );
                        $("#purchaseTable").wrap("<div style='overflow-x:auto'></div>");
                    });


                    function search() {
                        /*$.fn.dataTable.ext.search.pop();
                        $.fn.dataTable.ext.search.push(
                            function(settings, data, dataIndex) {
                                var supply = $('#searchBox select option:selected').eq(0).text();
                                var materialName = $('#searchBox input').eq(0).val();
                                var start = $('#searchBox input').eq(1).val();
                                var end = $('#searchBox input').eq(2).val();
                                var date = new Date(data[0]);

                                if ((supply == '' || data[7] == supply) &&
                                    (materialName == '' || data[1] == materialName) &&
                                    (isNaN(date.getTime()) || (start == '' && end == '') || (start != '' && end != '' && date >= new Date(start) && date <= new Date(end)) ||
                                        (start != '' && end == '' && date >= new Date(start)) || (start == '' && end != '' && date <= new Date(end)))) {
                                    return true;
                                }
                                return false;
                            }
                        );*/

                        $('#purchaseTable').DataTable().draw();

                    }



                    function resetSearch() {
                        $('#searchBox select').eq(0).val('');
                        $('#searchBox select').eq(1).val('');
                        $('#searchBox input').eq(0).val('');
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

                                    if (json.status === "error")
                                        toastr.error(json.error, "ERROR"); // show response from the php script.
                                    else if (json.status === "success") {
                                        toastr.success("刪除成功", "Success");
                                    } else {
                                        toastr.error("error", "ERROR"); // show response from the php script.
                                    }
                                    $('#purchaseTable').DataTable().ajax.reload();



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