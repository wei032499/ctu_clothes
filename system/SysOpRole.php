<?php
@require_once($_SERVER["DOCUMENT_ROOT"] . "/clothes/functions/functions.php");
$permission = checkPermission(null, 'Z02');
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
            $("nav li").eq(6).addClass("active");
        });
    </script>
    <section>
        <div class="container" style="margin: 20px auto">
            <div class="shadow bg-white " style="padding:0.15rem 1rem!important">
                <a href="/clothes/" class="text-dark">首頁</a> /
                <a href="/clothes/system/" class="text-dark">系統管理</a> /
                <a href="/clothes/system/SysOpRole.php" class="text-info">系統使用權限</a>
            </div>
        </div>
    </section>
    <section>
        <div class="container" style="margin: 10px auto">
            <div class="shadow p-3 mb-5 bg-white rounded" style="padding:2.5rem!important">
                <h1>系統使用權限</h1>
                <hr>
                <div class="border row" style="margin: 10px auto;padding-top:10px;padding-bottom:10px" id="searchBox">
                    <div class="row col-sm" style="margin:10px auto">
                        <label for="operatorId" class="col-form-label">角色代碼：</label>
                        <div class="col-sm">
                            <input type="text" class="form-control" id="operatorId" placeholder="角色代碼">
                        </div>
                    </div>
                    <div class="row col-sm" style="margin:10px auto">
                        <label for="operator" class="col-form-label">角色名稱：</label>
                        <div class="col-sm">
                            <input type="text" class="form-control" id="operator" placeholder="角色名稱">
                        </div>
                    </div>
                    <div class="row" style="margin:10px auto;justify-content:center">
                        <button type="button" class="btn btn-success" style="white-space:nowrap;margin:auto 5px" onclick="search();">查詢</button>
                        <button type="button" class="btn btn-warning" style="white-space:nowrap;margin:auto 5px" onclick="resetSearch();">清除</button>
                        <button type="button" class="btn btn-primary" style="white-space:nowrap;margin:auto 5px" data-toggle="modal" data-target="#ADDModal" onclick="onFormCreate()">新增</button>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="ADDModal" tabindex="-1" role="dialog" aria-labelledby="ADDModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="ADDModalLabel">新增角色</h5>
                                <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>-->
                            </div>
                            <script>
                                function onFormCreate() {
                                    $('#roleForm').attr('method', 'POST');
                                    $('#ADDModalLabel').html('新增角色');
                                    $("#topForm input").removeAttr('readonly');
                                    $('#nav-branch-tab').tab('show');
                                    $('#functions-system').css('display', '');
                                    $("#createBtns").css('display', '');
                                    $("#readBtns").css('display', 'none');
                                }

                                function onFormReset() {
                                    $("#topForm input").removeAttr('readonly');
                                    $('#nav-branch-tab').tab('show');
                                    $('#functions-system').css('display', '');
                                    //$("#createBtns").css('display', '');
                                    //$("#readBtns").css('display', 'none');
                                }
                            </script>
                            <form id="roleForm" action="/clothes/ajax/manage_ajax.php" method="post" onreset="onFormReset();">
                                <div class="modal-body">
                                    <div id="topForm">
                                        <input type="text" name="form" value="role" style="display:none" required />
                                        <div class="form-group">
                                            <label for="Or_No">角色代碼</label>
                                            <input type="text" class="form-control" id="Or_No" name="Or_No" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="Or_Name">角色名稱</label>
                                            <input type="text" class="form-control" id="Or_Name" name="Or_Name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="Or_Type">角色類別</label>
                                            <select class="form-control" id="Or_Type" name="Or_Type" required>
                                                <option disabled hidden selected></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div>
                                        <nav>
                                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                <a class="nav-item nav-link active" id="nav-branch-tab" data-toggle="tab" href="#nav-branch" role="tab" aria-controls="nav-branch" aria-selected="true">分店權限</a>
                                                <a class="nav-item nav-link" id="nav-function-tab" data-toggle="tab" href="#nav-function" role="tab" aria-controls="nav-function" aria-selected="false">功能權限</a>
                                            </div>
                                        </nav>
                                        <div class="tab-content" id="nav-tabContent">
                                            <div class="tab-pane fade show active" id="nav-branch" role="tabpanel" aria-labelledby="nav-branch-tab" style="padding: 20px;">
                                                <table id="branchTable" class="table table-hover" style="margin:5px auto">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>分店代碼</th>
                                                            <th>分店名稱</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>

                                                </table>
                                                <script>
                                                    /*function branchChange(checkbox) {
                                                        console.log(checkbox);
                                                        if ($(checkbox).prop('checked')) {
                                                            $('#functions-' + $(checkbox).val()).css('display', '');
                                                            $('#functions-' + $(checkbox).val() + ' select').removeAttr('disabled');
                                                        } else {
                                                            $('#functions-' + $(checkbox).val()).css('display', 'none');
                                                            $('#functions-' + $(checkbox).val() + ' select').attr('disabled', 'true');
                                                        }
                                                    }*/
                                                </script>
                                            </div>
                                            <div class="tab-pane fade" id="nav-function" role="tabpanel" aria-labelledby="nav-function-tab">
                                                <div class="card-body">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">功能代碼</th>
                                                                <th scope="col">功能名稱</th>
                                                                <th scope="col">權限</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="modal-footer">
                                    <div id="createBtns">
                                        <button type="reset" class="btn btn-warning">重設</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                                        <button type="submit" class="btn btn-primary">儲存</button>
                                    </div>
                                    <div id="readBtns">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('#roleForm').trigger('reset');">關閉</button>
                                        <button type="submit" class="btn btn-primary">儲存</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <table id="SysOpRoleTable" class="table table-hover table-bordered" style="margin:5px auto">
                    <thead>
                        <tr>
                            <th>角色代碼</th>
                            <th>角色名稱</th>
                            <th>角色類別</th>
                            <th>權限</th>
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
                                CT_No: '002'
                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json.hasOwnProperty('error'))
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                                else {
                                    for (i = 0; i < json['data'].length; i++) {
                                        $('#Or_Type').append($("<option></option>").attr("value", json['data'][i]['CI_No']).text(json['data'][i]['CI_Name']));
                                    }
                                }

                            }
                        });
                    });

                    function loadForm(code, name, type) {
                        $("#roleForm").trigger("reset");
                        $('#ADDModalLabel').html('編輯角色');
                        $('#roleForm').attr('method', 'PUT');
                        $("#Or_No").val(code);
                        $("#Or_Name").val(name);
                        $("#Or_Type").val(type);
                        $("#topForm input").eq(1).attr('readonly', true);
                        $("#createBtns").css('display', 'none');
                        $("#readBtns").css('display', '');
                        $.when($.ajax({
                            type: 'GET',
                            url: '/clothes/ajax/manage_ajax.php',
                            data: {
                                form: "sysoprolebranch",
                                Or_No: code
                            },
                            dataType: "json",
                            success: function(json) {
                                if (json['status'] === "success") {

                                    for (i = 0; i < json['data'].length; i++) {
                                        //$("#roleForm input[value='" + json['data'][i].bran_num + "']").prop("checked", true).change();
                                        $("#branchTable" + " input[value='" + json['data'][i].Bran_Num + "']").prop("checked", true);
                                    }

                                } else {
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                                }

                            }
                        }), $.ajax({
                            type: 'GET',
                            url: '/clothes/ajax/manage_ajax.php',
                            data: {
                                form: "sysoprolefunc",
                                Or_No: code
                            },
                            dataType: "json",
                            success: function(json) {
                                if (json['status'] === "success") {

                                    for (i = 0; i < json['data'].length; i++) {
                                        //$("#roleForm input[value='" + json['data'][i].bran_num + "']").prop("checked", true).change();
                                        $("#nav-function" + " select[name='Func_Right[" + json['data'][i].Func_No + "]']").val(json['data'][i].Func_Right);
                                    }


                                } else {
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                                }

                            }
                        })).done(function() {

                            $('#ADDModal').modal('show');


                        });

                    }
                    $(function() {
                        opt = {
                            "ajax": {
                                "url": "/clothes/ajax/manage_ajax.php",
                                "type": "GET",
                                "data": {
                                    form: "sysoprole"
                                }
                            },
                            "columns": [{
                                    "data": "Or_No"
                                },
                                {
                                    "data": "Or_Name"
                                },
                                {
                                    "data": "Or_TypeName"
                                },
                                {
                                    "render": function(data, type, row, meta) {
                                        data = "<div class='row' style='justify-content: center;'><button class='btn btn-warning' onclick=\"loadForm('" + row.Or_No + "','" + row.Or_Name + "','" + row.Or_Type + "')\" style='margin: 1px;' >修改</button><button class='btn btn-danger' style='margin: 1px;' onclick=\"deleteData('role','" + row.Or_No + "')\">刪除</button></div>";
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
                        $('#SysOpRoleTable').DataTable(opt);
                    });

                    function search() {
                        $('#SysOpRoleTable').DataTable().columns(0).search($($('input')[0]).val());
                        $('#SysOpRoleTable').DataTable().columns(1).search($($('input')[1]).val());
                        $('#SysOpRoleTable').DataTable().draw();

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
                                        toastr.error(json.error, "ERROR"); // show response from the php script.
                                    $('#SysOpRoleTable').DataTable().ajax.reload();

                                }
                            });
                        }

                    }


                    $(function() {
                        opt = {
                            "ajax": {
                                "url": "/clothes/ajax/manage_ajax.php",
                                "type": "GET",
                                "data": {
                                    form: "branch"
                                }
                            },
                            "columns": [{
                                    "render": function(data, type, row, meta) {
                                        // onchange='branchChange(this);'
                                        data = "<input type='checkbox' style='width:100%' name='bran_num[]' value='" + row.Bran_Num + "'>";
                                        return data;
                                    }
                                }, {
                                    "data": "Bran_Num"
                                },
                                {
                                    "data": "Bran_Name"
                                }
                            ],
                            "lengthMenu": [
                                [5, 10, 15, 20, -1],
                                [5, 10, 15, 20, "All"]
                            ],
                            "order": [
                                [1, "asc"]
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
                            "initComplete": function(settings, json) {

                                functionCodes = []
                                functionRights = []

                                $.when($.ajax({
                                    type: 'GET',
                                    url: '/clothes/ajax/manage_ajax.php',
                                    data: {
                                        form: 'syscodeinfo',
                                        CT_No: '001'

                                    }, // serializes the form's elements.
                                    dataType: "json",
                                    success: function(json) {
                                        if (json.hasOwnProperty('error'))
                                            toastr.error(json.error, "ERROR"); // show response from the php script.
                                        else {
                                            functionCodes = json['data'];


                                        }

                                    }
                                }), $.ajax({
                                    type: 'GET',
                                    url: '/clothes/ajax/manage_ajax.php',
                                    data: {
                                        form: 'syscodeinfo',
                                        CT_No: '003'

                                    }, // serializes the form's elements.
                                    dataType: "json",
                                    success: function(json) {
                                        if (json.hasOwnProperty('error'))
                                            toastr.error(json.error, "ERROR"); // show response from the php script.
                                        else {
                                            functionRights = json['data'];

                                        }

                                    }
                                })).done(function() {
                                    console.log(json['data']);


                                    //html = "<div class=\"card\" id='functions-system' ><div class=\"card-header\" =\"heading\"><h5 class=\"mb-0\"><button type=\"button\" class=\"btn btn-link\" data-toggle=\"collapse\" data-target=\"#collapse\" aria-expanded=\"true\" aria-controls=\"collapse\">系統權限</button></h5></div><div id=\"collapse\" class=\"collapse\" aria-labelledby=\"heading\" data-parent=\"#accordion\"><div class=\"card-body\"><table class=\"table table-hover\"><thead><tr><th scope=\"col\">功能代碼</th><th scope=\"col\">功能名稱</th><th scope=\"col\">權限</th></tr></thead><tbody>";
                                    html = "";


                                    functionCodes.forEach(item => {
                                        html += "<tr><td>" + item.CI_No + "</td><td>" + item.CI_Name + "</td><td><select name=\"Func_Right[" + item.CI_No + "]\" class=\"form-control\" required><option value='-1' selected>無此權限</option>"; //disabled hidden 
                                        functionRights.forEach(item2 => {
                                            html += "<option value='" + item2.CI_No + "'>" + item2.CI_Name + "</option>";
                                        });
                                        html += "</select></td></tr>";
                                    });
                                    //html += "</tbody></table></div></div></div>";
                                    $('#nav-function tbody').append(html);


                                    /*for (i = 0; i < json['data'].length; i++) {
                                        html = "<div class=\"card\" id='functions-" + json['data'][i].Bran_Num + "' style=\"display:none\"><div class=\"card-header\" id=\"heading" + i + "\"><h5 class=\"mb-0\"><button type=\"button\" class=\"btn btn-link\" data-toggle=\"collapse\" data-target=\"#collapse" + i + "\" aria-expanded=\"true\" aria-controls=\"collapse" + i + "\">" + json['data'][i].Bran_Num + " - " + json['data'][i].Bran_Name + "</button></h5></div><div id=\"collapse" + i + "\" class=\"collapse\" aria-labelledby=\"heading" + i + "\" data-parent=\"#accordion\"><div class=\"card-body\"><table class=\"table table-hover\"><thead><tr><th scope=\"col\">功能代碼</th><th scope=\"col\">功能名稱</th><th scope=\"col\">權限</th></tr></thead><tbody>";



                                        functionCodes.forEach(item => {
                                            html += "<tr><td>" + item.CI_No + "</td><td>" + item.CI_Name + "</td><td><select name=\"Func_Right[" + json['data'][i].Bran_Num + "][" + item.CI_No + "]\" class=\"form-control\" ><option disabled hidden selected></option>";
                                            functionRights.forEach(item2 => {
                                                html += "<option value='" + item2.CI_No + "'>" + item2.CI_Name + "</option>";
                                            });
                                            html += "</select></td></tr>";
                                        });
                                        html += "</tbody></table></div></div></div>";
                                        $('#accordion').append(html);

                                    }*/







                                });
                            },
                            "destroy": true,
                            "bAutoWidth": false //solve width:0px
                        }
                        $('#branchTable').DataTable(opt);
                    });







                    $("#roleForm").submit(function(e) {

                        var form = $(this);
                        var url = form.attr('action');
                        var method = form.attr('method');
                        console.log(form);

                        $.ajax({
                            type: method,
                            url: url,
                            data: form.serialize(), // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json.hasOwnProperty('error'))
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                                else {
                                    $('#SysOpRoleTable').DataTable().ajax.reload();
                                    toastr.success("新增成功", "Success");
                                    $("#roleForm").trigger("reset");
                                    $('#ADDModal').modal('hide');

                                }

                            }
                        });

                        e.preventDefault(); // avoid to execute the actual submit of the form.
                    });

                    function resetSearch() {
                        $($('#searchBox input')[0]).val('');
                        $($('#searchBox input')[1]).val('');
                        search();
                    }
                </script>
                <style>
                    #branchTable {
                        text-align: center;


                    }

                    #branchTable tbody tr td:nth-of-type(1) {
                        vertical-align: middle;

                    }
                </style>

            </div>
        </div>
    </section>
</body>

</html>