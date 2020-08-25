<nav class="navbar navbar-expand-lg navbar-light bg-light" style="box-shadow: 0 1px 2px 0 rgba(60,64,67,.3),0 2px 6px 2px rgba(60,64,67,.15);">
    <a class="navbar-brand" href="/clothes/">
        <img src="/clothes/images/icon.svg" width="50" height="50" class="d-inline-block align-top" alt="">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="/clothes/">首頁</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="/clothes/customer/" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    顧客訂單
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="/clothes/customer/">選單</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="/clothes/customer/orderManage.php">顧客訂單維護</a>
                    <a class="dropdown-item" href="/clothes/customer/customerManage.php">顧客基本資料維護</a>
                    <a class="dropdown-item" href="/clothes/customer/measurementManage.php">顧客量身資料維護</a>
                    <a class="dropdown-item" href="/clothes/customer/workingManage.php">訂單派工維護</a>
                    <a class="dropdown-item" href="/clothes/customer/mateusaManage.php">派工用料維護</a>
                    <a class="dropdown-item" href="/clothes/customer/orderStatusManage.php">訂單狀態維護</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="/clothes/inventory/" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    用料庫存
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="/clothes/inventory/">選單</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="/clothes/inventory/supplyManage.php">供應商資料維護</a>
                    <a class="dropdown-item" href="/clothes/inventory/materialManage.php">用料品項維護</a>
                    <a class="dropdown-item" href="/clothes/inventory/purchaseManage.php">用料進貨維護</a>
                    <a class="dropdown-item" href="/clothes/inventory/stockManage.php">用料庫存查詢</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="/clothes/staff/" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    人事薪資
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="/clothes/staff/">選單</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="/clothes/staff/departmentManage.php">部門資料維護</a>
                    <a class="dropdown-item" href="/clothes/staff/employeeManage.php">員工資料維護</a>
                    <!--<a class="dropdown-item" href="/clothes/staff/purchaseManage.php">薪資資料維護</a>-->
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="/clothes/branch/" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    分店管理
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="/clothes/branch/">選單</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="/clothes/branch/branchManage.php">分店基本資料維護</a>
                    <a class="dropdown-item" href="/clothes/branch/expenditureManage.php">分店費用報支維護</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="/clothes/pattern/" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    打版圖
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="/clothes/pattern/">選單</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="/clothes/pattern/prototypeManage.php">原型圖查詢</a>
                    <a class="dropdown-item" href="/clothes/pattern/customManage.php">客製圖查詢</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="/clothes/system/" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    系統維護
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="/clothes/system/">選單</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="/clothes/system/SysCode.php">系統代碼管理</a>
                    <a class="dropdown-item" href="/clothes/system/SysOpRole.php">系統使用權限</a>
                    <a class="dropdown-item" href="/clothes/system/SysOpLog.php">系統作業日誌</a>
                </div>
            </li>
        </ul>
    </div>
</nav>