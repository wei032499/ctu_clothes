<?php
@require_once($_SERVER["DOCUMENT_ROOT"] . "/clothes/functions/functions.php");
if (checkPermission(null, 'Z03') < 1) {
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
            $("nav li").eq(6).addClass("active");
        });
    </script>
    <section>
        <div class="container" style="margin: 20px auto">
            <div class="shadow bg-white " style="padding:0.15rem 1rem!important">
                <a href="/clothes/" class="text-dark">首頁</a> /
                <a href="/clothes/system/" class="text-dark">系統管理</a> /
                <a href="/clothes/system/SysOpLog.php" class="text-info">系統作業日誌</a>
            </div>
        </div>
    </section>
    <section>
        <div class="container" style="margin: 10px auto">
            <div class="shadow p-3 mb-5 bg-white rounded" style="padding:2.5rem!important">
                <h1>系統作業日誌</h1>
                <hr>
                <div class="border row" style="margin: 10px auto;padding:10px" id="searchBox">
                    <div class="">
                        <div class="row">
                            <div class="form-group row col-sm" style="justify-content: center;">
                                <label for="date" class="col-sm-2 col-form-label" style="white-space: nowrap;">操作時間：</label>
                                <div class="col-sm-9 ">
                                    <div class="row" style="justify-content: center;">
                                        <input type="text" class="form-control col-5" id="start" placeholder="yyyy-mm-dd hh:mm:ss">
                                        <div class="col-1">~</div>
                                        <input type="text" class="form-control col-5" id="end" placeholder="yyyy-mm-dd hh:mm:ss">
                                    </div>
                                </div>

                            </div>
                            <div class="form-group row col-sm-5" style="justify-content: center;">
                                <label for="operator" class="col-sm-4 col-form-label">操作人員：</label>
                                <div class="col-sm">
                                    <input type="text" class="form-control" id="operator" placeholder="操作人員">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group row col-sm" style="justify-content: center;">
                                <label for="opType" class="col-sm-2 col-form-label" style="white-space:nowrap">操作型態：</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="opType" placeholder="操作型態" style="max-width:200px">
                                        <option disabled hidden selected></option>
                                        <option value="登入">登入</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row col-sm-5" style="justify-content: center;">
                                <label for="msg" class="col-sm-4 col-form-label">操作訊息：</label>
                                <div class="col-sm">
                                    <input type="text" class="form-control" id="msg" placeholder="操作訊息">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="" style="margin: auto; justify-content:center">
                        <button type="button" class="btn btn-warning" style="white-space:nowrap" onclick="reset()">清除</button>
                        <button type="button" class="btn btn-success" style="white-space:nowrap" onclick="search();">查詢</button>
                    </div>
                </div>
                <table id="SysOpLogTable" class="table table-hover table-bordered" style="margin:5px auto">
                    <thead>
                        <tr>
                            <th>功能畫面名稱</th>
                            <th>操作型態</th>
                            <th>操作訊息</th>
                            <th>操作時間</th>
                            <th>操作人員</th>
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
                                CT_No: '003'
                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json.hasOwnProperty('error'))
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                                else {
                                    for (i = 0; i < json['data'].length; i++) {
                                        $('#opType').append($("<option></option>").attr("value", json['data'][i]['CI_Name']).text(json['data'][i]['CI_Name']));
                                    }
                                }

                            }
                        });
                    });
                    var table;
                    $(function() {
                        opt = {
                            "ajax": {
                                "url": "/clothes/ajax/manage_ajax.php",
                                "type": "GET",
                                "data": {
                                    form: "sysoplog"
                                }
                            },
                            "columns": [{

                                    "render": function(data, type, row, meta) {
                                        if (row.Func_No === null)
                                            return "登入畫面";
                                        else
                                            return row.func_Name;

                                    }
                                },
                                {
                                    "render": function(data, type, row, meta) {
                                        if (row.Op_No === null)
                                            return "登入";
                                        else
                                            return row.op_Name;

                                    }
                                },
                                {
                                    "data": "Op_Msg"
                                },
                                {
                                    "data": "Addtime"
                                },
                                {
                                    "data": "Adduser"
                                }

                            ],
                            "lengthMenu": [
                                [5, 10, 15, 20, -1],
                                [5, 10, 15, 20, "All"]
                            ],
                            "order": [
                                [3, "desc"]
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
                            dom: 'lrtip',
                            "destroy": true,
                            "bAutoWidth": false //solve width:0px
                        }
                        table = $('#SysOpLogTable').DataTable(opt);
                    });

                    function search() {
                        $.fn.dataTable.ext.search.push(
                            function(settings, data, dataIndex) {
                                var opType = $("#searchBox select").eq(0).val();
                                var start = $("#searchBox input").eq(0).val();
                                var end = $("#searchBox input").eq(1).val();
                                var operator = $("#searchBox input").eq(2).val();
                                var msg = $("#searchBox input").eq(3).val();
                                var date = new Date(data[3]);

                                if ((opType === null || opType == '' || data[1] == opType) &&
                                    (msg == '' || data[2].includes(msg)) &&
                                    (operator == '' || data[4].includes(operator)) &&
                                    (isNaN(date.getTime()) || (start == '' && end == '') || (start != '' && end != '' && date >= new Date(start) && date <= new Date(end)) ||
                                        (start != '' && end == '' && date >= new Date(start)) || (start == '' && end != '' && date <= new Date(end)))) {
                                    return true;
                                }
                                return false;
                            }
                        );

                        table.draw();
                    }

                    function reset() {
                        $("#searchBox select").eq(0).val('');
                        $("#searchBox input").eq(0).val('');
                        $("#searchBox input").eq(1).val('');
                        $("#searchBox input").eq(2).val('');
                        $("#searchBox input").eq(3).val('');
                        search();
                    }
                </script>

            </div>
        </div>
    </section>
</body>

</html>