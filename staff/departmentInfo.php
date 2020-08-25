<?php
@require_once($_SERVER["DOCUMENT_ROOT"] . "/clothes/functions/functions.php");
if (isset($_GET['id'])) // 修改
{
    if (checkPermission(null, 'C01') < 3) {
        echo "<script>alert('無此權限');history.back();</script>";
        exit();
    }
} else // 新增 
{
    if (checkPermission(null, 'C01') < 2) {
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
                <a href="/clothes/staff/departmentManage.php" class="text-dark">部門資料維護</a> /
                <a href="/clothes/staff/departmentInfo.php" class="text-info">部門資料表</a>

            </div>
        </div>
    </section>

    <section>
        <div class="container" style="margin: 10px auto">
            <div class="shadow p-3 mb-5 bg-white rounded" style="padding:2.5rem!important">
                <h1>部門資料表</h1>
                <hr>
                <form id="departmentForm" action="/clothes/ajax/manage_ajax.php" method="POST" style="margin:auto;width:90%">
                    <input type="text" name="form" value="department" style="display:none" />
                    <div style="width:max-content;margin:auto">
                        <div class="form-group row" style="justify-content: center;">
                            <label for="Dep_Num" style="margin:auto 5px;width:100px;" class=" col-form-label">部門編號</label>
                            <input type="text" class="form-control" style="max-width: 200px;margin-left:5px" pattern="D[\d]{3}" name="Dep_Num" placeholder="D000" required>
                        </div>
                        <div class="form-group row" style="justify-content: center;">
                            <label for="Dep_Name" style="margin:auto 5px;width:100px;" class=" col-form-label">部門名稱</label>
                            <input type="text" class="form-control" style="max-width: 200px;margin-left:5px" name="Dep_Name" required>
                        </div>
                        <div class="form-group row" style="justify-content: center;">
                            <label for="Dep_Supr" style="margin:auto 5px;width:100px;" class=" col-form-label">部門主管</label>
                            <select class="form-control" style="max-width: 200px;margin-left:5px" name="Dep_Supr" required>
                                <option hidden disabled selected></option>
                            </select>
                        </div>
                        <div class="form-group row" style="justify-content: center;">
                            <label for="Addtime" style="margin:auto 5px;width:100px;" class=" col-form-label">建檔時間</label>
                            <input type="text" class="form-control" style="max-width: 200px;margin-left:5px" name="Addtime" disabled>
                        </div>
                    </div>
                    <input type="text" name="Bran_num" value="<?php echo @$_GET['bran']; ?>" style="display:none" />
                    <div style="width:max-content;margin:auto">

                        <?php
                        if (isset($_GET['id'])) {
                            echo "<button style=\"margin:auto 5px\" type=\"submit\" class=\"btn btn-success\">更新</button>";
                        } else
                            echo "<button style=\"margin:auto 5px\" type=\"submit\" class=\"btn btn-success\">新增</button>";

                        ?>

                        <button style="margin:auto 5px" type="button" class="btn btn-danger" onclick="history.back();">取消</button>
                    </div>
                </form>

                <script>
                    $.ajax({
                        type: 'GET',
                        url: '/clothes/ajax/manage_ajax.php',
                        data: {
                            form: "employee"
                        }, // serializes the form's elements.
                        dataType: "json",
                        success: function(json) {
                            if (json.hasOwnProperty('status') && json['status'] === "success") {
                                for (i = 0; i < json['data'].length; i++) {
                                    $("#departmentForm select[name='Dep_Supr']").append($("<option></option>").attr("value", json['data'][i]['Emp_Num']).text(json['data'][i]['Emp_Name']));
                                }
                            } else
                                toastr.error(json.error, "ERROR"); // show response from the php script.

                        }
                    });
                    $("#departmentForm").submit(function(e) {

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
                                    window.location.replace("departmentManage.php");
                                } else
                                    toastr.error(json.error, "ERROR"); // show response from the php script.

                            }
                        });

                        e.preventDefault(); // avoid to execute the actual submit of the form.
                    });

                    function initialInfo(id) {
                        $('form').attr('method', "PUT");
                        $("#departmentForm input[name='Dep_Num']").attr('readonly', 'true');
                        $.ajax({
                            type: "GET",
                            url: "/clothes/ajax/manage_ajax.php",
                            data: {
                                form: "department",
                                id: id
                            }, // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json.hasOwnProperty('status') && json['status'] === 'success') {
                                    if (json['data'].length === 0) {
                                        alert("此部門不存在!");
                                        history.go(-1);
                                    } else {
                                        $("#departmentForm input[name='Dep_Num']").val(json['data'][0].Dep_Num);
                                        $("#departmentForm input[name='Dep_Name']").val(json['data'][0].Dep_Name);
                                        $("#departmentForm select[name='Dep_Supr']").val(json['data'][0].Dep_Supr);
                                        $("#departmentForm input[name='Addtime']").val(json['data'][0].Addtime);
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
                                $(".container").find("h1").eq(0).text("部門資料表 - 修改");
                                initialInfo(pair[1]);
                                return;
                            }
                        }
                        $(".container").find("h1").eq(0).text("部門資料表 - 新增");
                    })
                </script>

            </div>
        </div>
    </section>
</body>

</html>