<?php
session_start();
if (isset($_SESSION['Emp_Num']) && isset($_SESSION['role'])) {
    header("Location: /clothes/adminMenu.php");
    exit();
} else {
    session_destroy();
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
    <section>
        <div class="container" style="margin: 10px auto">
            <div class="shadow p-3 mb-5 bg-white rounded" style="padding:2.5rem!important">
                <h1>帳號登入</h1>
                <hr>
                <form id="loginForm" action="/clothes/ajax/login_ajax.php" style="margin:auto;width:max-content">
                    <input type="text" name="form" value="account" style="display:none" />
                    <div class="form-group row">
                        <label for="account" style="margin-right:5px" class=" col-form-label">帳號</label>
                        <input size="20" pattern="[A-Za-z0-9]+" type="text" class="form-control" style="max-width: 200px;margin-left:5px" name="account" required>
                    </div>
                    <div class="form-group row">
                        <label for="password" style="margin-right:5px" class=" col-form-label">密碼</label>
                        <input type="password" class="form-control" style="max-width: 200px;margin-left:5px" name="password" required>
                    </div>
                    <div id="message" style="margin: auto; width:max-content;color:red"></div>
                    <div class="form-group row">
                        <button style="margin:auto 5px auto auto" type="submit" class="btn btn-success">登入</button>
                        <button style="margin:auto auto auto 5px" type="reset" class="btn btn-warning">清除</button>
                    </div>
                </form>
                <script>
                    $("#loginForm").submit(function(e) {
                        $("#message").text("");

                        var form = $(this);
                        //$("#loginForm")[0][2].value = sha3_256($("#loginForm")[0][2].value);
                        var url = form.attr('action');

                        $.ajax({
                            type: "POST",
                            url: url,
                            data: form.serialize(), // serializes the form's elements.
                            dataType: "json",
                            success: function(json) {
                                if (json.hasOwnProperty('error')) {
                                    $("#loginForm")[0][2].value = "";
                                    toastr.error(json.error, "登入失敗"); // show response from the php script.
                                } else {
                                    toastr.success("登入成功", "Success");
                                    url = new URL(window.location.href);
                                    for (pair of url.searchParams.entries()) {
                                        if (pair[0] == 'redirect') {
                                            window.location.replace(pair[1]);
                                            return;
                                        }
                                    }
                                    console.log(json['data'][0].role);
                                    window.location.replace("adminMenu.php");
                                    switch (json['data'][0].role) {
                                        case 0:
                                            //window.location.replace("adminMenu.php");
                                            break;
                                        case 1:
                                            window.location.replace("adminMenu.php");
                                            break;
                                    }
                                }

                            }
                        });

                        e.preventDefault(); // avoid to execute the actual submit of the form.

                    });
                </script>

            </div>
        </div>
    </section>
</body>

</html>