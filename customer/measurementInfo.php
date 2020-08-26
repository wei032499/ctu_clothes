<?php
@require_once($_SERVER["DOCUMENT_ROOT"] . "/clothes/functions/functions.php");
if (isset($_GET['id'])) // 修改
{
    if (checkPermission(null, 'A03') < 1) {
        echo "<script>alert('無此權限');history.back();</script>";
        exit();
    }
} else // 新增 
{
    if (checkPermission(null, 'A03') < 2) {
        echo "<script>alert('無此權限');history.back();</script>";
        exit();
    }
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
                <a href="/clothes/customer/" class="text-dark">顧客訂單管理</a> /
                <a href="/clothes/customer/measurementManage.php" class="text-dark">顧客量身資料維護</a> /
                <a href="/clothes/customer/measurementInfo.php" class="text-info">顧客量身資料表</a>
            </div>
        </div>
    </section>
    <section>
        <div class="container" style="margin: 10px auto">
            <div class="shadow p-3 mb-5 bg-white rounded" style="padding:2.5rem!important">
                <h1>量身尺寸資料</h1>
                <hr>
                <form id="measurementForm" action="/clothes/ajax/manage_ajax.php" method="POST" style="margin:auto;">
                    <input type="text" name="form" value="measurement" style="display:none" />
                    <div class="row" style="justify-content: center;">
                        <div class="col-sm" style="margin:0px 30px;max-width:300px">
                            <div class="form-group row">
                                <div class="col" style="max-width: 100px;"><label for="Cust_Num" class=" col-form-label">顧客</label></div>
                                <div class="col row"><input type="text" class="form-control col-sm" style="margin: 2px;min-width:150px" name="Cust_Num" placeholder="顧客編號" required><input type="text" placeholder="顧客姓名" id="Cust_Name" class="form-control  col-sm readonly" style="pointer-events: none;margin:2px;min-width:150px" autocomplete="off" required></div>
                                <script>
                                    $(".readonly").keydown(function(e) {
                                        e.preventDefault();
                                    })
                                </script>
                            </div>
                            <div class="form-group row">
                                <div class="col" style="max-width: 100px;"><label for="BodyM_Date" class=" col-form-label">量身日期</label></div>
                                <div class="col"><input type="date" step="0.001" min="0" class="form-control" name="BodyM_Date" value="<?php echo date("Y-m-d"); ?>" required></div>
                            </div>
                        </div>
                        <div class="col-sm" style="margin:0px 30px;max-width:300px">
                            <div class="form-group row">
                                <div class="col" style="max-width: 100px;"><label for="Emp_Num" class=" col-form-label">量身人員</label></div>
                                <div class="col"><select class="form-control" name="Emp_Num" value="<?php echo $_SESSION['Emp_Num']; ?>" required></select></div>
                            </div>
                            <div class="form-group row">
                                <div class="col" style="max-width: 100px;"><label for="BodyM_Unit" class=" col-form-label">量身單位</label></div>
                                <div class="col"><select class="form-control" name="BodyM_Unit" required>
                                        <option hidden disabled selected></option>
                                    </select></div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="justify-content: center;">
                        <div class="col-sm" style="margin:0px 30px;max-width:200px">
                            <div class="form-group row">
                                <label for="BodyM_High" class=" col-form-label">身高</label>
                                <input type="number" step="0.001" min="0" class="form-control" name="BodyM_High" required>
                            </div>
                        </div>
                        <div class="col-sm" style="margin:0px 30px;max-width:200px">
                            <div class="form-group row">
                                <label for="BodyM_Weight" class=" col-form-label">體重</label>
                                <input type="number" step="0.001" min="0" class="form-control" name="BodyM_Weight" required>
                            </div>
                        </div>
                        <div class="col-sm" style="margin:0px 30px;max-width:200px">
                            <div class="form-group row">
                                <label for="BodyM_Cup" class=" col-form-label">罩杯</label>
                                <input type="text" class="form-control" name="BodyM_Cup" required>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="row" style="justify-content: center;">
                        <div class="col-sm" style="margin:0px 30px;max-width:200px">
                            <div class="form-group row">
                                <label for="BodyM_SW" class=" col-form-label">1.肩寛</label>
                                <input type="number" step="0.001" min="0" class="form-control" name="BodyM_SW" required>
                            </div>
                            <div class="form-group row">
                                <label for="BodyM_DFS" class=" col-form-label">2.前胸吊帶距</label>
                                <input type="number" step="0.001" min="0" class="form-control" name="BodyM_DFS" required>
                            </div>
                            <div class="form-group row">
                                <label for="BodyM_BH" class=" col-form-label">3.乳高</label>
                                <input type="number" step="0.001" min="0" class="form-control" name="BodyM_BH" required>
                            </div>
                            <div class="form-group row">
                                <label for="BodyM_BR" class=" col-form-label">4.乳深</label>
                                <input type="number" step="0.001" min="0" class="form-control" name="BodyM_BR" required>
                            </div>
                            <div class="form-group row">
                                <label for="BodyM_SBW" class=" col-form-label">5.單乳寬</label>
                                <input type="number" step="0.001" min="0" class="form-control" name="BodyM_SBW" required>
                            </div>
                            <div class="form-group row">
                                <label for="BodyM_FBW" class=" col-form-label">6.前胸寬</label>
                                <input type="number" step="0.001" min="0" class="form-control" name="BodyM_FBW" required>
                            </div>
                            <div class="form-group row">
                                <label for="BodyM_UpB" class=" col-form-label">7.胸上圍</label>
                                <input type="number" step="0.001" min="0" class="form-control" name="BodyM_UpB" required>
                            </div>
                            <div class="form-group row">
                                <label for="BodyM_B" class=" col-form-label">8.胸圍</label>
                                <input type="number" step="0.001" min="0" class="form-control" name="BodyM_B" required>
                            </div>
                            <div class="form-group row">
                                <label for="BodyM_UdB" class=" col-form-label">9.胸下圍</label>
                                <input type="number" step="0.001" min="0" class="form-control" name="BodyM_UdB" required>
                            </div>
                            <div class="form-group row">
                                <label for="BodyM_ArtoUdB" class=" col-form-label">10.腋下到胸下</label>
                                <input type="number" step="0.001" min="0" class="form-control" name="BodyM_ArtoUdB" required>
                            </div>
                        </div>
                        <div class="col-sm" style="margin:0px 30px;max-width:200px">
                            <div class="form-group row">
                                <label for="BodyM_ArtoW" class=" col-form-label">11.腋下到腰</label>
                                <input type="number" step="0.001" min="0" class="form-control" name="BodyM_ArtoW" required>
                            </div>
                            <div class="form-group row">
                                <label for="BodyM_ArtoT" class=" col-form-label">12.腋下到大腿</label>
                                <input type="number" step="0.001" min="0" class="form-control" name="BodyM_ArtoT" required>
                            </div>
                            <div class="form-group row">
                                <label for="BodyM_UdBtoW" class=" col-form-label">13.胸下到腰</label>
                                <input type="number" step="0.001" min="0" class="form-control" name="BodyM_UdBtoW" required>
                            </div>

                            <div class="form-group row">
                                <label for="BodyM_UdBtoT" class=" col-form-label">14.胸下到大腿</label>
                                <input type="number" step="0.001" min="0" class="form-control" name="BodyM_UdBtoT" required>
                            </div>
                            <div class="form-group row">
                                <label for="BodyM_W" class=" col-form-label">15.腰圍</label>
                                <input type="number" step="0.001" min="0" class="form-control" name="BodyM_W" required>
                            </div>
                            <div class="form-group row">
                                <label for="BodyM_AbH" class=" col-form-label">16.腹高</label>
                                <input type="number" step="0.001" min="0" class="form-control" name="BodyM_AbH" required>
                            </div>
                            <div class="form-group row">
                                <label for="BodyM_Ab" class=" col-form-label">17.腹圍</label>
                                <input type="number" step="0.001" min="0" class="form-control" name="BodyM_Ab" required>
                            </div>
                            <div class="form-group row">
                                <label for="BodyM_UdBtoY" class=" col-form-label">18.胸下到Y</label>
                                <input type="number" step="0.001" min="0" class="form-control" name="BodyM_UdBtoY" required>
                            </div>
                            <div class="form-group row">
                                <label for="BodyM_Hip" class=" col-form-label">19.臀圍</label>
                                <input type="number" step="0.001" min="0" class="form-control" name="BodyM_Hip" required>
                            </div>
                            <div class="form-group row">
                                <label for="BodyM_HL" class=" col-form-label">20.臀長</label>
                                <input type="number" step="0.001" min="0" class="form-control" name="BodyM_HL" required>
                            </div>
                        </div>
                        <div class="col-sm" style="margin:0px 30px;max-width:200px">
                            <div class="form-group row">
                                <label for="BodyM_WtoT" class=" col-form-label">21.平口側邊長</label>
                                <input type="number" step="0.001" min="0" class="form-control" name="BodyM_WtoT" required>
                            </div>
                            <div class="form-group row">
                                <label for="BodyM_OTS" class=" col-form-label">22.斜大腿圍</label>
                                <input type="number" step="0.001" min="0" class="form-control" name="BodyM_OTS" required>
                            </div>
                            <div class="form-group row">
                                <label for="BodyM_BL" class=" col-form-label">23.背長</label>
                                <input type="number" step="0.001" min="0" class="form-control" name="BodyM_BL" required>
                            </div>
                            <div class="form-group row">
                                <label for="BodyM_BW" class=" col-form-label">24.背寬</label>
                                <input type="number" step="0.001" min="0" class="form-control" name="BodyM_BW" required>
                            </div>
                            <div class="form-group row">
                                <label for="BodyM_CD" class=" col-form-label">25.股上長</label>
                                <input type="number" step="0.001" min="0" class="form-control" name="BodyM_CD" required>
                            </div>
                            <div class="form-group row">
                                <label for="BodyM_HLH" class=" col-form-label">26.提臀高</label>
                                <input type="number" step="0.001" min="0" class="form-control" name="BodyM_HLH" required>
                            </div>
                            <div class="form-group row">
                                <label for="BodyM_BHLH" class=" col-form-label">27.四角提臀高</label>
                                <input type="number" step="0.001" min="0" class="form-control" name="BodyM_BHLH" required>
                            </div>
                            <div class="form-group row">
                                <label for="BodyM_CL" class=" col-form-label">28.褲檔長</label>
                                <input type="number" step="0.001" min="0" class="form-control" name="BodyM_CL" required>
                            </div>
                            <div class="form-group row">
                                <label for="BodyM_UdBtoC" class=" col-form-label">29.總檔長</label>
                                <input type="number" step="0.001" min="0" class="form-control" name="BodyM_UdBtoC" required>
                            </div>
                            <div class="form-group row">
                                <label for="Cust_Memo" class=" col-form-label">備註</label>
                                <textarea class="form-control" name="Cust_Memo"></textarea>
                            </div>
                        </div>
                    </div>

                    <div style="width:max-content;margin:auto">
                        <button style="margin:auto 5px" type="submit" class="btn btn-success">新增</button>
                        <button style="margin:auto 5px" type="button" class="btn btn-danger" onclick="history.back();">取消</button>
                    </div>
                </form>
                <script>
                    $("#measurementForm").submit(function(e) {

                        var form = $(this);
                        var url = form.attr('action');
                        var method = form.attr('method');

                        $.ajax({
                            type: method,
                            url: url,
                            data: form.serialize(), // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json.hasOwnProperty('status') && json['status'] === "success") {
                                    toastr.success("新增成功", "Success");
                                    history.back();

                                } else
                                    toastr.error(json.error, "ERROR"); // show response from the php script.


                            }
                        });

                        e.preventDefault(); // avoid to execute the actual submit of the form.
                    });

                    $.when($.ajax({
                            type: "GET",
                            url: "/clothes/ajax/manage_ajax.php",
                            data: {
                                form: "customer"
                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json['status'] === 'success') {
                                    $("#measurementForm input[name='Cust_Num']").on('keyup', function(e) {
                                        objs = json['data'].filter(element => element.Cust_Num.includes($("#measurementForm input[name='Cust_Num']").val()));
                                        if (objs.length === 1) {
                                            /*$("#measurementForm input[name='Cust_Num']").blur();
                                            $("#measurementForm input[name='Cust_Num']").val(objs[0].Cust_Num);*/
                                            $("#Cust_Name").val(objs[0].Cust_Name);
                                        } else {
                                            $("#Cust_Name").val('');
                                        }
                                    });
                                    $("#measurementForm input[name='Cust_Num']").on('change', function(e) {
                                        objs = json['data'].filter(element => element.Cust_Num.includes($("#measurementForm input[name='Cust_Num']").val()));
                                        if (objs.length === 1) {
                                            $("#measurementForm input[name='Cust_Num']").blur();
                                            $("#measurementForm input[name='Cust_Num']").val(objs[0].Cust_Num);
                                            $("#Cust_Name").val(objs[0].Cust_Name);
                                        } else {
                                            $("#Cust_Name").val('');
                                        }
                                    });

                                } else {
                                    toastr.error(json.error, "ERROR"); // show response from the php script.

                                }

                            }
                        }),
                        $.ajax({
                            type: "GET",
                            url: "/clothes/ajax/manage_ajax.php",
                            data: {
                                form: "employee"
                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json['status'] === 'success') {
                                    json['data'].forEach(element => {
                                        $("#measurementForm select[name='Emp_Num']").append($("<option></option>").attr("value", element.Emp_Num).text(element.Emp_Num + "-" + element.Emp_Name));
                                    });

                                } else {
                                    toastr.error(json.error, "ERROR"); // show response from the php script.

                                }

                            }
                        }),
                        $.ajax({
                            type: 'GET',
                            url: '/clothes/ajax/manage_ajax.php',
                            data: {
                                form: 'syscodeinfo',
                                CT_No: 'B08'

                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json['status'] === "success") {
                                    json['data'].forEach(obj => {
                                        $("#measurementForm select[name='BodyM_Unit']").append($("<option></option>").attr("value", obj.CI_No).text(obj.CI_Name));
                                    });
                                } else
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                            }
                        })).done(function() {
                        var id = "",
                            date = "";
                        url = new URL(window.location.href);
                        for (pair of url.searchParams.entries()) {
                            if (pair[0] === 'id') {
                                id = pair[1];
                            } else if (pair[0] === 'date') {
                                date = pair[1];
                            }
                        }
                        if (id !== "" && date !== "") {
                            $(".container").find("h1").eq(0).text("量身尺寸資料 - 修改");
                            initialInfo(id, date);
                        } else if (id !== "") {
                            $(".container").find("h1").eq(0).text("量身尺寸資料 - 新增");
                            $("#measurementForm input[name='Cust_Num']").val(id).change();
                        } else
                            $(".container").find("h1").eq(0).text("量身尺寸資料 - 新增");


                    });

                    function initialInfo(id, date) {
                        $("#measurementForm button[type='submit']").text("更新");
                        $("#measurementForm input[name='Cust_Num']").attr('readonly', true);
                        $("#measurementForm input[name='BodyM_Date']").attr('readonly', true);
                        $("#measurementForm").attr('method', "PUT");

                        $.ajax({
                            type: "GET",
                            url: "/clothes/ajax/manage_ajax.php",
                            data: {
                                form: "measurement",
                                id: id,
                                date: date
                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json['status'] === 'success') {
                                    if (json['data'].length === 0) {
                                        alert("此顧客不存在!");
                                        history.back();
                                    } else {
                                        $("#measurementForm input[name='Cust_Num']").val(json['data'][0].Cust_Num).change();
                                        $("#measurementForm input[name='BodyM_Date']").val(json['data'][0].BodyM_Date);
                                        $("#measurementForm select[name='Emp_Num']").val(json['data'][0].Emp_Num);
                                        $("#measurementForm select[name='BodyM_Unit']").val(json['data'][0].BodyM_Unit);
                                        $("#measurementForm input[name='BodyM_High']").val(json['data'][0].BodyM_High);
                                        $("#measurementForm input[name='BodyM_Weight']").val(json['data'][0].BodyM_Weight);
                                        $("#measurementForm input[name='BodyM_Cup']").val(json['data'][0].BodyM_Cup);
                                        $("#measurementForm input[name='BodyM_SW']").val(json['data'][0].BodyM_SW);
                                        $("#measurementForm input[name='BodyM_DFS']").val(json['data'][0].BodyM_DFS);
                                        $("#measurementForm input[name='BodyM_BH']").val(json['data'][0].BodyM_BH);
                                        $("#measurementForm input[name='BodyM_BR']").val(json['data'][0].BodyM_BR);
                                        $("#measurementForm input[name='BodyM_SBW']").val(json['data'][0].BodyM_SBW);
                                        $("#measurementForm input[name='BodyM_FBW']").val(json['data'][0].BodyM_FBW);
                                        $("#measurementForm input[name='BodyM_UpB']").val(json['data'][0].BodyM_UpB);
                                        $("#measurementForm input[name='BodyM_B']").val(json['data'][0].BodyM_B);
                                        $("#measurementForm input[name='BodyM_UdB']").val(json['data'][0].BodyM_UdB);
                                        $("#measurementForm input[name='BodyM_ArtoUdB']").val(json['data'][0].BodyM_ArtoUdB);
                                        $("#measurementForm input[name='BodyM_ArtoW']").val(json['data'][0].BodyM_ArtoW);
                                        $("#measurementForm input[name='BodyM_ArtoT']").val(json['data'][0].BodyM_ArtoT);
                                        $("#measurementForm input[name='BodyM_UdBtoW']").val(json['data'][0].BodyM_UdBtoW);
                                        $("#measurementForm input[name='BodyM_UdBtoT']").val(json['data'][0].BodyM_UdBtoT);
                                        $("#measurementForm input[name='BodyM_W']").val(json['data'][0].BodyM_W);
                                        $("#measurementForm input[name='BodyM_AbH']").val(json['data'][0].BodyM_AbH);
                                        $("#measurementForm input[name='BodyM_Ab']").val(json['data'][0].BodyM_Ab);
                                        $("#measurementForm input[name='BodyM_UdBtoY']").val(json['data'][0].BodyM_UdBtoY);
                                        $("#measurementForm input[name='BodyM_Hip']").val(json['data'][0].BodyM_Hip);
                                        $("#measurementForm input[name='BodyM_HL']").val(json['data'][0].BodyM_HL);
                                        $("#measurementForm input[name='BodyM_WtoT']").val(json['data'][0].BodyM_WtoT);
                                        $("#measurementForm input[name='BodyM_OTS']").val(json['data'][0].BodyM_OTS);
                                        $("#measurementForm input[name='BodyM_BL']").val(json['data'][0].BodyM_BL);
                                        $("#measurementForm input[name='BodyM_BW']").val(json['data'][0].BodyM_BW);
                                        $("#measurementForm input[name='BodyM_CD']").val(json['data'][0].BodyM_CD);
                                        $("#measurementForm input[name='BodyM_HLH']").val(json['data'][0].BodyM_HLH);
                                        $("#measurementForm input[name='BodyM_BHLH']").val(json['data'][0].BodyM_BHLH);
                                        $("#measurementForm input[name='BodyM_CL']").val(json['data'][0].BodyM_CL);
                                        $("#measurementForm input[name='BodyM_UdBtoC']").val(json['data'][0].BodyM_UdBtoC);
                                        $("#measurementForm textarea[name='Cust_Memo']").val(json['data'][0].Cust_Memo);
                                    }
                                } else {
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                                    alert(json.error);
                                    history.back();

                                }



                            }
                        });


                    }
                </script>

            </div>
        </div>
    </section>
</body>

</html>