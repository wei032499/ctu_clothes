<?php
@require_once($_SERVER["DOCUMENT_ROOT"] . "/clothes/functions/functions.php");
if (isset($_GET['id'])) // 修改
{
    if (checkPermission(null, 'C02') < 3) {
        echo "<script>alert('無此權限');history.back();</script>";
        exit();
    }
} else // 新增 
{
    if (checkPermission(null, 'C02') < 2) {
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
            $("nav li").eq(3).addClass("active");
        });
    </script>
    <section>
        <div class="container" style="margin: 20px auto">
            <div class="shadow bg-white " style="padding:0.15rem 1rem!important">
                <a href="/clothes/" class="text-dark">首頁</a> /
                <a href="/clothes/staff/" class="text-dark">人事薪資管理</a> /
                <a href="/clothes/staff/employeeManage.php" class="text-dark">員工資料維護</a> /
                <a href="/clothes/customer/employeetInfo.php" class="text-info">員工資料表</a>
            </div>
        </div>
    </section>
    <section>
        <div class="container" style="margin: 10px auto">
            <div class="shadow p-3 mb-5 bg-white rounded" style="padding:2.5rem!important">
                <h1>員工資料表</h1>
                <hr>
                <form id="employeeForm" action="/clothes/ajax/manage_ajax.php" method="post" style="width:100%;margin:auto">
                    <input type="text" name="form" value="employee" style="display:none" />
                    <div class="form-group row" style="justify-content: center;">
                        <label for="Emp_Num" style="margin-right:5px;width:100px;" class=" col-form-label">員工編號</label>
                        <input size="10" pattern="E[\d]{9}" type="text" class="form-control" style="max-width: 200px;margin-left:5px" name="Emp_Num" readonly>
                    </div>
                    <div class="form-group row" style="justify-content: center;">
                        <label for="Emp_Name" style="margin-right:5px;width:100px;" class=" col-form-label">員工姓名</label>
                        <input type="text" class="form-control" style="max-width: 200px;margin-left:5px" name="Emp_Name" required>
                    </div>
                    <div class="form-group row" style="justify-content: center;">
                        <label for="Emp_ID" style="margin-right:5px;width:100px;" class=" col-form-label">身份證字號</label>
                        <input size="10" pattern="[a-zA-Z]{1}[\d]{9}" type="text" class="form-control" style="max-width: 200px;margin-left:5px" name="Emp_ID" required>
                    </div>
                    <div class="form-group row" style="justify-content: center;">
                        <label for="Emp_Addr" style="margin-right:5px;width:100px;" class=" col-form-label">住址</label>
                        <textarea class="form-control" style="max-width: 200px;margin-left:5px" name="Emp_Addr" required></textarea>
                    </div>
                    <div class="form-group row" style="justify-content: center;">
                        <label for="Emp_Tel" style="margin-right:5px;width:100px;" class=" col-form-label">住家電話</label>
                        <input type="text" pattern="[\d|-]+" class="form-control" style="max-width: 200px;margin-left:5px" name="Emp_Tel">
                    </div>
                    <div class="form-group row" style="justify-content: center;">
                        <label for="Emp_Mobile" style="margin-right:5px;width:100px;" class=" col-form-label">手機</label>
                        <input type="text" pattern="[\d|-]+" class="form-control" style="max-width: 200px;margin-left:5px" name="Emp_Mobile" required>
                    </div>
                    <hr />
                    <div class="form-group row" style="justify-content: center;">
                        <label for="Dep_Num" style="margin-right:5px;width:100px;" class=" col-form-label">所屬部門</label>
                        <select class="form-control" style="max-width: 200px;margin-left:5px" name="Dep_Num" required>
                            <option hidden disabled selected></option>
                        </select>
                    </div>
                    <div class="form-group row" style="justify-content: center;">
                        <label for="Bran_Num" style="margin-right:5px;width:100px;" class=" col-form-label">上班分店</label>
                        <select class="form-control" style="max-width: 200px;margin-left:5px" name="Bran_Num" required>
                            <option hidden disabled selected></option>
                        </select>
                    </div>
                    <div class="form-group row" style="justify-content: center;">
                        <label for="Emp_Role" style="margin-right:5px;width:100px;" class=" col-form-label">角色</label>
                        <select class="form-control" style="max-width: 200px;margin-left:5px" name="Emp_Role" required>
                            <option hidden disabled selected></option>
                        </select>
                    </div>
                    <div class="form-group row" style="justify-content: center;">
                        <label for="Emp_Level" style="margin-right:5px;width:100px;" class=" col-form-label">薪級</label>
                        <select class="form-control" style="max-width: 200px;margin-left:5px" name="Emp_Level" required>
                            <option hidden disabled selected></option>
                        </select>
                    </div>
                    <div class="form-group row" style="justify-content: center;">
                        <label for="Emp_Start" style="margin-right:5px;width:100px;" class="col-form-label">到職日</label>
                        <input type="date" class="form-control" style="max-width: 200px;margin-left:5px" name="Emp_Start" required>
                    </div>
                    <div class="form-group row" style="justify-content: center;">
                        <label for="Emp_Invalid" style="margin-right:5px;width:100px;" class="col-form-label">權限失效日</label>
                        <input type="date" class="form-control" style="max-width: 200px;margin-left:5px" name="Emp_Invalid">
                    </div>
                    <div class="form-group row" style="justify-content: center;">
                        <label for="Emp_PSW" style="margin-right:5px;width:100px;" class=" col-form-label">密碼</label>
                        <input type="password" class="form-control" style="max-width: 200px;margin-left:5px" name="Emp_PSW" required>
                    </div>
                    <div class="form-group row" style="justify-content: center;">
                        <label for="" style="margin-right:5px;width:100px;" class=" col-form-label">密碼確認</label>
                        <input type="password" class="form-control" style="max-width: 200px;margin-left:5px" name="" id="Emp_PSW_Check" required>
                    </div>
                    <div id="editBtn" class="form-group row" style="justify-content: center;display:none">
                        <button type="button" class="btn btn-warning" onclick="editPSW();">修改密碼</button>
                    </div>
                    <script>
                        function editPSW() {
                            $("#employeeForm input[name='Emp_PSW']").removeAttr('disabled');
                            $("#Emp_PSW_Check").removeAttr('disabled');
                            $("#editBtn").css('display', 'none');
                        }
                    </script>
                    <div class="form-group row" style="justify-content: center;">
                        <label for="Addtime" style="margin-right:5px;width:100px;" class=" col-form-label">建檔時間</label>
                        <input type="text" class="form-control" style="max-width: 200px;margin-left:5px" name="Addtime" disabled>
                    </div>
                    <div class="form-group row" style="justify-content: center;">
                        <button style="margin:auto 5px auto auto" type="submit" class="btn btn-success">新增</button>
                        <button style="margin:auto auto auto 5px" type="button" class="btn btn-danger" onclick="history.back();">取消</button>
                    </div>
                </form>
                <script>
                    $.ajax({
                        type: 'GET',
                        url: '/clothes/ajax/manage_ajax.php',
                        data: {
                            form: "department"
                        }, // serializes the form's elements.
                        dataType: "json",
                        success: function(json) {
                            if (json.hasOwnProperty('status') && json['status'] === "success") {
                                for (i = 0; i < json['data'].length; i++) {
                                    $("#employeeForm select[name='Dep_Num']").append($("<option></option>").attr("value", json['data'][i]['Dep_Num']).text(json['data'][i]['Dep_Name']));
                                }
                            } else
                                toastr.error(json.error, "ERROR"); // show response from the php script.

                        }
                    });
                    $.ajax({
                        type: 'GET',
                        url: '/clothes/ajax/manage_ajax.php',
                        data: {
                            form: "branch"
                        }, // serializes the form's elements.
                        dataType: "json",
                        success: function(json) {
                            if (json.hasOwnProperty('status') && json['status'] === "success") {
                                for (i = 0; i < json['data'].length; i++) {
                                    $("#employeeForm select[name='Bran_Num']").append($("<option></option>").attr("value", json['data'][i]['Bran_Num']).text(json['data'][i]['Bran_Name']));
                                }
                            } else
                                toastr.error(json.error, "ERROR"); // show response from the php script.
                        }
                    });
                    $.ajax({
                        type: 'GET',
                        url: '/clothes/ajax/manage_ajax.php',
                        data: {
                            form: "sysoprole"
                        }, // serializes the form's elements.
                        dataType: "json",
                        success: function(json) {
                            if (json.hasOwnProperty('status') && json['status'] === "success") {
                                for (i = 0; i < json['data'].length; i++) {
                                    $("#employeeForm select[name='Emp_Role']").append($("<option></option>").attr("value", json['data'][i]['Or_No']).text(json['data'][i]['Or_Name']));
                                }
                            } else
                                toastr.error(json.error, "ERROR"); // show response from the php script.
                        }
                    });
                    $.ajax({
                        type: 'GET',
                        url: '/clothes/ajax/manage_ajax.php',
                        data: {
                            form: "syscodeinfo",
                            CT_No: "C05"
                        }, // serializes the form's elements.
                        dataType: "json",
                        success: function(json) {
                            if (json.hasOwnProperty('status') && json['status'] === "success") {
                                for (i = 0; i < json['data'].length; i++) {
                                    $("#employeeForm select[name='Emp_Level']").append($("<option></option>").attr("value", json['data'][i]['CI_No']).text(json['data'][i]['CI_Name']));
                                }
                            } else
                                toastr.error(json.error, "ERROR"); // show response from the php script.
                        }
                    });
                    $("#employeeForm").submit(function(e) {

                        if ($("#Emp_PSW_Check").val() !== $("#employeeForm input[name='Emp_PSW']").val()) {
                            $("#employeeForm input[name='Emp_PSW']").val('');
                            $("#Emp_PSW_Check").val('');
                            return false;
                        }


                        $.ajax({
                            type: $(this).attr('method'),
                            url: $(this).attr('action'),
                            data: $(this).serialize(), // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json.hasOwnProperty('status') && json['status'] === "success") {
                                    toastr.success("新增成功", "Success");
                                    window.location.replace("employeeManage.php");
                                } else {
                                    toastr.error(json['error'], "ERROR"); // show response from the php script.
                                }

                            }
                        });

                        e.preventDefault(); // avoid to execute the actual submit of the form.
                    });



                    function initialInfo(id) {
                        $('form').attr('method', "PUT");
                        $("#employeeForm input[name='Emp_PSW']").attr('disabled', 'true');
                        $("#Emp_PSW_Check").attr('disabled', 'true');
                        $("#editBtn").css('display', '');
                        $("#employeeForm button[type='submit']").text('更新');
                        $.ajax({
                            type: "GET",
                            url: "/clothes/ajax/manage_ajax.php",
                            data: {
                                form: "employee",
                                id: id
                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json.hasOwnProperty('status') && json['status'] === 'success') {
                                    if (json['data'].length === 0) {
                                        alert("此員工不存在!");
                                        history.go(-1);
                                    } else {
                                        $('form')[0][1].value = json['data'][0].Emp_Num;
                                        $('form')[0][2].value = json['data'][0].Emp_Name;
                                        $('form')[0][3].value = json['data'][0].Emp_ID;
                                        $('form')[0][4].value = json['data'][0].Emp_Addr;
                                        $('form')[0][5].value = json['data'][0].Emp_Tel;
                                        $('form')[0][6].value = json['data'][0].Emp_Mobile;
                                        $('form')[0][7].value = json['data'][0].Dep_Num;
                                        $('form')[0][8].value = json['data'][0].Bran_Num;
                                        $('form')[0][9].value = json['data'][0].Emp_Role;
                                        $('form')[0][10].value = json['data'][0].Emp_Level;
                                        $('form')[0][11].value = json['data'][0].Emp_Start;
                                        $('form')[0][12].value = json['data'][0].Emp_Invalid;
                                        $("#employeeForm input[name='Addtime']").val(json['data'][0].Addtime);

                                    }
                                } else {
                                    toastr.error(json.error, "ERROR"); // show response from the php script.
                                    alert(json.error);
                                    history.go(-1);

                                }



                            }
                        });

                    }
                    $(function() {
                        url = new URL(window.location.href);
                        for (pair of url.searchParams.entries()) {
                            if (pair[0] == 'id') {
                                $(".container").find("h1").eq(0).text("員工資料表 - 修改");
                                initialInfo(pair[1]);
                                return;
                            }
                        }
                        $(".container").find("h1").eq(0).text("員工資料表 - 新增");
                    })
                </script>

            </div>
        </div>
    </section>
</body>

</html>