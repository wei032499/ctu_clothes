<?php
@require_once($_SERVER["DOCUMENT_ROOT"] . "/clothes/functions/functions.php");
if (checkPermission(null, 'Z01') < 1) {
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
                <a href="/clothes/system/SysCode.php" class="text-info">系統代碼管理</a>
            </div>
        </div>
    </section>
    <section>
        <div class="container" style="margin: 10px auto">
            <div class="shadow p-3 mb-5 bg-white rounded" style="padding:2.5rem!important">
                <h1>系統代碼管理</h1>
                <hr>
                <div class="row">

                    <div class="col-sm-5" style="text-align:center;margin:5px auto;min-width:350px">
                        <table id="systemCodeTypeTable" class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>代碼類別碼</th>
                                    <th>代碼類別說明</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="vertical-align: middle;" onclick="">
                                        <input type="radio" name="chosen">
                                    </td>
                                    <td style="vertical-align: middle;">1</td>
                                    <td style="vertical-align: middle;">2</td>
                                </tr>
                                <tr>
                                    <td onclick="$(this).children()[0].checked=true;$($('#systemCodeTypeForm')[0][0]).val($(this).parent().children()[1].innerText);$($('#systemCodeTypeForm')[0][1]).val($(this).parent().children()[2].innerText)">
                                        <input type="radio" name="chosen">
                                    </td>
                                    <td style="vertical-align: middle;">3</td>
                                    <td style="vertical-align: middle;">4</td>
                                </tr>
                            </tbody>

                        </table>
                        <script>
                            $('#systemCodeTypeTable tbody ').on('click', 'tr td:first-child', function() {
                                $("#formBtns button").eq(3).css('display', '');
                                resetForm2($('#systemCodeInfoForm_clearBtn'));

                                $(this).children()[0].checked = true;
                                $($('#systemCodeTypeForm')[0][1]).val($(this).parent().children()[1].innerText);
                                $($('#systemCodeTypeForm')[0][2]).val($(this).parent().children()[2].innerText);
                                $($('#formBtns').children()[0]).css('display', 'none');
                                $($('#formBtns').children()[1]).css('display', '');
                                $('#systemCodeTypeForm').attr("method", "PUT");
                                $($('#systemCodeInfoForm')[0][1]).val($(this).parent().children()[1].innerText);
                                loadTable2($(this).parent().children()[1].innerText);
                                $($('#systemCodeInfoForm')[0][1]).val($(this).parent().children()[1].innerText);
                                $($('#systemCodeTypeForm')[0][1]).attr('readonly', true);


                            });

                            function loadTable2(CT_No) {
                                console.log(CT_No);
                                opt = {
                                    "ajax": {
                                        "url": "/clothes/ajax/manage_ajax.php",
                                        "type": "GET",
                                        "data": {
                                            form: "syscodeinfo",
                                            CT_No: CT_No
                                        }
                                    },
                                    "columns": [{
                                            "data": "CT_No",
                                            "visible": false
                                        }, {
                                            "data": "CI_No"
                                        },
                                        {
                                            "data": "CI_Name"
                                        },
                                        {
                                            "data": "CI_Value"
                                        }, {
                                            "render": function(data, type, row, meta) {
                                                data = "<div class='row' style='justify-content: center;'><button class='btn btn-warning ' onclick='loadForm2(this)' style='margin: 1px;' >修改</button><button class='btn btn-danger' style='margin: 1px;' onclick=\"deleteData2('syscodeinfo','" + row.CT_No + "','" + row.CI_No + "')\">刪除</button></div>";
                                                return data;
                                            }
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
                                    "sDom": 'lrtip',
                                    "destroy": true,
                                    "bAutoWidth": false //solve width:0px
                                }
                                $('#systemCodeInfoTable').DataTable(opt);
                            }

                            function loadForm2(btn) {
                                $($('#systemCodeInfoForm')[0][2]).val($(btn).parent().parent().parent().children()[0].innerText);
                                $($('#systemCodeInfoForm')[0][3]).val($(btn).parent().parent().parent().children()[1].innerText);
                                $($('#systemCodeInfoForm')[0][4]).val($(btn).parent().parent().parent().children()[2].innerText);
                                $("#systemCodeInfoForm").attr("method", "PUT");
                                $($("#form2Btns").children()[0]).css('display', 'none');
                                $($("#form2Btns").children()[1]).css('display', '');
                                $($('#systemCodeInfoForm')[0][2]).attr('readonly', true);

                            }
                        </script>
                    </div>
                    <form class="col-sm-5" id="systemCodeTypeForm" action="/clothes/ajax/manage_ajax.php" method="POST" style="text-align:center;margin:5px auto;min-width:350px;display:flex;justify-content:center">
                        <div class="border" style="padding: 20px 35px;width:max-content;margin:auto">
                            <input type="text" name="form" value="syscodetype" style="display:none" required />
                            <div class="form-group row" style="width:max-content;">
                                <label for="CT_No" style="margin-right:5px;width:100px;" class="col-form-label">代碼類別碼</label>
                                <input id="CT_No" type="text" class="form-control" style="min-width:100px;max-width: 200px;" name="CT_No" required>
                            </div>
                            <div class="form-group row" style="width:max-content;">
                                <label for="CT_Name" style="margin-right:5px;width:100px;" class="col-form-label">代碼類別說明</label>
                                <input type="text" class="form-control" style="min-width:100px;max-width: 200px;" name="CT_Name" required>
                            </div>
                            <div id="formBtns" class="row" style="justify-content: center;">
                                <button class="btn btn-success" type="submit">新增</button>
                                <button class="btn btn-success" style="display:none" type="submit">更新</button>
                                <button class="btn btn-info" style="margin:auto 10px" onclick="resetForm()" type="button">清除</button>
                                <button class="btn btn-danger" type="button" style="display: none;" onclick="deleteData('syscodetype', $('#systemCodeTypeForm input').eq(1).val())">刪除</button>
                                <script>
                                    function uncheckAll() {
                                        $("input[name='chosen']").prop('checked', false);
                                    }
                                </script>
                            </div>
                        </div>
                    </form>
                </div>
                <hr />
                <div class="row">

                    <div class="col-sm-5" style="text-align:center;margin:5px auto;min-width:350px">
                        <table id="systemCodeInfoTable" class="table table-hover table-bordered ">
                            <thead>
                                <tr>
                                    <th>代碼類別碼</th>
                                    <th>系統代碼</th>
                                    <th>系統代碼說明</th>
                                    <th>特殊值</th>
                                    <th>修改 / 刪除</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>

                        </table>
                    </div>
                    <form class="col-sm-5" id="systemCodeInfoForm" action="/clothes/ajax/manage_ajax.php" method="POST" style="text-align:center;margin:5px auto;min-width:350px;display:flex;justify-content:center">
                        <div class="border" style="padding: 20px 35px;width:max-content;margin:auto">
                            <input type="text" name="form" value="syscodeinfo" style="display:none" required />
                            <input type="text" name="CT_No" style="display:none" required />
                            <div class="form-group row" style="width:max-content;">
                                <label for="CI_No" style="margin-right:5px;width:100px;" class="col-form-label">系統代碼</label>
                                <input id="CI_No" type="text" class="form-control" style="min-width:100px;max-width: 200px;" name="CI_No" required>
                            </div>
                            <div class="form-group row" style="width:max-content;">
                                <label for="CI_Name" style="margin-right:5px;width:100px;" class="col-form-label">系統代碼說明</label>
                                <input type="text" class="form-control" style="min-width:100px;max-width: 200px;" name="CI_Name" required>
                            </div>
                            <div class="form-group row" style="width:max-content;">
                                <label for="CI_Value" style="margin-right:5px;width:100px;" class="col-form-label">特殊值</label>
                                <input type="text" class="form-control" style="min-width:100px;max-width: 200px;" name="CI_Value">
                            </div>
                            <div id="form2Btns" class="row" style="justify-content: center;">
                                <button class="btn btn-success" type="submit" style="margin:auto 5px">新增</button>
                                <button class="btn btn-success" type="submit" style="margin:auto 5px;display:none">確定</button>
                                <button id="systemCodeInfoForm_clearBtn" class="btn btn-info" type="button" style="margin:auto 5px" onclick="resetForm2()">清除</button>
                                <script>
                                    function resetForm2(obj) {
                                        $('#systemCodeInfoForm').trigger("reset");
                                        $('#systemCodeInfoForm input').eq(1).val($('#systemCodeTypeForm input').eq(1).val());
                                        $('#systemCodeInfoForm').attr('method', 'POST');
                                        $("#form2Btns button").eq(0).css('display', '');
                                        $("#form2Btns button").eq(1).css('display', 'none');
                                        $('#systemCodeInfoForm input').eq(2).attr('readonly', false);
                                    }
                                </script>
                            </div>
                        </div>
                    </form>
                </div>
                <script>
                    $(function() {
                        opt = {
                            "ajax": {
                                "url": "/clothes/ajax/manage_ajax.php",
                                "type": "GET",
                                "data": {
                                    form: "syscodetype"
                                }
                            },
                            "columns": [{
                                    "render": function(data, type, row, meta) {
                                        data = "<input type='radio' name='chosen'>";
                                        return data;
                                    }
                                }, {
                                    "data": "CT_No"
                                },
                                {
                                    "data": "CT_Name"
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
                            //"searching": false,
                            "destroy": true,
                            "sDom": 'lrtip',
                            "bAutoWidth": false //solve width:0px
                        }
                        $('#systemCodeTypeTable').DataTable(opt);
                        loadTable2('');
                    });

                    function resetForm() {
                        uncheckAll();
                        $('#systemCodeTypeForm').trigger("reset");
                        $($('#formBtns').children()[1]).css('display', 'none');
                        $($('#formBtns').children()[0]).css('display', '')
                        $('#systemCodeTypeTable').DataTable().ajax.reload();
                        $('#systemCodeTypeForm').attr("method", "POST");
                        resetForm2($('#systemCodeInfoForm_clearBtn'));
                        loadTable2('');
                        $($('#systemCodeTypeForm')[0][1]).attr('readonly', false);
                        $("#formBtns button").eq(3).css('display', 'none');
                    }

                    $("#systemCodeTypeForm").submit(function(e) {

                        var form = $(this);
                        var url = form.attr('action');
                        var method = form.attr('method');

                        $.ajax({
                            type: method,
                            url: url,
                            data: form.serialize(), // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json.hasOwnProperty('error'))
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                                else {
                                    toastr.success("新增成功", "Success");
                                    //window.location.replace("measurementInfo.php?id=" + json.id);
                                }
                                resetForm();


                            }
                        });

                        e.preventDefault(); // avoid to execute the actual submit of the form.
                    });
                    $("#systemCodeInfoForm").submit(function(e) {

                        var form = $(this);
                        var url = form.attr('action');
                        var method = form.attr('method');

                        $.ajax({
                            type: method,
                            url: url,
                            data: form.serialize(), // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json.hasOwnProperty('error'))
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                                else {
                                    toastr.success("新增成功", "Success");

                                }
                                $('#systemCodeInfoTable').DataTable().ajax.reload();

                                resetForm2($('#systemCodeInfoForm_clearBtn'));
                                /* $('#systemCodeInfoForm').trigger("reset");
                                 $('#systemCodeInfoForm').attr("method", "POST");
                                 $($("#form2Btns").children()[1]).css('display', 'none');
                                 $($("#form2Btns").children()[0]).css('display', '')*/

                            }
                        });

                        e.preventDefault(); // avoid to execute the actual submit of the form.
                    });


                    function deleteData(form, id) {
                        if (confirm('刪除資料？')) {
                            $.ajax({
                                type: "DELETE",
                                url: "/clothes/ajax/manage_ajax.php",
                                data: {
                                    form: form,
                                    CT_No: id
                                },
                                dataType: "json",
                                success: function(json) {

                                    if (json['status'] === "success") {
                                        toastr.success("刪除成功", "Success");
                                        resetForm();
                                        $('#systemCodeTypeTable').DataTable().ajax.reload();
                                    } else
                                        toastr.error(json.error, "ERROR"); // show response from the php script.

                                }
                            });
                        }

                    }

                    function deleteData2(form, id1, id2) {
                        if (confirm('刪除資料？')) {
                            $.ajax({
                                type: "DELETE",
                                url: "/clothes/ajax/manage_ajax.php",
                                data: {
                                    form: form,
                                    CT_No: id1,
                                    CI_No: id2
                                },
                                dataType: "json",
                                success: function(json) {

                                    if (json['status'] === "success") {
                                        toastr.success("刪除成功", "Success");
                                        resetForm2();
                                        $('#systemCodeInfoTable').DataTable().ajax.reload();
                                    } else
                                        toastr.error(json.error, "ERROR"); // show response from the php script.

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