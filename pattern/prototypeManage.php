<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/clothes/functions/functions.php");
$permission  = checkPermission(null, 'E01');
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
                <a href="/clothes/pattern/" class="text-dark">打版圖管理</a> /
                <a href="/clothes/pattern/prototypeManage.php" class="text-info">原型圖查詢</a>
            </div>
        </div>
    </section>
    <section>
        <div class="container" style="margin: 10px auto">
            <div class="shadow p-3 mb-5 bg-white rounded" style="padding:2.5rem!important">
                <h1>原型圖查詢</h1>
                <hr />
                <div class="border " style="margin: 10px auto;padding:10px;overflow-x:hidden" id="searchBox">
                    <div class="row" style="margin: auto;width: 100%;">
                        <div class="row col-sm" style="margin:10px auto">
                            <label for="" class="col-form-label" style="width: 100px;">原型圖編號：</label>
                            <div class="col-sm" style="min-width: 200px;">
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row col-sm" style="margin:10px auto">
                            <label for="" class="col-form-label" style="width: 100px;">原型圖名稱：</label>
                            <div class="col-sm" style="min-width: 200px;">
                                <input type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row " style="margin:10px auto;justify-content:center;min-width: 200px;">
                        <button type="button" class="btn btn-success" style="white-space:nowrap;margin:auto 3px" onclick="search();">查詢</button>
                        <button type="button" class="btn btn-warning" style="white-space:nowrap;margin:auto 3px" onclick="resetSearch();">清除</button>
                    </div>
                </div>

                <table id="prototypeTable" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>原型圖編號</th>
                            <th>原型圖名稱</th>
                            <th>圖檔路徑</th>
                            <th>最後修改日期</th>
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
            opt_prototype = {
                "ajax": {
                    "url": "/clothes/ajax/manage_ajax.php",
                    "type": "GET",
                    "data": {
                        form: "prototype"
                    }
                },
                "columns": [{
                        "data": "ProtoM_Num"
                    },
                    {
                        "data": "ProtoM_Name"
                    },
                    {
                        "data": "ProtoM_Pho"
                    },
                    {
                        "data": "Chgtime",
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
                            else echo "null"; ?>
                }],
                "destroy": true,
                "bAutoWidth": false //solve width:0px
            }
            $('#prototypeTable').DataTable(opt_prototype).draw();
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var ProtoM_Num = $('#searchBox input').eq(0).val();
                    var ProtoM_Name = $('#searchBox input').eq(1).val();


                    if ((ProtoM_Num == '' || data[0].includes(ProtoM_Num)) &&
                        (ProtoM_Name == '' || data[1].includes(ProtoM_Name))) {
                        return true;
                    }
                    return false;

                }
            );

            $("#prototypeTable").wrap("<div style='overflow-x:auto'></div>");
        });

        function search() {
            $('#prototypeTable').DataTable().draw();
        }



        function resetSearch() {
            $('#searchBox input').eq(0).val('');
            $('#searchBox input').eq(1).val('');
            search();
        }
    </script>
</body>

</html>