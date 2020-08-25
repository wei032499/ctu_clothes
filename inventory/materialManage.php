<html>
<?php
@require_once($_SERVER["DOCUMENT_ROOT"] . "/clothes/functions/functions.php");
$permission = checkPermission(null, 'B02');
if ($permission < 1) {
    echo "<script>alert('無此權限');history.back();</script>";
    exit();
}



?>

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
                <a href="/clothes/inventory/materialManage.php" class="text-info">用料品項維護</a>
            </div>
        </div>
    </section>
    <section>
        <div class="container" style="margin: 10px auto">
            <div class="shadow p-3 mb-5 bg-white rounded" style="padding:2.5rem!important">
                <h1>用料品項維護</h1>
                <hr>
                <div class="border row" style="margin: 10px auto;padding-top:10px;padding-bottom:10px" id="searchBox">
                    <div class="row col-sm" style="margin:10px auto">
                        <label for="" class="col-form-label" style="width: 100px;">材料大類：</label>
                        <div class="col-sm" style="min-width: 200px;">
                            <select class="form-control" onchange="setSubSelect(this);">
                                <option selected></option>
                            </select>
                            <script>
                                function setSubSelect(obj) {
                                    index = $(obj).children('option:selected').val();
                                    $('#searchBox select').eq(1).empty().append('<option selected></option>');
                                    for (i = 0; i < CI_Array[index].length; i++)
                                        $('#searchBox select').eq(1).append($("<option></option>").attr("value", CI_Array[index][i]['CI_No']).text(CI_Array[index][i]['CI_Name']));

                                }
                            </script>
                        </div>
                    </div>
                    <div class="row col-sm" style="margin:10px auto">
                        <label for="" class="col-form-label" style="width: 100px;">材料小類：</label>
                        <div class="col-sm" style="min-width: 200px;">
                            <select class="form-control">
                                <option selected></option>
                            </select>
                        </div>
                    </div>
                    <div class="row col-sm" style="margin:10px auto">
                        <label for="" class="col-form-label" style="width: 100px;">用料名稱：</label>
                        <div class="col-sm" style="min-width: 200px;">
                            <input type="text" class="form-control" id="" placeholder="用料名稱">
                        </div>
                    </div>
                    <div class="row col-sm" style="margin:10px auto;justify-content:center;min-width: 200px;">
                        <button type="button" class="btn btn-success" style="white-space:nowrap;margin:auto 3px" onclick="search();">查詢</button>
                        <button type="button" class="btn btn-warning" style="white-space:nowrap;margin:auto 3px" onclick="resetSearch();">清除</button>
                        <button type="button" class="btn btn-primary" style="white-space:nowrap;margin:auto 3px" onclick="window.open('materialInfo.php','_self')">新增</button>
                    </div>
                </div>


                <table id="materialTable" class="table table-hover table-bordered" style="margin:5px auto">
                    <thead>
                        <tr>
                            <th>用料編號</th>
                            <th>用料名稱</th>
                            <th>預設供應商</th>
                            <th>安全存量</th>
                            <th>單位</th>
                            <th>修改/刪除</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>

                </table>
                <script>
                    var CI_Array = new Array();
                    $(function() {
                        var CT_No_Array = ['B01', 'B02', 'B03', 'B04', 'B05', 'B06'];

                        $.ajax({
                            type: 'GET',
                            url: '/clothes/ajax/manage_ajax.php',
                            data: {
                                form: "syscodeinfo",
                                CT_No: CT_No_Array[0]
                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json.hasOwnProperty('error'))
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                                else {
                                    CI_Array[CT_No_Array[0]] = json['data'];

                                }

                            }
                        });

                        $.ajax({
                            type: 'GET',
                            url: '/clothes/ajax/manage_ajax.php',
                            data: {
                                form: "syscodeinfo",
                                CT_No: CT_No_Array[1]
                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json.hasOwnProperty('error'))
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                                else {
                                    CI_Array[CT_No_Array[1]] = json['data'];

                                }

                            }
                        });

                        $.ajax({
                            type: 'GET',
                            url: '/clothes/ajax/manage_ajax.php',
                            data: {
                                form: "syscodeinfo",
                                CT_No: CT_No_Array[2]
                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json.hasOwnProperty('error'))
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                                else {
                                    CI_Array[CT_No_Array[2]] = json['data'];

                                }

                            }
                        });

                        $.ajax({
                            type: 'GET',
                            url: '/clothes/ajax/manage_ajax.php',
                            data: {
                                form: "syscodeinfo",
                                CT_No: CT_No_Array[3]
                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json.hasOwnProperty('error'))
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                                else {
                                    CI_Array[CT_No_Array[3]] = json['data'];

                                }

                            }
                        });

                        $.ajax({
                            type: 'GET',
                            url: '/clothes/ajax/manage_ajax.php',
                            data: {
                                form: "syscodeinfo",
                                CT_No: CT_No_Array[4]
                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json.hasOwnProperty('error'))
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                                else {
                                    CI_Array[CT_No_Array[4]] = json['data'];

                                }

                            }
                        });

                        $.ajax({
                            type: 'GET',
                            url: '/clothes/ajax/manage_ajax.php',
                            data: {
                                form: "syscodeinfo",
                                CT_No: CT_No_Array[5]
                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json.hasOwnProperty('error'))
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                                else {
                                    CI_Array[CT_No_Array[5]] = json['data'];

                                }

                            }
                        });


                        for (i = 0; i < 6; i++) {
                            $('#searchBox select').eq(0).append($("<option></option>").attr("value", CT_No_Array[i]));
                        }
                        $.ajax({
                            type: 'GET',
                            url: '/clothes/ajax/manage_ajax.php',
                            data: {
                                form: "syscodetype",
                                CT_No: CT_No_Array[0]
                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json.hasOwnProperty('error'))
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                                else {
                                    $('#searchBox select').eq(0).children("option").eq(1).text(json['data'][0].CT_Name);

                                }

                            }
                        });
                        $.ajax({
                            type: 'GET',
                            url: '/clothes/ajax/manage_ajax.php',
                            data: {
                                form: "syscodetype",
                                CT_No: CT_No_Array[1]
                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json.hasOwnProperty('error'))
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                                else {

                                    $('#searchBox select').eq(0).children("option").eq(2).text(json['data'][0].CT_Name);
                                }

                            }
                        });
                        $.ajax({
                            type: 'GET',
                            url: '/clothes/ajax/manage_ajax.php',
                            data: {
                                form: "syscodetype",
                                CT_No: CT_No_Array[2]
                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json.hasOwnProperty('error'))
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                                else {

                                    $('#searchBox select').eq(0).children("option").eq(3).text(json['data'][0].CT_Name);
                                }

                            }
                        });
                        $.ajax({
                            type: 'GET',
                            url: '/clothes/ajax/manage_ajax.php',
                            data: {
                                form: "syscodetype",
                                CT_No: CT_No_Array[3]
                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json.hasOwnProperty('error'))
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                                else {

                                    $('#searchBox select').eq(0).children("option").eq(4).text(json['data'][0].CT_Name);
                                }

                            }
                        });
                        $.ajax({
                            type: 'GET',
                            url: '/clothes/ajax/manage_ajax.php',
                            data: {
                                form: "syscodetype",
                                CT_No: CT_No_Array[4]
                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json.hasOwnProperty('error'))
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                                else {

                                    $('#searchBox select').eq(0).children("option").eq(5).text(json['data'][0].CT_Name);
                                }

                            }
                        });
                        $.ajax({
                            type: 'GET',
                            url: '/clothes/ajax/manage_ajax.php',
                            data: {
                                form: "syscodetype",
                                CT_No: CT_No_Array[5]
                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json.hasOwnProperty('error'))
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                                else {

                                    $('#searchBox select').eq(0).children("option").eq(6).text(json['data'][0].CT_Name);
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
                                    form: "material"
                                }
                            },
                            "columns": [{
                                    "data": "Mate_Num"
                                },
                                {
                                    "data": "Mate_Name"
                                },
                                {
                                    "data": "Supply_Name"
                                },
                                {
                                    "data": "Safe_Qty"
                                },
                                {
                                    "data": "Mate_Unit_Name"
                                },
                                {
                                    "render": function(data, type, row, meta) {
                                        data = "<button type=\"button\" class=\"btn btn-warning \" onclick=\"window.open('materialInfo.php?id=" + row.Mate_Num + "','_self');\" style=\"margin:1px\">修改</button>";
                                        data += "<button type=\"button\" class=\"btn btn-danger \" onclick=\"deleteData('material','" + row.Mate_Num + "')\" style=\"margin:1px\">刪除</button>";
                                        return data;
                                    }
                                },
                                {
                                    "data": "CT_No",
                                    "searchable": true,
                                    "visible": false
                                },
                                {
                                    "data": "CI_No",
                                    "searchable": true,
                                    "visible": false
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
                        $('#materialTable').DataTable(opt);
                        $("#materialTable").wrap("<div style='overflow-x:auto'></div>");
                    });

                    function search() {
                        $('#materialTable').DataTable().columns(1).search($('#searchBox input').eq(0).val());
                        $('#materialTable').DataTable().columns(6).search($('#searchBox select option:selected').eq(0).val());
                        $('#materialTable').DataTable().columns(7).search($('#searchBox select option:selected').eq(1).val());
                        $('#materialTable').DataTable().draw();

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

                                    if (json.hasOwnProperty('error'))
                                        toastr.error(json.error, "ERROR"); // show response from the php script.
                                    else {
                                        toastr.success("刪除成功", "Success");
                                    }
                                    $('#materialTable').DataTable().ajax.reload();

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