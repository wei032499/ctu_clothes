<?php
@require_once($_SERVER["DOCUMENT_ROOT"] . "/clothes/functions/functions.php");
$permission = checkPermission(null, 'B04');
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
                <a href="/clothes/inventory/stockManage.php" class="text-info">用料庫存查詢</a>
            </div>
        </div>
    </section>
    <section>
        <div class="container" style="margin: 10px auto">
            <div class="shadow p-3 mb-5 bg-white rounded" style="padding:2.5rem!important">
                <h1>用料庫存查詢</h1>
                <hr>
                <div class="border row" style="margin: 10px auto;padding-top:10px;padding-bottom:10px" id="searchBox">
                    <div class="row col-sm" style="margin:10px auto">
                        <label for="" class="col-form-label" style="width: 100px;">用料小類：</label>
                        <div class="col-sm" style="min-width: 150px;">
                            <input type="text" class="form-control" id="" placeholder="用料小類">
                        </div>
                    </div>
                    <div class="row col-sm" style="margin:10px auto">
                        <label for="" class="col-form-label" style="width: 100px;">用料名稱：</label>
                        <div class="col-sm" style="min-width: 150px;">
                            <input type="text" class="form-control" id="" placeholder="用料名稱">
                        </div>
                    </div>
                    <div class="row col-sm" style="margin:10px auto">
                        <label for="" class="col-form-label" style="width: 100px;">庫存日期：</label>
                        <div class="col-sm" style="min-width: 150px;">
                            <input type="date" class="form-control col-sm" id="">
                        </div>
                    </div>
                    <div class="row col-sm" style="margin:10px auto;justify-content:center;min-width: 200px;">
                        <button type="button" class="btn btn-success" style="white-space:nowrap;margin:auto 3px" onclick="search();">查詢</button>
                        <button type="button" class="btn btn-warning" style="white-space:nowrap;margin:auto 3px" onclick="resetSearch();">清除</button>
                    </div>
                </div>


                <table id="stockTable" class="table table-hover table-bordered" style="margin:5px auto">
                    <thead>
                        <tr>
                            <th>用料編號</th>
                            <th>用料名稱</th>
                            <th>庫存日期</th>
                            <th>前日結餘</th>
                            <th>當日進貨</th>
                            <th>當日出貨</th>
                            <th>當日庫存</th>
                            <th>庫存單位</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>

                </table>
                <script>
                    $(function() {
                        opt = {
                            "ajax": {
                                "url": "/clothes/ajax/manage_ajax.php",
                                "type": "GET",
                                "data": {
                                    form: "stock"
                                }
                            },
                            "columns": [{
                                    "data": "Mate_Num"
                                },
                                {
                                    "data": "Mate_Name"
                                },
                                {
                                    "data": "Stk_Date"
                                },
                                {
                                    "data": "Stk_Pre"
                                },
                                {
                                    "data": "Stk_In"
                                },
                                {
                                    "data": "Stk_Out"
                                },
                                {
                                    "data": "Stk_Qty"
                                },
                                {
                                    "data": "Unit_Name"
                                },
                                {
                                    "data": "Material_Type",
                                    "searchable": true,
                                    "visible": false
                                }, {
                                    "data": "Addtime",
                                    "searchable": true,
                                    "visible": false
                                }, {
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
                                //[10, "desc"],
                                [2, "desc"]
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
                        $('#stockTable').DataTable(opt);
                        $.fn.dataTable.ext.search.push(
                            function(settings, data, dataIndex) {

                                return $('#stockTable').DataTable().row(dataIndex).nodes().to$().attr('show') !== 'false';
                            }
                        );
                        $("#stockTable").wrap("<div style='overflow-x:auto'></div>");
                    });

                    function search() {
                        var arr = new Array();

                        order = $('#stockTable').DataTable().order()[0];

                        $('#stockTable').DataTable().order([
                            [2, "desc"]
                        ]);

                        $('#stockTable').DataTable().rows().every(function(rowIdx, tableLoop, rowLoop) {
                            var type = $('#searchBox input').eq(0).val();
                            var name = $('#searchBox input').eq(1).val();
                            var date = $('#searchBox input').eq(2).val();
                            var Stk_Date = new Date(this.data().Stk_Date);
                            if ((type == '' || this.data().Material_Type.includes(type)) &&
                                (name == '' || this.data().Mate_Name.includes(name)) &&
                                (date == '' || (Stk_Date <= new Date(date) && !arr.includes(this.data().Mate_Num)))) {
                                arr.push(this.data().Mate_Num);
                                this.nodes().to$().attr('show', 'true');
                            } else {
                                this.nodes().to$().attr('show', 'false');
                            }
                        });

                        $('#stockTable').DataTable().order([
                            order
                        ]);




                        $('#stockTable').DataTable().draw();


                    }






                    function resetSearch() {
                        $('#searchBox input').eq(0).val('');
                        $('#searchBox input').eq(1).val('');
                        $('#searchBox input').eq(2).val('');
                        search();
                    }
                </script>

            </div>
        </div>
    </section>
</body>

</html>