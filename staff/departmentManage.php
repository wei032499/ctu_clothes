<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/clothes/functions/functions.php");
$permission = checkPermission(null, 'C01');
if ($permission  < 1) {
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
            $("nav li").eq(3).addClass("active");
        });
    </script>
    <section>
        <div class="container" style="margin: 20px auto">
            <div class="shadow bg-white " style="padding:0.15rem 1rem!important">
                <a href="/clothes/" class="text-dark">首頁</a> /
                <a href="/clothes/staff/" class="text-dark">人事薪資管理</a> /
                <a href="/clothes/staff/departmentManage.php" class="text-info">部門資料維護</a>
            </div>
        </div>
    </section>
    <section>
        <div class="container" style="margin: 10px auto">
            <div class="shadow p-3 mb-5 bg-white rounded" style="padding:2.5rem!important">
                <h1>部門資料維護</h1>
                <hr />
                <div class="border row" style="margin: 10px auto;padding:10px" id="searchBox">
                    <div class="row" style="margin: auto;width: 100%;">
                        <div class="row col-sm" style="margin:10px auto">
                            <label for="" class="col-form-label" style="width: 100px;">部門名稱：</label>
                            <div class="col-sm" style="min-width: 200px;">
                                <input type="text" class="form-control" id="">
                            </div>
                        </div>
                        <div class="row col-sm" style="margin:10px auto">
                            <label for="" class="col-form-label" style="width: 100px;">部門主管：</label>
                            <div class="col-sm" style="min-width: 200px;">
                                <input type="text" class="form-control" id="">
                            </div>
                        </div>
                        <div class="row col-sm" style="margin:10px auto;justify-content:center;min-width: 200px;">
                            <button type="button" class="btn btn-success" style="white-space:nowrap;margin:auto 3px" onclick="search();">查詢</button>
                            <button type="button" class="btn btn-warning" style="white-space:nowrap;margin:auto 3px" onclick="resetSearch();">清除</button>
                            <button type="button" class="btn btn-primary" style="white-space:nowrap;margin:auto 3px" onclick="window.open('departmentInfo.php','_self')">新增</button>
                        </div>
                    </div>
                </div>
                <table id="departmentTable" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>部門編號</th>
                            <th>部門名稱</th>
                            <th>部門主管</th>
                            <th>修改/刪除</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </section>


    <script>
        $(function() {
            opt_department = {
                "ajax": {
                    "url": "/clothes/ajax/manage_ajax.php",
                    "type": "GET",
                    "data": {
                        form: "department"
                    }
                },
                "columns": [{
                        "data": "Dep_Num"
                    },
                    {
                        "data": "Dep_Name"
                    },
                    {
                        "data": "Dep_Supr_Name"
                    },
                    {
                        "render": function(data, type, row, meta) {
                            data = "<button type=\"button\" class=\"btn btn-warning \" onclick=\"window.open('departmentInfo.php?id=" + row.Dep_Num + "','_self');\" style=\"margin:1px\">修改</button>";

                            data += "<button type=\"button\" class=\"btn btn-danger \" onclick=\"deleteData('department','" + row.Dep_Num + "')\" style=\"margin:1px\">刪除</button>";
                            return data;
                        }
                    },
                    {
                        "data": "Chgtime",
                        "searchable": true,
                        "visible": false
                    }
                ],
                "lengthMenu": [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                "order": [
                    [4, "desc"]
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
                dom: 'Bfrtip',
                buttons: [{
                    extend: <?php if ($permission >= 5) echo "'excelHtml5'";
                            else echo "null"; ?>
                }],
                "destroy": true,
                "bAutoWidth": false //solve width:0px
            }
            $('#departmentTable').DataTable(opt_department).draw();
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var Dep_Name = $('#searchBox input').eq(0).val();
                    var Dep_Supr_Name = $('#searchBox input').eq(1).val();


                    if ((Dep_Name == '' || data[1].includes(Dep_Name)) &&
                        (Dep_Supr_Name == '' || data[2].includes(Dep_Supr_Name))) {
                        return true;
                    }
                    return false;
                }
            );
            $("#departmentTable").wrap("<div style='overflow-x:auto'></div>");
        });

        function search() {
            /*$.fn.dataTable.ext.search.pop();
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var Dep_Name = $('#searchBox input').eq(0).val();
                    var Dep_Supr_Name = $('#searchBox input').eq(1).val();


                    if ((Dep_Name == '' || data[1].includes(Dep_Name)) &&
                        (Dep_Supr_Name == '' || data[2].includes(Dep_Supr_Name))) {
                        return true;
                    }
                    return false;
                }
            );*/


            $('#departmentTable').DataTable().draw();


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
                            toastr.error(json.error, "ERROR");
                        $('#departmentTable').DataTable().ajax.reload();

                    }
                });
            }

        }
    </script>
</body>

</html>