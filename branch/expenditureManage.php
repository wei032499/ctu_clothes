<?php
@require_once($_SERVER["DOCUMENT_ROOT"] . "/clothes/functions/functions.php");
$permission = checkPermission(null, 'D02');
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
            $("nav li").eq(4).addClass("active");
        });
    </script>
    <section>
        <div class="container" style="margin: 20px auto">
            <div class="shadow bg-white " style="padding:0.15rem 1rem!important">
                <a href="/clothes/" class="text-dark">首頁</a> /
                <a href="/clothes/branch/" class="text-dark">分店管理</a> /
                <a href="/clothes/branch/expenditureManage.php" class="text-info">分店費用報支維護</a>
            </div>
        </div>
    </section>
    <section>
        <div class="container" style="margin: 10px auto">
            <div class="shadow p-3 mb-5 bg-white rounded" style="padding:2.5rem!important">
                <h1>分店費用報支維護</h1>
                <hr />
                <div class="border row" style="margin: 10px auto;padding:10px" id="searchBox">
                    <div class="row" style="margin: auto;width: 100%;">
                        <div class="row col-sm-6" style="margin:10px auto">
                            <label for="" class="col-form-label" style="width: 100px;">分店名稱：</label>
                            <div class="col-sm" style="min-width: 200px;">
                                <input type="text" class="form-control" id="">
                            </div>
                        </div>
                        <div class="row col-sm-6" style="margin:10px auto">
                            <label for="" class="col-form-label" style="width: 100px;">費用類型：</label>
                            <div class="col-sm" style="min-width: 200px;">
                                <select class="form-control" id="">
                                    <option selected></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin: auto;width: 100%;">
                        <div class="row col-sm-6" style="margin:10px auto">
                            <label for="" class="col-form-label" style="width: 100px;">支出日期：</label>
                            <div class="col-sm row" style="min-width: 200px;">
                                <input type="date" class="col-sm form-control" id=""><span style="margin: auto;">~</span><input type="date" class="col-sm form-control" id="">
                            </div>
                        </div>
                        <div class="row col-sm-6" style="margin:10px auto;justify-content:center;min-width: 200px;">
                            <button type="button" class="btn btn-success" style="white-space:nowrap;margin:auto 3px" onclick="search();">查詢</button>
                            <button type="button" class="btn btn-warning" style="white-space:nowrap;margin:auto 3px" onclick="resetSearch();">清除</button>
                            <button type="button" class="btn btn-primary" style="white-space:nowrap;margin:auto 3px" onclick="window.open('expenditureInfo.php','_self')">新增</button>
                        </div>
                    </div>
                </div>
                <table id="expenditureTable" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>分店編號</th>
                            <th>分店名稱</th>
                            <th>支出日期</th>
                            <th>費用類型</th>
                            <th>支出金額</th>
                            <th>費用說明</th>
                            <th>修改/刪除</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </section>
    <script>
        $(function() {
            opt = {
                "ajax": {
                    "url": "/clothes/ajax/manage_ajax.php",
                    "type": "GET",
                    "data": {
                        form: "expenditure"
                    }
                },
                "columns": [{
                        "data": "Bran_Num"
                    },
                    {
                        "data": "Bran_Name"
                    },
                    {
                        "data": "EB_Date"
                    },
                    {
                        "data": "EB_Cate_Name"
                    },
                    {
                        "data": "EB_Amt"
                    },
                    {
                        "data": "EB_Msg"
                    },
                    {
                        "render": function(data, type, row, meta) {
                            data = "<button type=\"button\" class=\"btn btn-warning \" onclick=\"window.open('expenditureInfo.php?id=" + row.EB_Id + "','_self');\" style=\"margin:1px\">修改</button>";

                            data += "<button type=\"button\" class=\"btn btn-danger \" onclick=\"deleteData('expenditure','" + row.EB_Id + "')\" style=\"margin:1px\">刪除</button>";
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
            $('#expenditureTable').DataTable(opt);
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var Bran_Name = $('#searchBox input').eq(0).val();
                    var EB_Cate_Name = $('#searchBox select :selected').text();
                    var start = $('#searchBox input').eq(1).val();
                    var end = $('#searchBox input').eq(2).val();
                    var date = new Date(data[2]);

                    if ((Bran_Name == '' || data[1].includes(Bran_Name)) &&
                        (EB_Cate_Name == '' || data[3] == EB_Cate_Name) &&
                        (isNaN(date.getTime()) || (start == '' && end == '') || (start != '' && end != '' && date >= new Date(start) && date <= new Date(end)) ||
                            (start != '' && end == '' && date >= new Date(start)) || (start == '' && end != '' && date <= new Date(end)))) {
                        return true;
                    }
                    return false;
                }
            );
            $("#expenditureTable").wrap("<div style='overflow-x:auto'></div>");
        });

        $.ajax({
            type: "GET",
            url: "/clothes/ajax/manage_ajax.php",
            data: {
                form: "syscodeinfo",
                CT_No: "C04"
            },
            dataType: "json",
            success: function(json) {

                if (json.status === "error")
                    toastr.error(json.error, "ERROR"); // show response from the php script.
                else {
                    for (i = 0; i < json['data'].length; i++)
                        $("#searchBox select").eq(0).append($("<option></option>").attr("value", json['data'][i].CI_No).text(json['data'][i].CI_Name));
                }


            }
        });

        function search() {
            /*$.fn.dataTable.ext.search.pop();
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var Bran_Name = $('#searchBox input').eq(0).val();
                    var EB_Cate_Name = $('#searchBox select :selected').text();
                    var start = $('#searchBox input').eq(1).val();
                    var end = $('#searchBox input').eq(2).val();
                    var date = new Date(data[2]);

                    if ((Bran_Name == '' || data[1].includes(Bran_Name)) &&
                        (EB_Cate_Name == '' || data[3] == EB_Cate_Name) &&
                        (isNaN(date.getTime()) || (start == '' && end == '') || (start != '' && end != '' && date >= new Date(start) && date <= new Date(end)) ||
                            (start != '' && end == '' && date >= new Date(start)) || (start == '' && end != '' && date <= new Date(end)))) {
                        return true;
                    }
                    return false;
                }
            );*/

            $('#expenditureTable').DataTable().draw();


        }



        function resetSearch() {
            $('#searchBox input').eq(0).val('');
            $('#searchBox input').eq(1).val('');
            $('#searchBox input').eq(2).val('');
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
                        if (json.hasOwnProperty('status') && json['status'] === "success") {
                            toastr.success("刪除成功", "Success");
                        } else
                            toastr.error(json['error'], "ERROR");
                        $('#expenditureTable').DataTable().ajax.reload();

                    }
                });
            }

        }
    </script>
</body>

</html>