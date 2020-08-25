<?php
@require_once($_SERVER["DOCUMENT_ROOT"] . "/clothes/functions/functions.php");
$permission = checkPermission(null, 'B01');
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
                <a href="/clothes/inventory/supplyManage.php" class="text-info">供應商資料維護</a>
            </div>
        </div>
    </section>
    <section>
        <div class="container" style="margin: 10px auto">
            <div class="shadow p-3 mb-5 bg-white rounded" style="padding:2.5rem!important">
                <h1>供應商資料維護</h1>
                <hr>
                <div class="border row" style="margin: 10px auto;padding-top:10px;padding-bottom:10px" id="searchBox">
                    <div class="row col-sm" style="margin:10px auto">
                        <label for="operatorId" class="col-form-label" style="width: 100px;">供應商類別：</label>
                        <div class="col-sm" style="min-width: 200px;">
                            <select class="form-control">
                                <option selected></option>
                            </select>
                        </div>
                    </div>
                    <div class="row col-sm" style="margin:10px auto">
                        <label for="operator" class="col-form-label" style="width: 100px;">供應商名稱：</label>
                        <div class="col-sm" style="min-width: 200px;">
                            <input type="text" class="form-control" id="operator" placeholder="供應商名稱">
                        </div>
                    </div>
                    <div class="row col-sm" style="margin:10px auto">
                        <label for="operator" class="col-form-label" style="width: 100px;">負責人員：</label>
                        <div class="col-sm" style="min-width: 200px;">
                            <input type="text" class="form-control" id="operator" placeholder="供應商名稱">
                        </div>
                    </div>
                    <div class="row col-sm" style="margin:10px auto;justify-content:center;min-width: 200px;">
                        <button type="button" class="btn btn-success" style="white-space:nowrap;margin:auto 3px" onclick="search();">查詢</button>
                        <button type="button" class="btn btn-warning" style="white-space:nowrap;margin:auto 3px" onclick="resetSearch();">清除</button>
                        <button type="button" class="btn btn-primary" style="white-space:nowrap;margin:auto 3px" onclick="window.open('supplyInfo.php','_self')">新增</button>
                    </div>
                </div>


                <table id="supplyTable" class="table table-hover table-bordered" style="margin:5px auto">
                    <thead>
                        <tr>
                            <th>供應商類別</th>
                            <th>供應商編號</th>
                            <th>供應商名稱</th>
                            <th>住址</th>
                            <th>電話</th>
                            <th>負責人員</th>
                            <th>手機</th>
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
                                form: "syscodeinfo",
                                CT_No: 'B09'
                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json.hasOwnProperty('error'))
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                                else {
                                    for (i = 0; i < json['data'].length; i++) {
                                        $('#searchBox select').eq(0).append($("<option></option>").attr("value", json['data'][i]['CI_No']).text(json['data'][i]['CI_Name']));
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
                                    form: "supply"
                                }
                            },
                            "columns": [{
                                    "data": "Cate_Name"
                                },
                                {
                                    "data": "Supply_Num"
                                },
                                {
                                    "data": "Supply_Name"
                                },
                                {
                                    "data": "Supply_Adrs"
                                },
                                {
                                    "data": "Supply_Tel"
                                },
                                {
                                    "data": "Supply_Respon"
                                },
                                {
                                    "data": "Supply_Mobi"
                                },
                                {
                                    "render": function(data, type, row, meta) {
                                        data = "<button type=\"button\" class=\"btn btn-warning \" onclick=\"window.location.replace('supplyInfo.php?id=" + row.Supply_Num + "','_self');\" style=\"margin:1px\">修改</button>";
                                        data += "<button type=\"button\" class=\"btn btn-danger \" onclick=\"deleteData('supply','" + row.Supply_Num + "')\" style=\"margin:1px\">刪除</button>";
                                        return data;
                                    }
                                }

                            ],
                            "lengthMenu": [
                                [5, 10, 15, 20, -1],
                                [5, 10, 15, 20, "All"]
                            ],
                            "order": [
                                [1, "desc"]
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
                        $('#supplyTable').DataTable(opt);
                        $("#supplyTable").wrap("<div style='overflow-x:auto'></div>");
                    });

                    function search() {
                        $('#supplyTable').DataTable().columns(0).search($('#searchBox select option:selected').text());
                        $('#supplyTable').DataTable().columns(2).search($('#searchBox input').eq(0).val());
                        $('#supplyTable').DataTable().columns(5).search($('#searchBox input').eq(1).val());
                        $('#supplyTable').DataTable().draw();

                    }



                    function resetSearch() {
                        $('#searchBox select').eq(0).val('');
                        $('#searchBox input').eq(0).val('');
                        $('#searchBox input').eq(1).val('');
                        search();
                    }

                    function deleteData(form, id) {
                        if (confirm('刪除資料？')) {
                            $.ajax({
                                type: "DELETE",
                                url: "/clothes/ajax/manage_ajax.php",
                                data: {
                                    form: form,
                                    Supply_Num: id
                                },
                                dataType: "json",
                                success: function(json) {

                                    if (json.hasOwnProperty('error'))
                                        toastr.error(json.error, "ERROR"); // show response from the php script.
                                    else {
                                        toastr.success("刪除成功", "Success");
                                    }
                                    $('#supplyTable').DataTable().ajax.reload();

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