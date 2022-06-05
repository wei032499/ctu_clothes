<?php
session_start();
require_once($_SERVER["DOCUMENT_ROOT"] . "/clothes/ajax/DB.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/clothes/functions/functions.php");






set_error_handler('exceptions_error_handler');

function exceptions_error_handler($severity, $message, $filename, $lineno)
{
    if (error_reporting() == 0) {
        return;
    }
    if (error_reporting() & $severity) {
        throw new ErrorException($message, 0, $severity, $filename, $lineno);
    }
}
$conn = null;
try {
    if (!isset($_SESSION['Emp_Num']) || !isset($_SESSION['role'])) {
        session_destroy();
        throw new Exception("未登入");
    } else if (isset($_GET['form']) || isset($_POST['form']) || $_SERVER['REQUEST_METHOD'] === 'PUT' || $_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $conn = new mysqli($servername, $username, $password, $dbname); // Create connection

        $conn->autocommit(FALSE);
        $result['status'] = "success";
        $result['data'] = array();


        if ($conn->connect_error) // Check connection
        {
            die("Connection failed: " . $conn->connect_error);
        }
        $conn->query('SET CHARACTER SET utf8');
        $conn->query("SET collation_connection = 'utf8mb4_unicode_ci'");
        date_default_timezone_set("Asia/Taipei");
        if ($_SERVER['REQUEST_METHOD'] === 'GET') //get
        {
            if ($_GET['form'] == "logout") {
                session_destroy();
                header("Location: /clothes/");
            } else if ($_GET['form'] == "order") {
                if (true || checkPermission(null, 'A01') >= 1) {

                    $sql = "SELECT A.*,B.Cust_Name,B.Cust_Tel,B.Cust_Mobile,C.CI_Name as OrderStatus_Name  FROM custorder A 
                            LEFT OUTER JOIN customer B ON (A.Cust_Num = B.Cust_Num)
                            LEFT OUTER JOIN syscodeinfo C ON (C.CT_No = A.OrderStatus_CT AND C.CI_No = A.OrderStatus)
                            WHERE 1 ";


                    $paramList = array();
                    if (isset($_GET['id']) && $_GET['id'] !== null) {
                        $sql .= " AND A.Order_Num = ? ";
                        $paramList[] =  $_GET['id'];
                    }
                    if (isset($_GET['OrderStatus']) && $_GET['OrderStatus'] !== null) {
                        $sql .= " AND A.OrderStatus = ? ";
                        $paramList[] =  $_GET['OrderStatus'];
                    }

                    if (isset($_GET['limit']) && $_GET['limit'] !== null) {
                        $sql .= " LIMIT ? ";
                        $limit = $_GET['limit'];
                        $paramList[] =  $limit;
                    }
                    $stmt = $conn->prepare($sql);
                    DynamicBindVariables($stmt, $paramList);

                    if (!$stmt->execute())
                        throw new Exception($stmt->error);
                    $SQLresult = $stmt->get_result();

                    while ($row = $SQLresult->fetch_assoc())
                        $result['data'][] = $row;
                    $stmt->close();
                } else
                    throw new Exception("A01 權限不足");
            } else if ($_GET['form'] == "orderitem") {
                if (true || checkPermission(null, 'A01') >= 1) {

                    $sql = "SELECT * FROM `orderitem` WHERE 1 ";


                    $paramList = array();
                    if (isset($_GET['id']) && $_GET['id'] !== null) {
                        $sql .= " AND Order_Num = ? ";
                        $paramList[] =  $_GET['id'];
                    }
                    if (isset($_GET['Order_Num']) && $_GET['Order_Num'] !== null) {
                        $sql .= " AND Order_Num = ? ";
                        $paramList[] =  $_GET['Order_Num'];
                    }
                    if (isset($_GET['Item_Num']) && $_GET['Item_Num'] !== null) {
                        $sql .= " AND Item_Num = ? ";
                        $paramList[] =  $_GET['Item_Num'];
                    }

                    if (isset($_GET['limit']) && $_GET['limit'] !== null) {
                        $sql .= " LIMIT ? ";
                        $limit = $_GET['limit'];
                        $paramList[] =  $limit;
                    }
                    $stmt = $conn->prepare($sql);
                    DynamicBindVariables($stmt, $paramList);

                    if (!$stmt->execute())
                        throw new Exception($stmt->error);
                    $SQLresult = $stmt->get_result();

                    while ($row = $SQLresult->fetch_assoc())
                        $result['data'][] = $row;
                    $stmt->close();
                } else
                    throw new Exception("A01 權限不足");
            } else if ($_GET['form'] == "customer") {
                if (true || checkPermission(null, 'A02') >= 1) {

                    $sql = "SELECT A.*,B.Bran_Name,C.Or_No FROM `customer` A
                            LEFT OUTER JOIN `sysoprolebranch` C ON (C.Or_No = ? AND A.Bran_Num = C.Bran_Num)
                            LEFT OUTER JOIN `branch` B ON (A.Bran_Num = B.Bran_Num)
                            WHERE 1 ";

                    $paramList = array();
                    $paramList[] =  $_SESSION['role'];
                    if (isset($_GET['id']) && $_GET['id'] !== null) {
                        $sql .= " AND A.Cust_Num = ? ";
                        $paramList[] =  $_GET['id'];
                    }



                    if (isset($_GET['limit']) && $_GET['limit'] !== null) {
                        $sql .= " LIMIT ? ";
                        $limit = $_GET['limit'];
                        $paramList[] =  $limit;
                    }
                    $stmt = $conn->prepare($sql);
                    DynamicBindVariables($stmt, $paramList);

                    if (!$stmt->execute())
                        throw new Exception($stmt->error);
                    $SQLresult = $stmt->get_result();

                    while ($row = $SQLresult->fetch_assoc())
                        if ($_SESSION['role'] === '000' || $row['Or_No'] !== NULL)
                            $result['data'][] = $row;
                    $stmt->close();
                } else
                    throw new Exception("A02 權限不足");
            } else if ($_GET['form'] == "measurement") {
                if (true || checkPermission(null, 'A03') >= 1) {

                    $sql = "SELECT A.*,B.Cust_Name,B.Cust_Tel,B.Cust_Mobile,C.Emp_Name,IFNULL(D.Order_Count,0) as Order_Count ,E.CI_Name as Unit_Name, F.Bran_Name FROM custmeasure A 
                            LEFT OUTER JOIN customer B ON (A.Cust_Num = B.Cust_Num)
                            LEFT OUTER JOIN employee C ON (A.Emp_Num = C.Emp_Num)
                            LEFT OUTER JOIN (SELECT *,COUNT(*) as Order_Count FROM `custorder` WHERE OrderCancel=0  group by `Cust_Num`,`Order_Date`) D ON (A.Cust_Num = D.Cust_Num AND A.BodyM_Date = D.BodyM_Date)
                            LEFT OUTER JOIN syscodeinfo E ON (A.Unit_CT = E.CT_No AND A.BodyM_Unit = E.CI_No)
                            LEFT OUTER JOIN branch F ON (A.Bran_Num = F.Bran_Num )
                            WHERE 1 ";


                    $paramList = array();
                    if (isset($_GET['id']) && $_GET['id'] !== null) {
                        $sql .= " AND A.Cust_Num = ? ";
                        $paramList[] =  $_GET['id'];
                    }

                    if (isset($_GET['date'])) {
                        $sql .= " AND A.BodyM_Date = ? ";
                        $paramList[] =  $_GET['date'];
                    }

                    $sql .= " ORDER BY `BodyM_Date` DESC ";

                    if (isset($_GET['limit']) && $_GET['limit'] !== null) {
                        $sql .= " LIMIT ? ";
                        $limit = $_GET['limit'];
                        $paramList[] =  $limit;
                    }
                    $stmt = $conn->prepare($sql);
                    DynamicBindVariables($stmt, $paramList);

                    if (!$stmt->execute())
                        throw new Exception($stmt->error);
                    $SQLresult = $stmt->get_result();

                    while ($row = $SQLresult->fetch_assoc())
                        if ($row['Cust_Num'] !== null)
                            $result['data'][] = $row;
                    $stmt->close();
                } else
                    throw new Exception("A03 權限不足");
            } else if ($_GET['form'] == "working") {
                if (true || checkPermission(null, 'A04') >= 1) {

                    $sql = "SELECT A.*,B.Emp_Name FROM working A 
                            LEFT OUTER JOIN employee B ON (A.Work_Emp = B.Emp_Num)
                            WHERE 1 ";


                    $paramList = array();
                    if (isset($_GET['id']) && $_GET['id'] !== null) {
                        $sql .= " AND A.Work_Num = ? ";
                        $paramList[] =  $_GET['id'];
                    }


                    if (isset($_GET['limit']) && $_GET['limit'] !== null) {
                        $sql .= " LIMIT ? ";
                        $limit = $_GET['limit'];
                        $paramList[] =  $limit;
                    }
                    $stmt = $conn->prepare($sql);
                    DynamicBindVariables($stmt, $paramList);

                    if (!$stmt->execute())
                        throw new Exception($stmt->error);
                    $SQLresult = $stmt->get_result();
                    while ($row = $SQLresult->fetch_assoc())
                        $result['data'][] = $row;
                    $stmt->close();
                } else
                    throw new Exception("A04 權限不足");
            } else if ($_GET['form'] == "mateusa") {
                if (true || checkPermission(null, 'A05') >= 1) {

                    $sql = "SELECT A.*,B.CT_No,B.CI_No,B.Mate_Name,B.Mate_Unit,C.CI_Name as Unit_Name,D.Work_Qty FROM mateusa A 
                            LEFT OUTER JOIN material B ON (A.Mate_Num = B.Mate_Num)
                            LEFT OUTER JOIN syscodeinfo C ON (B.Unit_CT = C.CT_No  AND B.Mate_Unit = C.CI_No )
                            LEFT OUTER JOIN working D ON (A.Work_Num = D.Work_Num)
                            WHERE 1 ";


                    $paramList = array();
                    if (isset($_GET['id']) && $_GET['id'] !== null) {
                        $sql .= " AND A.WU_Num = ? ";
                        $paramList[] =  $_GET['id'];
                    }


                    if (isset($_GET['limit']) && $_GET['limit'] !== null) {
                        $sql .= " LIMIT ? ";
                        $limit = $_GET['limit'];
                        $paramList[] =  $limit;
                    }
                    $stmt = $conn->prepare($sql);
                    DynamicBindVariables($stmt, $paramList);

                    if (!$stmt->execute())
                        throw new Exception($stmt->error);
                    $SQLresult = $stmt->get_result();
                    while ($row = $SQLresult->fetch_assoc())
                        $result['data'][] = $row;
                    $stmt->close();
                } else
                    throw new Exception("A05 權限不足");
            } else if ($_GET['form'] == "orderstatus") {
                if (true || checkPermission(null, 'A06') >= 1) {

                    $sql = "SELECT A.*,B.Cust_Name,B.Cust_Tel,B.Cust_Mobile,C.CI_Name as OrderStatus_Name  FROM custorder A 
                            LEFT OUTER JOIN customer B ON (A.Cust_Num = B.Cust_Num)
                            LEFT OUTER JOIN syscodeinfo C ON (C.CT_No = A.OrderStatus_CT AND C.CI_No = A.OrderStatus)
                            WHERE 1 ";


                    $paramList = array();
                    if (isset($_GET['id']) && $_GET['id'] !== null) {
                        $sql .= " AND A.Order_Num = ? ";
                        $paramList[] =  $_GET['id'];
                    }
                    if (isset($_GET['OrderStatus']) && $_GET['OrderStatus'] !== null) {
                        $sql .= " AND A.OrderStatus = ? ";
                        $paramList[] =  $_GET['OrderStatus'];
                    }

                    if (isset($_GET['limit']) && $_GET['limit'] !== null) {
                        $sql .= " LIMIT ? ";
                        $limit = $_GET['limit'];
                        $paramList[] =  $limit;
                    }
                    $stmt = $conn->prepare($sql);
                    DynamicBindVariables($stmt, $paramList);

                    if (!$stmt->execute())
                        throw new Exception($stmt->error);
                    $SQLresult = $stmt->get_result();

                    while ($row = $SQLresult->fetch_assoc())
                        $result['data'][] = $row;
                    $stmt->close();
                } else
                    throw new Exception("A06 權限不足");
            } else if ($_GET['form'] == "supply") {
                if (true || checkPermission(null, 'B01') >= 1) {


                    $sql = "SELECT A.*,B.CI_Name as Cate_Name FROM supply A 
                            LEFT OUTER JOIN syscodeinfo B ON (B.CT_No='B09' AND A.Cate = B.CI_No)
                            WHERE 1 ";


                    $paramList = array();

                    if (isset($_GET['Supply_Num'])) {
                        $sql .= "AND Supply_Num=? ";
                        $Supply_Num = $_GET['Supply_Num'];
                        $paramList[] =  $Supply_Num;
                    }
                    if (isset($_GET['limit']) && $_GET['limit'] !== null) {
                        $sql .= " LIMIT ? ";
                        $limit = $_GET['limit'];
                        $paramList[] =  $limit;
                    }



                    $stmt = $conn->prepare($sql);
                    DynamicBindVariables($stmt, $paramList);

                    if (!$stmt->execute())
                        throw new Exception($stmt->error);
                    $SQLresult = $stmt->get_result();
                    while ($row = $SQLresult->fetch_assoc())
                        $result['data'][] = $row;
                    $stmt->close();
                } else
                    throw new Exception("B01 權限不足");
            } else if ($_GET['form'] == "material") {
                if (true || checkPermission(null, 'B02') >= 1) {



                    $sql = "SELECT A.*,B.CI_Name,C.Supply_Name,D.CI_Name as Mate_Color_Name,E.CI_Name as Mate_Unit_Name FROM material A 
                            LEFT OUTER JOIN syscodeinfo B ON (A.CT_No = B.CT_No AND A.CI_No = B.CI_No)
                            LEFT OUTER JOIN supply C ON (A.Supply_Num = C.Supply_Num)
                            LEFT OUTER JOIN syscodeinfo D ON (D.CT_No = 'B07' AND A.Mate_Color = D.CI_No)
                            LEFT OUTER JOIN syscodeinfo E ON (E.CT_No = 'B08' AND A.Mate_Unit = E.CI_No)  WHERE 1 ";

                    $paramList = array();

                    if (isset($_GET['CT_No']) && $_GET['CT_No'] !== null) {
                        $sql .= " AND A.CT_No = ? ";
                        $paramList[] =  $_GET['CT_No'];
                    }
                    if (isset($_GET['CI_No']) && $_GET['CI_No'] !== null) {
                        $sql .= " AND A.CI_No = ? ";
                        $paramList[] =  $_GET['CI_No'];
                    }
                    if (isset($_GET['Mate_Color']) && $_GET['Mate_Color'] !== null) {
                        $sql .= " AND A.Mate_Color = ? ";
                        $paramList[] =  $_GET['Mate_Color'];
                    }

                    if (isset($_GET['id']) && $_GET['id'] !== null) {
                        $sql .= " AND A.Mate_Num = ? ";
                        $paramList[] =  $_GET['id'];
                    }

                    if (isset($_GET['limit']) && $_GET['limit'] !== null) {
                        $sql .= " LIMIT ? ";
                        $limit = $_GET['limit'];
                        $paramList[] =  $limit;
                    }
                    $stmt = $conn->prepare($sql);
                    DynamicBindVariables($stmt, $paramList);

                    if (!$stmt->execute())
                        throw new Exception($stmt->error);
                    $SQLresult = $stmt->get_result();

                    while ($row = $SQLresult->fetch_assoc())
                        $result['data'][] = $row;

                    $stmt->close();
                } else
                    throw new Exception("B02 權限不足");
            } else if ($_GET['form'] == "purchase") {
                if (true || checkPermission(null, 'B03') >= 1) {

                    $sql = "SELECT A.*,B.Mate_Name,B.CT_No,B.Mate_Color as Mate_Color_Code,B.CI_No,C.CI_Name as Mate_Color_Name,D.CI_Name as Pur_Unit_Name,E.Supply_Name  FROM purchase A 
                            LEFT OUTER JOIN material B ON (A.Mate_Num = B.Mate_Num)
                            LEFT OUTER JOIN syscodeinfo C ON (C.CT_No = B.Color_CT AND C.CI_No = B.Mate_Color)
                            LEFT OUTER JOIN syscodeinfo D ON (D.CT_No = B.Unit_CT AND D.CI_No = B.Mate_Unit)
                            LEFT OUTER JOIN supply E ON (E.Supply_Num = A.Supply_Num)
                            WHERE 1 ";


                    $paramList = array();

                    if (isset($_GET['Pur_Num'])) {
                        $sql .= "AND Pur_Num=? ";
                        $Pur_Num = $_GET['Pur_Num'];
                        $paramList[] =  $Pur_Num;
                    }
                    if (isset($_GET['limit']) && $_GET['limit'] !== null) {
                        $sql .= " LIMIT ? ";
                        $limit = $_GET['limit'];
                        $paramList[] =  $limit;
                    }


                    $stmt = $conn->prepare($sql);
                    DynamicBindVariables($stmt, $paramList);

                    if (!$stmt->execute())
                        throw new Exception($stmt->error);
                    $SQLresult = $stmt->get_result();
                    while ($row = $SQLresult->fetch_assoc())
                        $result['data'][] = $row;

                    $stmt->close();
                } else
                    throw new Exception("B03 權限不足");
            } else if ($_GET['form'] == "stock") {
                if (true || checkPermission(null, 'B04') >= 1) {


                    $sql = "SELECT A.*,B.Mate_Name,C.CI_Name as Unit_Name,D.CI_Name as Material_Type FROM `stock` A 
                            LEFT OUTER JOIN material B ON (A.Mate_Num = B.Mate_Num)
                            LEFT OUTER JOIN syscodeinfo C ON (B.Unit_CT = C.CT_No AND B.Mate_Unit = C.CI_No)
                            LEFT OUTER JOIN syscodeinfo D ON (B.CT_No = D.CT_No AND B.CI_No = D.CI_No)
                            WHERE 1 ";

                    $paramList = array();
                    if (isset($_GET['id']) && $_GET['id'] !== null) {
                        $sql .= " AND A.Mate_Num = ? ";
                        $paramList[] =  $_GET['id'];
                    }
                    //$sql .= " ORDER BY A.`Mate_Num` ASC, A.`Stk_Date` DESC ";

                    if (isset($_GET['limit']) && $_GET['limit'] !== null) {
                        $sql .= " LIMIT ? ";
                        $limit = $_GET['limit'];
                        $paramList[] =  $limit;
                    }
                    $stmt = $conn->prepare($sql);
                    DynamicBindVariables($stmt, $paramList);

                    if (!$stmt->execute())
                        throw new Exception($stmt->error);
                    $SQLresult = $stmt->get_result();

                    //$lastId = "";
                    while ($row = $SQLresult->fetch_assoc()) {
                        /*if ($lastId !== $row['Mate_Num'])
                            $row['last'] = true;
                        else
                            $row['last'] = false;
                        $lastId = $row['Mate_Num'];*/
                        $result['data'][] = $row;
                    }
                    $stmt->close();
                } else
                    throw new Exception("B04 權限不足");
            } else if ($_GET['form'] == "department") {
                if (true || checkPermission(null, 'C01') >= 1) {


                    $sql = "SELECT A.*,B.Emp_Name as Dep_Supr_Name FROM `department` A 
                            LEFT OUTER JOIN employee B ON (A.Dep_Supr = B.Emp_Num)
                            WHERE 1 ";

                    $paramList = array();
                    if (isset($_GET['id']) && $_GET['id'] !== null) {
                        $sql .= " AND A.Dep_Num = ? ";
                        $paramList[] =  $_GET['id'];
                    }

                    if (isset($_GET['limit']) && $_GET['limit'] !== null) {
                        $sql .= " LIMIT ? ";
                        $limit = $_GET['limit'];
                        $paramList[] =  $limit;
                    }
                    $stmt = $conn->prepare($sql);
                    DynamicBindVariables($stmt, $paramList);

                    if (!$stmt->execute())
                        throw new Exception($stmt->error);
                    $SQLresult = $stmt->get_result();
                    while ($row = $SQLresult->fetch_assoc())
                        $result['data'][] = $row;
                    $stmt->close();
                } else
                    throw new Exception("C01 權限不足");
            } else if ($_GET['form'] == "employee") {
                if (true || checkPermission(null, 'C02') >= 1) {


                    $sql = "SELECT A.*,B.Bran_Name,C.Dep_Name FROM `employee` A 
                            LEFT OUTER JOIN branch B ON (A.Bran_Num = B.Bran_Num)
                            LEFT OUTER JOIN department C ON (A.Dep_Num = C.Dep_Num)
                            WHERE 1 ";

                    $paramList = array();
                    if (isset($_GET['id']) && $_GET['id'] !== null) {
                        $sql .= " AND Emp_Num = ? ";
                        $paramList[] =  $_GET['id'];
                    }

                    if (isset($_GET['limit']) && $_GET['limit'] !== null) {
                        $sql .= " LIMIT ? ";
                        $limit = $_GET['limit'];
                        $paramList[] =  $limit;
                    }
                    $sql .= " ORDER BY `Emp_Num` DESC ";
                    $stmt = $conn->prepare($sql);
                    DynamicBindVariables($stmt, $paramList);

                    if (!$stmt->execute())
                        throw new Exception($stmt->error);
                    $SQLresult = $stmt->get_result();
                    while ($row = $SQLresult->fetch_assoc())
                        $result['data'][] = $row;
                    $stmt->close();
                } else
                    throw new Exception("C02 權限不足");
            } else if ($_GET['form'] == "branch") {
                if (true || checkPermission(null, 'D01') >= 1) {


                    $sql = "SELECT A.*,B.Or_No FROM `branch` A
                            LEFT OUTER JOIN `sysoprolebranch` B ON (B.Or_No = ? AND A.Bran_Num = B.Bran_Num)
                            WHERE 1";

                    $paramList = array();
                    $paramList[] =  $_SESSION['role'];
                    if (isset($_GET['id']) && $_GET['id'] !== null) {
                        $sql .= " AND A.Bran_Num = ? ";
                        $paramList[] =  $_GET['id'];
                    }

                    if (isset($_GET['limit']) && $_GET['limit'] !== null) {
                        $sql .= " LIMIT ? ";
                        $limit = $_GET['limit'];
                        $paramList[] =  $limit;
                    }
                    $stmt = $conn->prepare($sql);
                    DynamicBindVariables($stmt, $paramList);

                    if (!$stmt->execute())
                        throw new Exception($stmt->error);
                    $SQLresult = $stmt->get_result();
                    $header = getallheaders();
                    while ($row = $SQLresult->fetch_assoc())
                        if (strpos($header['Referer'], 'SysOpRole.php') !== false || $_SESSION['role'] === '000' || $row['Or_No'] !== NULL)
                            $result['data'][] = $row;
                    $stmt->close();
                } else
                    throw new Exception("D01 權限不足");
            } else if ($_GET['form'] == "expenditure") {
                if (true || checkPermission(null, 'D02') >= 1) {


                    $sql = "SELECT A.*,B.Bran_Name,C.CI_Name as EB_Cate_Name, D.Or_No FROM branchexpenditure A 
                            LEFT OUTER JOIN branch B ON (A.Bran_Num = B.Bran_Num)
                            LEFT OUTER JOIN syscodeinfo C ON (C.CT_No = A.EB_CT AND C.CI_No = A.EB_Cate)
                            LEFT OUTER JOIN `sysoprolebranch` D ON (D.Or_No = ? AND A.Bran_Num = D.Bran_Num)
                            WHERE 1 ";

                    $paramList = array();
                    $paramList[] =  $_SESSION['role'];
                    if (isset($_GET['id']) && $_GET['id'] !== null) {
                        $sql .= " AND A.EB_Id = ? ";
                        $paramList[] =  $_GET['id'];
                    }

                    if (isset($_GET['limit']) && $_GET['limit'] !== null) {
                        $sql .= " LIMIT ? ";
                        $limit = $_GET['limit'];
                        $paramList[] =  $limit;
                    }

                    $stmt = $conn->prepare($sql);
                    DynamicBindVariables($stmt, $paramList);

                    if (!$stmt->execute())
                        throw new Exception($stmt->error);
                    $SQLresult = $stmt->get_result();
                    while ($row = $SQLresult->fetch_assoc())
                        if ($_SESSION['role'] === '000' || $row['Or_No'] !== NULL)
                            $result['data'][] = $row;
                    $stmt->close();
                } else
                    throw new Exception("D02 權限不足");
            } else if ($_GET['form'] == "prototype") {
                if (true || checkPermission(null, 'E01') >= 1) {


                    $sql = "SELECT * FROM `prototype` WHERE 1";

                    $paramList = array();
                    if (isset($_GET['ProtoM_Num']) && $_GET['ProtoM_Num'] !== null) {
                        $sql .= " AND ProtoM_Num = ? ";
                        $paramList[] =  $_GET['ProtoM_Num'];
                    }

                    if (isset($_GET['limit']) && $_GET['limit'] !== null) {
                        $sql .= " LIMIT ? ";
                        $limit = $_GET['limit'];
                        $paramList[] =  $limit;
                    }
                    $stmt = $conn->prepare($sql);
                    DynamicBindVariables($stmt, $paramList);

                    if (!$stmt->execute())
                        throw new Exception($stmt->error);
                    $SQLresult = $stmt->get_result();
                    while ($row = $SQLresult->fetch_assoc())
                        $result['data'][] = $row;
                    $stmt->close();
                } else
                    throw new Exception("E01 權限不足");
            } else if ($_GET['form'] == "custom") {
                if (true || checkPermission(null, 'E02') >= 1) {

                    $sql = "SELECT A.*,B.Design_Num,D.Cust_Name,E.ProtoM_Name FROM custom A 
                    LEFT OUTER JOIN orderitem B ON (A.Order_Num = B.Order_Num AND A.Item_Num = B.Item_Num)
                    LEFT OUTER JOIN custorder C ON (A.Order_Num = C.Order_Num)
                    LEFT OUTER JOIN customer D ON (C.Cust_Num = D.Cust_Num)
                    LEFT OUTER JOIN prototype E ON (A.ProtoM_Num = E.ProtoM_Num)
                    WHERE 1 ";

                    $paramList = array();
                    if (isset($_GET['Cust_Num']) && $_GET['Cust_Num'] !== null) {
                        $sql .= " AND Cust_Num = ? ";
                        $paramList[] =  $_GET['Cust_Num'];
                    }

                    if (isset($_GET['limit']) && $_GET['limit'] !== null) {
                        $sql .= " LIMIT ? ";
                        $limit = $_GET['limit'];
                        $paramList[] =  $limit;
                    }
                    $stmt = $conn->prepare($sql);
                    DynamicBindVariables($stmt, $paramList);

                    if (!$stmt->execute())
                        throw new Exception($stmt->error);
                    $SQLresult = $stmt->get_result();
                    while ($row = $SQLresult->fetch_assoc())
                        $result['data'][] = $row;
                    $stmt->close();
                } else
                    throw new Exception("E02 權限不足");
            } else if ($_GET['form'] == "syscodetype") {
                if (true || checkPermission(null, 'Z01') >= 1) {


                    $sql = "SELECT * FROM `syscodetype` WHERE 1";

                    $paramList = array();
                    if (isset($_GET['CT_No']) && $_GET['CT_No'] !== null) {
                        $sql .= " AND CT_No = ? ";
                        $paramList[] =  $_GET['CT_No'];
                    }

                    if (isset($_GET['limit']) && $_GET['limit'] !== null) {
                        $sql .= " LIMIT ? ";
                        $limit = $_GET['limit'];
                        $paramList[] =  $limit;
                    }
                    $stmt = $conn->prepare($sql);
                    DynamicBindVariables($stmt, $paramList);

                    if (!$stmt->execute())
                        throw new Exception($stmt->error);
                    $SQLresult = $stmt->get_result();
                    while ($row = $SQLresult->fetch_assoc())
                        $result['data'][] = $row;
                    $stmt->close();
                } else
                    throw new Exception("Z01 權限不足");
            } else if ($_GET['form'] == "syscodeinfo") {
                if (true || checkPermission(null, 'Z01') >= 1) {


                    $sql = "SELECT * FROM `syscodeinfo` WHERE 1";

                    $paramList = array();
                    if (isset($_GET['CT_No']) && $_GET['CT_No'] !== null) {
                        $sql .= " AND CT_No = ? ";
                        $paramList[] =  $_GET['CT_No'];
                    }

                    if (isset($_GET['limit']) && $_GET['limit'] !== null) {
                        $sql .= " LIMIT ? ";
                        $limit = $_GET['limit'];
                        $paramList[] =  $limit;
                    }
                    $stmt = $conn->prepare($sql);
                    DynamicBindVariables($stmt, $paramList);

                    if (!$stmt->execute())
                        throw new Exception($stmt->error);
                    $SQLresult = $stmt->get_result();
                    while ($row = $SQLresult->fetch_assoc())
                        $result['data'][] = $row;
                    $stmt->close();
                } else
                    throw new Exception("Z01 權限不足");
            } else if ($_GET['form'] == "sysoprole") {
                if (true || checkPermission(null, 'Z02') >= 1) {


                    $sql = "SELECT *,B.CI_Name as Or_TypeName FROM `sysoprole` A
                        LEFT OUTER JOIN `syscodeinfo` B ON (B.CT_No=A.Or_CT AND A.Or_Type = B.CI_No)
                        WHERE 1 ";

                    $paramList = array();
                    if (isset($_GET['limit']) && $_GET['limit'] !== null) {
                        $sql .= " LIMIT ? ";
                        $limit = $_GET['limit'];
                        $paramList[] =  $limit;
                    }
                    $stmt = $conn->prepare($sql);
                    DynamicBindVariables($stmt, $paramList);

                    if (!$stmt->execute())
                        throw new Exception($stmt->error);
                    $SQLresult = $stmt->get_result();
                    while ($row = $SQLresult->fetch_assoc())
                        $result['data'][] = $row;

                    $stmt->close();
                } else
                    throw new Exception("Z02 權限不足");
            } else if ($_GET['form'] == "sysoprolefunc") {
                if (true || checkPermission(null, 'Z02') >= 1) {


                    $sql = "SELECT * FROM `sysoprolefunc` WHERE 1 ";
                    $paramList = array();
                    if (isset($_GET['Or_No']) && $_GET['Or_No'] !== null) {
                        $sql .= " AND Or_No=? ";
                        $Or_No = $_GET['Or_No'];
                        $paramList[] =  $Or_No;
                    }
                    if (isset($_GET['limit']) && $_GET['limit'] !== null) {
                        $sql .= " LIMIT ? ";
                        $limit = $_GET['limit'];
                        $paramList[] =  $limit;
                    }
                    $stmt = $conn->prepare($sql);



                    DynamicBindVariables($stmt, $paramList);

                    if (!$stmt->execute())
                        throw new Exception($stmt->error);
                    $SQLresult = $stmt->get_result();
                    while ($row = $SQLresult->fetch_assoc())
                        $result['data'][] = $row;

                    $stmt->close();
                } else
                    throw new Exception("Z02 權限不足");
            } else if ($_GET['form'] == "sysoprolebranch") {
                if (true || checkPermission(null, 'Z02') >= 1) {


                    $sql = "SELECT * FROM `sysoprolebranch` WHERE 1 ";
                    $paramList = array();
                    if (isset($_GET['Or_No']) && $_GET['Or_No'] !== null) {
                        $sql .= " AND Or_No=? ";
                        $Or_No = $_GET['Or_No'];
                        $paramList[] =  $Or_No;
                    }
                    if (isset($_GET['limit']) && $_GET['limit'] !== null) {
                        $sql .= " LIMIT ? ";
                        $limit = $_GET['limit'];
                        $paramList[] =  $limit;
                    }
                    $stmt = $conn->prepare($sql);



                    DynamicBindVariables($stmt, $paramList);

                    if (!$stmt->execute())
                        throw new Exception($stmt->error);
                    $SQLresult = $stmt->get_result();
                    while ($row = $SQLresult->fetch_assoc())
                        $result['data'][] = $row;

                    $stmt->close();
                } else
                    throw new Exception("Z02 權限不足");
            } else if ($_GET['form'] == "sysoplog") {
                if (true || checkPermission(null, 'Z03') >= 1) {
                    $sql = "SELECT A.*,B.CI_Name as func_Name,C.CI_Name as op_Name FROM sysoplog A
                        LEFT OUTER JOIN syscodeinfo B ON (A.Func_No = B.CI_No AND B.CT_No=A.Func_CT)
                        LEFT OUTER JOIN syscodeinfo C ON (A.Op_No = C.CI_No AND C.CT_No=A.Op_CT) WHERE 1";
                    $paramList = array();
                    if (isset($_GET['limit']) && $_GET['limit'] !== null) {
                        $sql .= " LIMIT ? ";
                        $limit = $_GET['limit'];
                        $paramList[] =  $limit;
                    }
                    $stmt = $conn->prepare($sql);
                    DynamicBindVariables($stmt, $paramList);

                    if (!$stmt->execute())
                        throw new Exception($stmt->error);
                    $SQLresult = $stmt->get_result();
                    while ($row = $SQLresult->fetch_assoc())
                        $result['data'][] = $row;
                    $stmt->close();
                } else
                    throw new Exception("Z03 權限不足");
            } else
                throw new Exception("form error");
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') //create
        {
            if ($_POST['form'] == "order") {
                if (checkPermission(null, 'A01') >= 2) {

                    $conn->query("LOCK TABLES `custorder`,`orderitem` WRITE");


                    $stmt = $conn->prepare("SELECT `Order_Num` FROM `custorder` WHERE Bran_Num=? ORDER BY Order_Num DESC LIMIT 0,1");
                    $paramList = array();
                    $paramList[] =  $_SESSION['Bran_Num'];

                    DynamicBindVariables($stmt, $paramList);

                    if (!$stmt->execute())
                        throw new Exception($stmt->error);
                    $stmt->bind_result($oldId);
                    $stmt->fetch();
                    $stmt->close();


                    $nowDate = str_pad(date("Y") - 1911, 3, '0', STR_PAD_LEFT) . str_pad(date("m"), 2, '0', STR_PAD_LEFT);
                    $lastDate = substr($oldId, 5, 5);
                    $lastId = substr($oldId, 10, 5);

                    if ($lastDate === $nowDate)
                        $serialId = str_pad((int) $lastId + 1, 5, '0', STR_PAD_LEFT);
                    else
                        $serialId = str_pad(1, 5, '0', STR_PAD_LEFT);
                    $id = "O" . $_SESSION['Bran_Num'] . $nowDate . $serialId;
                    $stmt = $conn->prepare("INSERT INTO `custorder`(`Order_Num`, `Cust_Num`, `Order_Date`, `BodyM_Date`, `Order_Qty`, `Order_Amt`, `Order_Deposit`, `Plan_Date`, `DeliveryWay`, `Order_Postal`, `DeliveryAddr`, `Bran_Num`, `Adduser`, `Chguser`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                    $paramList = array();
                    $paramList[] =  $id;
                    $paramList[] =  $_POST['Cust_Num'];
                    $paramList[] =  $_POST['Order_Date'];
                    $paramList[] =  $_POST['BodyM_Date'];
                    $paramList[] =  $_POST['Order_Qty'];
                    $paramList[] =  $_POST['Order_Amt'];
                    $paramList[] =  $_POST['Order_Deposit'];
                    $paramList[] =  $_POST['Plan_Date'];
                    $paramList[] =  $_POST['DeliveryWay'];
                    $paramList[] =  $_POST['Order_Postal'];
                    $paramList[] =  $_POST['DeliveryAddr'];
                    $paramList[] =  $_SESSION['Bran_Num'];
                    $paramList[] =  $_SESSION['Emp_Num'];
                    $paramList[] =  $_SESSION['Emp_Num'];
                    DynamicBindVariables($stmt, $paramList);




                    if (!$stmt->execute())
                        throw new Exception($stmt->error);

                    $stmt->close();


                    $stmt = $conn->prepare("INSERT INTO `orderitem`(`Order_Num`, `Item_Num`, `Design_Num`, `Design_Mate`, `Item_Color`, `Item_BgColor`, `Item_Effect`, `Item_Extra`, `Item_EPrice`, `Item_Price`, `Item_Qty`, `Item_PDate`, `Item_Amt`, `Item_Bside`, `Item_Breast`, `Item_Spon`, `Item_Cup`, `Item_Pocket`, `Item_Strap`, `Item_Wear`, `Adduser`, `Chguser`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

                    foreach ($_POST['Item_Num'] as $index => $Item_Num) {
                        $paramList = array();
                        $paramList[] =  $id;
                        $paramList[] = str_pad($index + 1, 3, '0', STR_PAD_LEFT);
                        $paramList[] = $_POST['Design_Num'][$index];
                        $paramList[] = $_POST['Design_Mate'][$index];
                        $paramList[] = $_POST['Item_Color'][$index];
                        $paramList[] = $_POST['Item_BgColor'][$index];
                        $paramList[] = $_POST['Item_Effect'][$index];
                        $paramList[] = $_POST['Item_Extra'][$index];
                        $paramList[] = $_POST['Item_EPrice'][$index];
                        $paramList[] = $_POST['Item_Price'][$index];
                        $paramList[] = $_POST['Item_Qty'][$index];
                        $paramList[] = $_POST['Plan_Date'];
                        $paramList[] = $_POST['Item_Amt'][$index];
                        $paramList[] = $_POST['Item_Bside'][$index];
                        $paramList[] = $_POST['Item_Breast'][$index];
                        $paramList[] = $_POST['Item_Spon'][$index];
                        $paramList[] = $_POST['Item_Cup'][$index];
                        $paramList[] = $_POST['Item_Pocket'][$index];
                        $paramList[] = $_POST['Item_Strap'][$index];
                        $paramList[] = $_POST['Item_Wear'][$index];
                        $paramList[] = $_SESSION['Emp_Num'];
                        $paramList[] = $_SESSION['Emp_Num'];
                        DynamicBindVariables($stmt, $paramList);
                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                    }
                    $stmt->close();
                } else
                    throw new Exception("A01 權限不足");
            } else if ($_POST['form'] == "customer") {
                if (checkPermission(null, 'A02') >= 2) {

                    $conn->query("LOCK TABLES `customer` WRITE");


                    $stmt = $conn->prepare("SELECT `Cust_Num` FROM `customer` ORDER BY Cust_Num DESC LIMIT 0,1");
                    if (!$stmt->execute())
                        throw new Exception($stmt->error);
                    $stmt->bind_result($oldId);
                    $stmt->fetch();
                    $stmt->close();


                    $lastDate = date("Ym", strtotime(substr($oldId, 1, 6) . "01"));
                    $lastId = substr($oldId, 7, 5);
                    if ($lastDate == date("Ym"))
                        $serialId = str_pad((int) $lastId + 1, 5, '0', STR_PAD_LEFT);
                    else
                        $serialId = str_pad(1, 5, '0', STR_PAD_LEFT);
                    $id = "C" . date("Ym") . $serialId;
                    $stmt = $conn->prepare("INSERT INTO `customer`(`Cust_Num`, `Cust_Name`, `Cust_Birth`, `Cust_Postal`, `Cust_Addr`, `Cust_Tel`, `Cust_Mobile`, `Cust_Email`, `Cust_Memo`, `Bran_num`, `Adduser`, `Chguser`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
                    $date = date('Y-m-d H:i:s');

                    if (isset($_SESSION['Bran_Num']))
                        $Bran_num = $_SESSION['Bran_Num'];
                    else
                        $Bran_num = "";

                    $paramList[] =  $id;
                    $paramList[] =  $_POST['Cust_Name'];
                    $paramList[] =  $_POST['Cust_Birth'];
                    $paramList[] =  $_POST['Cust_Postal'];
                    $paramList[] =  $_POST['Cust_Addr'];
                    $paramList[] =  $_POST['Cust_Tel'];
                    $paramList[] =  $_POST['Cust_Mobile'];
                    $paramList[] =  $_POST['Cust_Email'];
                    $paramList[] =  $_POST['Cust_Memo'];
                    $paramList[] =  $_SESSION['Bran_Num'];
                    $paramList[] =  $_SESSION['Emp_Num'];
                    $paramList[] =  $_SESSION['Emp_Num'];
                    DynamicBindVariables($stmt, $paramList);




                    if (!$stmt->execute())
                        throw new Exception($stmt->error);

                    $stmt->close();
                } else
                    throw new Exception("A02 權限不足");
            } else if ($_POST['form'] == "measurement") {
                if (checkPermission(null, 'A03') >= 2) {

                    $stmt = $conn->prepare("INSERT INTO `custmeasure`(`Cust_Num`, `BodyM_Date`, `Emp_Num`, `Bran_Num`, `BodyM_High`, `BodyM_Weight`, `BodyM_Cup`, `BodyM_Unit`, `Cust_Memo`, `BodyM_SW`, `BodyM_DFS`, `BodyM_BH`, `BodyM_BR`, `BodyM_SBW`, `BodyM_FBW`, `BodyM_UpB`, `BodyM_B`, `BodyM_UdB`, `BodyM_ArtoUdB`, `BodyM_ArtoW`, `BodyM_ArtoT`, `BodyM_UdBtoW`, `BodyM_UdBtoT`, `BodyM_W`, `BodyM_AbH`, `BodyM_Ab`, `BodyM_UdBtoY`, `BodyM_Hip`, `BodyM_HL`, `BodyM_WtoT`, `BodyM_OTS`, `BodyM_BL`, `BodyM_BW`, `BodyM_CD`, `BodyM_HLH`, `BodyM_BHLH`, `BodyM_CL`, `BodyM_UdBtoC`, `Adduser`, `Chguser`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

                    $paramList[] =  $_POST['Cust_Num'];
                    $paramList[] =  $_POST['BodyM_Date'];
                    $paramList[] =  $_POST['Emp_Num'];
                    $paramList[] =  $_SESSION['Bran_Num'];
                    $paramList[] =  $_POST['BodyM_High'];
                    $paramList[] =  $_POST['BodyM_Weight'];
                    $paramList[] =  $_POST['BodyM_Cup'];
                    $paramList[] =  $_POST['BodyM_Unit'];
                    $paramList[] =  $_POST['Cust_Memo'];
                    $paramList[] =  $_POST['BodyM_SW'];
                    $paramList[] =  $_POST['BodyM_DFS'];
                    $paramList[] =  $_POST['BodyM_BH'];
                    $paramList[] =  $_POST['BodyM_BR'];
                    $paramList[] =  $_POST['BodyM_SBW'];
                    $paramList[] =  $_POST['BodyM_FBW'];
                    $paramList[] =  $_POST['BodyM_UpB'];
                    $paramList[] =  $_POST['BodyM_B'];
                    $paramList[] =  $_POST['BodyM_UdB'];
                    $paramList[] =  $_POST['BodyM_ArtoUdB'];
                    $paramList[] =  $_POST['BodyM_ArtoW'];
                    $paramList[] =  $_POST['BodyM_ArtoT'];
                    $paramList[] =  $_POST['BodyM_UdBtoW'];
                    $paramList[] =  $_POST['BodyM_UdBtoT'];
                    $paramList[] =  $_POST['BodyM_W'];
                    $paramList[] =  $_POST['BodyM_AbH'];
                    $paramList[] =  $_POST['BodyM_Ab'];
                    $paramList[] =  $_POST['BodyM_UdBtoY'];
                    $paramList[] =  $_POST['BodyM_Hip'];
                    $paramList[] =  $_POST['BodyM_HL'];
                    $paramList[] =  $_POST['BodyM_WtoT'];
                    $paramList[] =  $_POST['BodyM_OTS'];
                    $paramList[] =  $_POST['BodyM_BL'];
                    $paramList[] =  $_POST['BodyM_BW'];
                    $paramList[] =  $_POST['BodyM_CD'];
                    $paramList[] =  $_POST['BodyM_HLH'];
                    $paramList[] =  $_POST['BodyM_BHLH'];
                    $paramList[] =  $_POST['BodyM_CL'];
                    $paramList[] =  $_POST['BodyM_UdBtoC'];
                    $paramList[] =  $_SESSION['Emp_Num'];
                    $paramList[] =  $_SESSION['Emp_Num'];
                    DynamicBindVariables($stmt, $paramList);




                    if (!$stmt->execute())
                        throw new Exception($stmt->error);

                    $stmt->close();
                } else
                    throw new Exception("A03 權限不足");
            } else if ($_POST['form'] == "working") {
                if (checkPermission(null, 'A04') >= 2) {
                    $conn->query("LOCK TABLES `working`,`orderitem` WRITE");




                    $stmt = $conn->prepare("SELECT `Work_Num` FROM `working` ORDER BY Work_Num DESC LIMIT 0,1");
                    if (!$stmt->execute())
                        throw new Exception($stmt->error);
                    $stmt->bind_result($oldId);
                    $stmt->fetch();
                    $stmt->close();



                    $lastDate = date("Ymd", strtotime(substr($oldId, 1, 8)));
                    $lastId = substr($oldId, 9, 3);
                    if ($lastDate == date("Ymd"))
                        $serialId = str_pad((int) $lastId + 1, 3, '0', STR_PAD_LEFT);
                    else
                        $serialId = str_pad(1, 3, '0', STR_PAD_LEFT);
                    $id = "W" . date("Ymd") . $serialId;


                    $paramList = $_POST;
                    $paramList['Work_Num'] = $id;
                    if (isset($paramList['Sour_Po']) && $paramList['Sour_Po'] === "")
                        unset($paramList['Sour_Po']);
                    if (isset($paramList['Dest_Po']) && $paramList['Dest_Po'] === "")
                        unset($paramList['Dest_Po']);
                    if (isset($paramList['ProtoM_Num']) && $paramList['ProtoM_Num'] === "")
                        unset($paramList['ProtoM_Num']);
                    if (isset($paramList['Cust_Num']) && $paramList['Cust_Num'] === "")
                        unset($paramList['Cust_Num']);
                    unset($paramList['form']);
                    $paramList['Adduser'] = $_SESSION['Emp_Num'];
                    $paramList['Chguser'] = $_SESSION['Emp_Num'];
                    DynamicInsert($conn, 'working', $paramList);



                    /*$sql = "SELECT OrderCancel FROM custorder WHERE Order_Num = ? ";
                    $paramList = array();
                    $paramList[] =  $workInfo['Order_Num'];
                    $stmt = $conn->prepare($sql);
                    DynamicBindVariables($stmt, $paramList);
                    if (!$stmt->execute())
                        throw new Exception($stmt->error);
                    $SQLresult = $stmt->get_result();
                    if ($row = $SQLresult->fetch_assoc()) {
                        if ($row['OrderCancel'] == '1')
                            throw new Exception("此訂單已取消");
                    } else
                        throw new Exception("無此訂單");
                    $stmt->close();*/


                    if (isset($_POST['Work_Qty'])) {

                        /*$sql = "SELECT A.Order_Num,A.Item_Num,A.Work_Qty,B.Item_Qty,B.Work_Qty as Item_Work_Qty FROM working A
                                LEFT OUTER JOIN `orderitem` B ON (A.Order_Num = B.Order_Num AND A.Item_Num = B.Item_Num)
                                WHERE A.Work_Num = ? ";*/
                        $sql = "SELECT * FROM orderitem WHERE Order_Num=? AND Item_Num=?";
                        $paramList = array();
                        $paramList[] =  $_POST['Order_Num'];
                        $paramList[] =  $_POST['Item_Num'];
                        $stmt = $conn->prepare($sql);
                        DynamicBindVariables($stmt, $paramList);
                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        $SQLresult = $stmt->get_result();
                        $itemInfo = null;
                        if ($row = $SQLresult->fetch_assoc())
                            $itemInfo = $row;
                        else
                            throw new Exception("無此品項");
                        $stmt->close();

                        $max = (int)$itemInfo['Item_Qty'] - (int)$itemInfo['Work_Qty'];
                        if ((int)$_POST['Work_Qty'] > $max)
                            throw new Exception("派工件數最多為" . $max);

                        $paramList = array();
                        $paramList['Work_Qty'] =  (int)$itemInfo['Work_Qty']  + (int)$_POST['Work_Qty'];
                        $where = array();
                        $where['Order_Num'] = $itemInfo['Order_Num'];
                        $where['Item_Num'] = $itemInfo['Item_Num'];
                        DynamicUpdate($conn, "orderitem", $paramList, $where);
                    }
                } else
                    throw new Exception("A04 權限不足");
            } else if ($_POST['form'] == "mateusa") {
                if (checkPermission(null, 'A05') >= 2) {
                    $conn->query("LOCK TABLES `mateusa`,`stock` WRITE");
                    foreach ($_POST['WU_Item'] as $key => $WU_Item) {
                        $paramList = [];
                        $paramList['WU_Num'] = $_POST['WU_Num'];
                        $paramList['Work_Num'] = $_POST['Work_Num'];
                        $paramList['WU_Date'] = $_POST['WU_Date'];
                        $paramList['WU_Item'] = str_pad((int) $key + 1, 3, '0', STR_PAD_LEFT);
                        $paramList['Mate_Num'] = $_POST['Mate_Num'][$key];
                        $paramList['WU_Unit'] = $_POST['WU_Unit'][$key];
                        $paramList['WU_Qty'] = $_POST['WU_Qty'][$key];
                        DynamicInsert($conn, 'mateusa', $paramList);


                        $stmt = $conn->prepare("SELECT * FROM `stock` WHERE Mate_Num=? AND Stk_Date<=NOW() ORDER BY `Stk_Date` DESC  LIMIT 0,1");
                        $paramList = [];
                        $paramList[] = $_POST['Mate_Num'][$key];
                        DynamicBindVariables($stmt, $paramList);
                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        if ($row = $stmt->get_result()->fetch_assoc()) {
                            if ($row['Stk_Date'] === date("Y-m-d")) //今天存在庫存資料
                            {
                                $paramList = array();
                                $paramList['Stk_Out'] = (int)$row['Stk_Out'] + (int)$_POST['WU_Qty'][$key];
                                $paramList['Stk_Qty'] = (int)$row['Stk_Pre'] + (int)$row['Stk_In'] - (int)$paramList['Stk_Out'];
                                $paramList['Chguser'] = $_SESSION['Emp_Num'];
                                $where = array();
                                $where['Mate_Num'] = $_POST['Mate_Num'][$key];
                                $where['Stk_Date'] = $row['Stk_Date'];
                                DynamicUpdate($conn, "stock", $paramList, $where);
                            } else {
                                $paramList = array();
                                $paramList['Mate_Num'] = $_POST['Mate_Num'][$key];
                                $paramList['Stk_Date'] = date("Y-m-d");
                                $paramList['Stk_Pre'] = $row['Stk_Qty'];
                                $paramList['Stk_In'] = 0;
                                $paramList['Stk_Out'] = (int)$_POST['WU_Qty'][$key];
                                $paramList['Stk_Qty'] = (int)$paramList['Stk_Pre'] + (int)$paramList['Stk_In'] - (int)$paramList['Stk_Out'];
                                $paramList['Adduser'] = $_SESSION['Emp_Num'];
                                $paramList['Chguser'] = $_SESSION['Emp_Num'];
                                DynamicInsert($conn, 'stock', $paramList);
                            }
                        } else {
                            $paramList = array();
                            $paramList['Mate_Num'] = $_POST['Mate_Num'][$key];
                            $paramList['Stk_Date'] = date("Y-m-d");
                            $paramList['Stk_Pre'] = 0;
                            $paramList['Stk_In'] = 0;
                            $paramList['Stk_Out'] = (int)$_POST['WU_Qty'][$key];
                            $paramList['Stk_Qty'] = (int)$paramList['Stk_Pre'] + (int)$paramList['Stk_In'] - (int)$paramList['Stk_Out'];
                            $paramList['Adduser'] = $_SESSION['Emp_Num'];
                            $paramList['Chguser'] = $_SESSION['Emp_Num'];
                            DynamicInsert($conn, 'stock', $paramList);
                        }
                        $stmt->close();
                    }
                } else
                    throw new Exception("A05 權限不足");
            } else if ($_POST['form'] == "supply") {
                if (checkPermission(null, 'B01') >= 2) {
                    $conn->query("LOCK TABLES `supply` WRITE");


                    $stmt = $conn->prepare("SELECT `Supply_Num` FROM `supply` ORDER BY Supply_Num DESC LIMIT 0,1");
                    if (!$stmt->execute())
                        throw new Exception($stmt->error);
                    $stmt->bind_result($oldId);
                    $stmt->fetch();
                    $stmt->close();



                    $lastDate = date("Ym", strtotime(substr($oldId, 1, 6) . "01"));
                    $lastId = substr($oldId, 7, 3);
                    if ($lastDate == date("Ym"))
                        $serialId = str_pad((int) $lastId + 1, 3, '0', STR_PAD_LEFT);
                    else
                        $serialId = str_pad(1, 3, '0', STR_PAD_LEFT);
                    $id = "S" . date("Ym") . $serialId;


                    $stmt = $conn->prepare("INSERT INTO `supply`(`Supply_Num`, `Supply_Name`, `Supply_Adrs`, `Supply_Tel`, `Supply_Mobi`, `Supply_Respon`, `Cate`, `Adduser`, `Chguser`) VALUES (?,?,?,?,?,?,?,?,?)");
                    $date = date('Y-m-d H:i:s');


                    $paramList[] = $id;
                    $paramList[] = $_POST['Supply_Name'];
                    $paramList[] = $_POST['Supply_Adrs'];
                    $paramList[] = $_POST['Supply_Tel'];
                    $paramList[] = $_POST['Supply_Mobi'];
                    $paramList[] = $_POST['Supply_Respon'];
                    $paramList[] = $_POST['Cate'];
                    $paramList[] = $_SESSION['Emp_Num'];
                    $paramList[] = $_SESSION['Emp_Num'];
                    DynamicBindVariables($stmt, $paramList);


                    if (!$stmt->execute())
                        throw new Exception($stmt->error);

                    $stmt->close();
                } else
                    throw new Exception("B01 權限不足");
            } else if ($_POST['form'] == "material") {
                if (checkPermission(null, 'B02') >= 2) {
                    $conn->query("LOCK TABLES `material`,`stock` WRITE");


                    $stmt = $conn->prepare("SELECT `Mate_Num` FROM `material` WHERE CT_No=? AND CI_No=? ORDER BY Mate_Num DESC LIMIT 0,1");

                    $paramList = array();
                    $paramList[] = $_POST['CT_No'];
                    $paramList[] = $_POST['CI_No'];
                    DynamicBindVariables($stmt, $paramList);
                    if (!$stmt->execute())
                        throw new Exception($stmt->error);

                    $stmt->bind_result($oldId);
                    $stmt->fetch();
                    $stmt->close();
                    $lastId = substr($oldId, 7, 6);
                    if ($lastId !== "")
                        $serialId = str_pad((int) $lastId + 1, 6, '0', STR_PAD_LEFT);
                    else
                        $serialId = str_pad(1, 6, '0', STR_PAD_LEFT);
                    $id = $_POST['CT_No'] .  $_POST['CI_No'] . $serialId;

                    $date = date('Y-m-d');
                    while ($stmt = $conn->prepare("SELECT 1 FROM `stock` WHERE Stk_Date = ? AND Mate_Num=? ")) {
                        $paramList = [];
                        $paramList[] = $date;
                        $paramList[] = $id;
                        DynamicBindVariables($stmt, $paramList);


                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        $SQLresult = $stmt->get_result();
                        if (!$SQLresult->fetch_assoc())
                            break;
                        else if ((int) $serialId + 1 > 999999)
                            throw new Exception("id error");
                        $serialId = str_pad((int) $serialId + 1, 6, '0', STR_PAD_LEFT);
                        $id = $_POST['CT_No'] .  $_POST['CI_No'] . $serialId;
                        $stmt->close();
                    }

                    $paramList = [];
                    $paramList[] = $id;
                    $paramList[] = $_POST['Mate_Name'];
                    $paramList[] = $_POST['CT_No'];
                    $paramList[] = $_POST['CI_No'];
                    $paramList[] = $_POST['Mate_Color'];
                    $paramList[] = $_POST['Safe_Qty'];
                    $paramList[] = $_POST['Mate_Unit'];
                    $paramList[] = $_POST['Supply_Num'];
                    $paramList[] = $_SESSION['Emp_Num'];
                    $paramList[] = $_SESSION['Emp_Num'];

                    $stmt = $conn->prepare("INSERT INTO  `material`(`Mate_Num`, `Mate_Name`, `CT_No`, `CI_No`, `Mate_Color`, `Safe_Qty`, `Mate_Unit`, `Supply_Num`, `Adduser`, `Chguser`) VALUES (?,?,?,?,?,?,?,?,?,?)");

                    DynamicBindVariables($stmt, $paramList);


                    if (!$stmt->execute())
                        throw new Exception($stmt->error);
                    $stmt->close();



                    $stmt = $conn->prepare("INSERT INTO  `stock`(`Mate_Num`, `Stk_Date`, `Stk_Pre`, `Stk_In`, `Stk_Out`, `Stk_Qty`, `Adduser`, `Chguser`) VALUES (?,?,?,?,?,?,?,?)");
                    $paramList = [];
                    $paramList[] = $id;
                    $paramList[] = $date;
                    $paramList[] = 0;
                    $paramList[] = 0;
                    $paramList[] = 0;
                    $paramList[] = 0;
                    $paramList[] = $_SESSION['Emp_Num'];
                    $paramList[] = $_SESSION['Emp_Num'];
                    DynamicBindVariables($stmt, $paramList);

                    if (!$stmt->execute())
                        throw new Exception($stmt->error);
                    $stmt->close();
                } else
                    throw new Exception("B02 權限不足");
            } else if ($_POST['form'] == "purchase") {
                if (checkPermission(null, 'B03') >= 2) {

                    $conn->query("LOCK TABLES `purchase`,`stock` WRITE");


                    $stmt = $conn->prepare("SELECT `Pur_Num` FROM `purchase` ORDER BY Pur_Num DESC LIMIT 0,1");
                    if (!$stmt->execute())
                        throw new Exception($stmt->error);
                    $stmt->bind_result($oldId);
                    $stmt->fetch();
                    $stmt->close();
                    $lastDate = date("Ym", strtotime(substr($oldId, 1, 6) . "01"));
                    $lastId = substr($oldId, 7, 3);
                    if ($lastDate == date("Ym"))
                        $serialId = str_pad((int) $lastId + 1, 3, '0', STR_PAD_LEFT);
                    else
                        $serialId = str_pad(1, 3, '0', STR_PAD_LEFT);
                    $id = "P" . date("Ym") . $serialId;


                    $stmt = $conn->prepare("INSERT INTO  `purchase`(`Pur_Num`, `Pur_Date`, `Mate_Num`, `Supply_Num`, `Pur_Price`, `Pur_Qty`,  `Pur_Amt`, `Adduser`, `Chguser`) VALUES (?,?,?,?,?,?,?,?,?)");
                    $date = date('Y-m-d H:i:s');

                    $Pur_Amt = $_POST['Pur_Price'] * $_POST['Pur_Qty'];
                    $paramList = [];
                    $paramList[] = $id;
                    $paramList[] = $_POST['Pur_Date'];
                    $paramList[] = $_POST['Mate_Num'];
                    $paramList[] = $_POST['Supply_Num'];
                    $paramList[] = $_POST['Pur_Price'];
                    $paramList[] = $_POST['Pur_Qty'];
                    $paramList[] = $Pur_Amt;
                    $paramList[] = $_SESSION['Emp_Num'];
                    $paramList[] = $_SESSION['Emp_Num'];
                    DynamicBindVariables($stmt, $paramList);


                    if (!$stmt->execute())
                        throw new Exception($stmt->error);

                    $stmt->close();



                    $lastRow = null;
                    $stmt = $conn->prepare("SELECT * FROM `stock` WHERE Stk_Date >= ? AND Mate_Num=?  ORDER BY `Stk_Date` ASC");
                    $paramList = [];
                    $paramList[] = $_POST['Pur_Date'];
                    $paramList[] = $_POST['Mate_Num'];
                    DynamicBindVariables($stmt, $paramList);


                    if (!$stmt->execute())
                        throw new Exception($stmt->error);


                    $SQLresult = $stmt->get_result();
                    while ($row = $SQLresult->fetch_assoc()) {
                        $paramList = array();
                        if ($lastRow !== null)
                            $paramList['Stk_Pre'] = (int)$lastRow['Stk_Qty'] + (int)$_POST['Pur_Qty'];
                        else if ($row['Stk_Date'] !== $_POST['Pur_Date'])
                            $paramList['Stk_Pre'] = (int)$row['Stk_Pre'] + (int)$_POST['Pur_Qty'];
                        if ($row['Stk_Date'] === $_POST['Pur_Date'])
                            $paramList['Stk_In'] =  (int)$row['Stk_In'] + (int)$_POST['Pur_Qty'];
                        $paramList['Stk_Qty'] = (int)$row['Stk_Qty'] + (int)$_POST['Pur_Qty'];
                        $paramList['Chguser'] = $_SESSION['Emp_Num'];
                        $where = array();
                        $where['Mate_Num'] = $row['Mate_Num'];
                        $where['Stk_Date'] = $row['Stk_Date'];
                        DynamicUpdate($conn, "stock", $paramList, $where);



                        /*$sql = "UPDATE `stock` SET ";
                        if ($lastRow !== null) {
                            $sql .= " `Stk_Pre`=?, ";
                            $paramList[] = (int)$lastRow['Stk_Qty'] + (int)$_POST['Pur_Qty'];
                        } else if ($row['Stk_Date'] !== $_POST['Pur_Date']) {
                            $sql .= " `Stk_Pre`=?, ";
                            $paramList[] = (int)$row['Stk_Pre'] + (int)$_POST['Pur_Qty'];
                        }
                        if ($row['Stk_Date'] === $_POST['Pur_Date']) {
                            $sql .= " `Stk_In`=?, ";
                            $paramList[] = (int)$row['Stk_In'] + (int)$_POST['Pur_Qty'];
                        }
                        $sql .= " `Stk_Qty`=?, `Chguser`= ? WHERE `Mate_Num`=? AND Stk_Date=?";
                        $paramList[] = (int)$row['Stk_Qty'] + (int)$_POST['Pur_Qty'];
                        $paramList[] = $_SESSION['Emp_Num'];
                        $paramList[] = $row['Mate_Num'];
                        $paramList[] = $row['Stk_Date'];


                        $stmt = $conn->prepare($sql);
                        DynamicBindVariables($stmt, $paramList);



                        if (!$stmt->execute())
                            throw new Exception($stmt->error);*/

                        $lastRow = $row;
                    }
                    $stmt->close();


                    $lastRow = null;
                    $stmt = $conn->prepare("SELECT * FROM `stock` WHERE Mate_Num=? AND Stk_Date<=? ORDER BY `Stk_Date` DESC  LIMIT 0,1");
                    $paramList = [];
                    $paramList[] = $_POST['Mate_Num'];
                    $paramList[] = $_POST['Pur_Date'];
                    DynamicBindVariables($stmt, $paramList);
                    if (!$stmt->execute())
                        throw new Exception($stmt->error);

                    $SQLresult = $stmt->get_result();
                    if ($row = $SQLresult->fetch_assoc()) {
                        $lastRow = $row;
                    }
                    $stmt->close();

                    if ($lastRow === null || $lastRow['Stk_Date'] !== $_POST['Pur_Date']) {


                        if ($lastRow === null) {
                            $lastRow = array();
                            $lastRow['Stk_Qty'] = 0;
                        }


                        $stmt = $conn->prepare("INSERT INTO  `stock`(`Mate_Num`, `Stk_Date`, `Stk_Pre`, `Stk_In`, `Stk_Out`, `Stk_Qty`, `Adduser`, `Chguser`) VALUES (?,?,?,?,?,?,?,?)");

                        $paramList = [];
                        $paramList[] = $_POST['Mate_Num'];
                        $paramList[] = $_POST['Pur_Date'];
                        $paramList[] = $lastRow['Stk_Qty'];
                        $paramList[] = $_POST['Pur_Qty'];
                        $paramList[] = 0;
                        $paramList[] = (int)$lastRow['Stk_Qty'] + (int)$_POST['Pur_Qty'];
                        $paramList[] = $_SESSION['Emp_Num'];
                        $paramList[] = $_SESSION['Emp_Num'];
                        DynamicBindVariables($stmt, $paramList);


                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        $stmt->close();
                    }
                } else
                    throw new Exception("B03 權限不足");
            } else if ($_POST['form'] == "department") {
                if (checkPermission(null, 'C01') >= 2) {



                    $stmt = $conn->prepare("INSERT INTO `department`(`Dep_Num`, `Dep_Name`, `Dep_Supr`, `Adduser`, `Chguser`) VALUES (?,?,?,?,?)");

                    $paramList[] = $_POST['Dep_Num'];
                    $paramList[] = $_POST['Dep_Name'];
                    $paramList[] = $_POST['Dep_Supr'];
                    $paramList[] = $_SESSION['Emp_Num'];
                    $paramList[] = $_SESSION['Emp_Num'];
                    DynamicBindVariables($stmt, $paramList);

                    if (!$stmt->execute())
                        throw new Exception($stmt->error);

                    $stmt->close();
                } else
                    throw new Exception("C01 權限不足");
            } else if ($_POST['form'] == "employee") {
                if (checkPermission(null, 'C02') >= 2) {
                    $conn->query("LOCK TABLES `employee` WRITE");


                    $stmt = $conn->prepare("SELECT `Emp_Num` FROM `employee` ORDER BY `Emp_Num` DESC LIMIT 0,1");
                    $stmt->execute();
                    $stmt->bind_result($oldId);
                    $stmt->fetch();
                    $stmt->close();
                    $lastDate = date("Ym", strtotime(substr($oldId, 1, 6) . "01"));
                    $lastId = substr($oldId, 7, 3);
                    if ($lastDate == date("Ym"))
                        $serialId = str_pad((int) $lastId + 1, 3, '0', STR_PAD_LEFT);
                    else
                        $serialId = str_pad(1, 3, '0', STR_PAD_LEFT);
                    $id = "E" . date("Ym") . $serialId;


                    $stmt = $conn->prepare("INSERT INTO `employee`(`Emp_Num`, `Emp_Name`, `Emp_ID`, `Emp_Addr`, `Emp_Tel`, `Emp_Mobile`, `Emp_Start`, `Emp_Invalid`, `Emp_Level`, `Dep_Num`, `Bran_Num`, `Emp_PSW`, `Emp_Role`, `Adduser`, `Chguser`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

                    $paramList[] = $id;
                    $paramList[] = $_POST['Emp_Name'];
                    $paramList[] = $_POST['Emp_ID'];
                    $paramList[] = $_POST['Emp_Addr'];
                    $paramList[] = $_POST['Emp_Tel'];
                    $paramList[] = $_POST['Emp_Mobile'];
                    $paramList[] = $_POST['Emp_Start'];
                    if($_POST['Emp_Invalid']=="")
                        $paramList[] = NULL;
                    else
                        $paramList[] = $_POST['Emp_Invalid'];
                    $paramList[] = $_POST['Emp_Level'];
                    $paramList[] = $_POST['Dep_Num'];
                    $paramList[] = $_POST['Bran_Num'];
                    $paramList[] = hash('sha3-256', $_POST['Emp_PSW']);
                    $paramList[] = $_POST['Emp_Role'];
                    $paramList[] = $_SESSION['Emp_Num'];
                    $paramList[] = $_SESSION['Emp_Num'];
                    DynamicBindVariables($stmt, $paramList);

                    if (!$stmt->execute())
                        throw new Exception($stmt->error);

                    $stmt->close();
                } else
                    throw new Exception("C02 權限不足");
            } else if ($_POST['form'] == "branch") {
                if (checkPermission(null, 'D01') >= 2) {

                    $stmt = $conn->prepare("INSERT INTO `branch`(`Bran_Num`, `Bran_Name`, `Bran_Start`, `Bran_Addr`, `Bran_Tel`, `Bran_Supr`, `Bran_Depo`, `Bran_Deco`, `Bran_Memo`, `Adduser`, `Chguser`) VALUES (?,?,?,?,?,?,?,?,?,?,?)");



                    $paramList[] = str_pad($_POST['Bran_Num'], 4, '0', STR_PAD_LEFT);
                    $paramList[] = $_POST['Bran_Name'];
                    $paramList[] = $_POST['Bran_Start'];
                    $paramList[] = $_POST['Bran_Addr'];
                    $paramList[] = $_POST['Bran_Tel'];
                    $paramList[] = $_POST['Bran_Supr'];
                    $paramList[] = $_POST['Bran_Depo'];
                    $paramList[] = $_POST['Bran_Deco'];
                    $paramList[] = $_POST['Bran_Memo'];
                    $paramList[] = $_SESSION['Emp_Num'];
                    $paramList[] = $_SESSION['Emp_Num'];
                    DynamicBindVariables($stmt, $paramList);

                    if (!$stmt->execute())
                        throw new Exception($stmt->error);
                    $stmt->close();
                } else
                    throw new Exception("D01 權限不足");
            } else if ($_POST['form'] == "expenditure") {
                if (checkPermission(null, 'D02') >= 2) {

                    if ($stmt = $conn->prepare("INSERT INTO `branchexpenditure`(`Bran_Num`, `EB_Date`, `EB_Cate`, `EB_Amt`, `EB_Msg`,  `Adduser`, `Chguser`) VALUES (?,?,?,?,?,?,?)")) {


                        $paramList[] = $_POST['Bran_Num'];
                        $paramList[] = $_POST['EB_Date'];
                        $paramList[] = $_POST['EB_Cate'];
                        $paramList[] = $_POST['EB_Amt'];
                        $paramList[] = $_POST['EB_Msg'];
                        $paramList[] = $_SESSION['Emp_Num'];
                        $paramList[] = $_SESSION['Emp_Num'];
                        DynamicBindVariables($stmt, $paramList);

                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        $stmt->close();
                    }
                } else
                    throw new Exception("D02 權限不足");
            } else if ($_POST['form'] == "syscodetype") {
                if (checkPermission(null, 'Z01') >= 2) {

                    $stmt = $conn->prepare("INSERT INTO `syscodetype`(`CT_No`, `CT_Name`, `Adduser`, `Chguser`) VALUES (?,?,?,?)");
                    $date = date('Y-m-d');

                    $_POST['CT_No'] = str_pad($_POST['CT_No'], 3, "0", STR_PAD_LEFT);

                    $paramList[] = $_POST['CT_No'];
                    $paramList[] = $_POST['CT_Name'];
                    $paramList[] = $_SESSION['Emp_Num'];
                    $paramList[] = $_SESSION['Emp_Num'];
                    DynamicBindVariables($stmt, $paramList);
                    if (!$stmt->execute())
                        throw new Exception($stmt->error);
                    $stmt->close();
                } else
                    throw new Exception("Z01 權限不足");
            } else if ($_POST['form'] == "syscodeinfo") {
                if (checkPermission(null, 'Z01') >= 2) {

                    $stmt = $conn->prepare("INSERT INTO `syscodeinfo`(`CT_No`, `CI_No`, `CI_Name`, `CI_Value`, `Adduser`, `Chguser`) VALUES (?,?,?,?,?,?)");
                    $date = date('Y-m-d');

                    $_POST['CT_No'] = str_pad($_POST['CT_No'], 3, "0", STR_PAD_LEFT);
                    $_POST['CI_No'] = str_pad($_POST['CI_No'], 3, "0", STR_PAD_LEFT);

                    $paramList[] = $_POST['CT_No'];
                    $paramList[] = $_POST['CI_No'];
                    $paramList[] = $_POST['CI_Name'];
                    if (!isset($_POST['CI_Value']))
                        $paramList[] = "";
                    else
                        $paramList[] = $_POST['CI_Value'];
                    $paramList[] = $_SESSION['Emp_Num'];
                    $paramList[] = $_SESSION['Emp_Num'];
                    DynamicBindVariables($stmt, $paramList);


                    if (!$stmt->execute())
                        throw new Exception($stmt->error);

                    $stmt->close();
                } else
                    throw new Exception("Z01 權限不足");
            } else if ($_POST['form'] == "role") {

                if (checkPermission(null, 'Z02') >= 2) {

                    $sysoprole_stmt = $conn->prepare("INSERT INTO `sysoprole`(`Or_No`, `Or_Name`, `Or_Type`, `Adduser`, `Chguser`) VALUES (?,?,?,?,?)");
                    $_POST['Or_No'] = str_pad($_POST['Or_No'], 3, "0", STR_PAD_LEFT);
                    $_POST['Or_Type'] = str_pad($_POST['Or_Type'], 3, "0", STR_PAD_LEFT);

                    $paramList[] = $_POST['Or_No'];
                    $paramList[] = $_POST['Or_Name'];
                    $paramList[] = $_POST['Or_Type'];
                    $paramList[] = $_SESSION['Emp_Num'];
                    $paramList[] = $_SESSION['Emp_Num'];
                    DynamicBindVariables($sysoprole_stmt, $paramList);
                    if (!$sysoprole_stmt->execute())
                        throw new Exception($sysoprole_stmt->error);
                    $sysoprole_stmt->close();
                    $stmt = $conn->prepare("INSERT INTO `sysoprolebranch`(`Or_No`, `Bran_Num`, `Adduser`, `Chguser`) VALUES (?,?,?,?)");
                    if (isset($_POST['bran_num'])) {

                        foreach ($_POST['bran_num'] as $key => $bran_num) {

                            $paramList = [];
                            $paramList[] = $_POST['Or_No'];
                            $paramList[] = $bran_num;
                            $paramList[] = $_SESSION['Emp_Num'];
                            $paramList[] = $_SESSION['Emp_Num'];

                            DynamicBindVariables($stmt, $paramList);
                            if (!$stmt->execute())
                                throw new Exception($stmt->error);
                        }
                    }
                    $stmt->close();


                    $stmt = $conn->prepare("INSERT INTO `sysoprolefunc`(`Or_No`, `Func_No`, `Func_Right`, `Adduser`, `Chguser`) VALUES  (?,?,?,?,?)");
                    foreach ($_POST['Func_Right'] as $Func_No => $Func_Right) {
                        if ($Func_Right !== '-1') {
                            $paramList = [];
                            $paramList[] = $_POST['Or_No'];
                            $paramList[] = $Func_No;
                            $paramList[] = $Func_Right;
                            $paramList[] = $_SESSION['Emp_Num'];
                            $paramList[] = $_SESSION['Emp_Num'];

                            DynamicBindVariables($stmt, $paramList);
                            if (!$stmt->execute())
                                throw new Exception($stmt->error);
                        }
                    }

                    $stmt->close();
                } else
                    throw new Exception("Z02 權限不足");
            } else
                throw new Exception("form error");
        } else if ($_SERVER['REQUEST_METHOD'] === 'PUT') //update
        {
            $data = array();
            parse_str(file_get_contents('php://input'), $data);

            if (isset($data['form'])) {
                if ($data['form'] == "order") {
                    if (checkPermission(null, 'A01') >= 3) {
                        $conn->query("LOCK TABLES `custorder`,`orderitem` WRITE");
                        $sql = "SELECT * FROM custorder WHERE Order_Num = ?";
                        $paramList = array();
                        $paramList[] =  $data['Order_Num'];
                        $stmt = $conn->prepare($sql);
                        DynamicBindVariables($stmt, $paramList);
                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        $SQLresult = $stmt->get_result();
                        $orderRow = null;
                        if (!$orderRow = $SQLresult->fetch_assoc())
                            throw new Exception("此訂單不存在");
                        $stmt->close();

                        if ($orderRow['Bran_Num'] !== $_SESSION['Bran_Num'] && $_SESSION['role'] !== '000')
                            throw new Exception("非建檔分店人員，不可修改訂單");
                        if ($orderRow['OrderStatus'] === '004')
                            throw new Exception("訂單已完工，不可修改");
                        $params = array();
                        $params['Order_Qty'] = $data['Order_Qty'];
                        $params['Plan_Date'] = $data['Plan_Date'];
                        $params['DeliveryWay'] = $data['DeliveryWay'];
                        $params['Order_Postal'] = $data['Order_Postal'];
                        $params['DeliveryAddr'] = $data['DeliveryAddr'];
                        $params['Chguser'] = $_SESSION['Emp_Num'];

                        if ((int)$orderRow['OrderStatus'] === 0)
                            $params['Order_Deposit'] = $data['Order_Deposit'];

                        $where = array();
                        $where['Order_Num'] = $data['Order_Num'];
                        DynamicUpdate($conn, "custorder", $params, $where);

                        $index = 0;
                        foreach ($data['Item_Num'] as $key => $Item_Num) {
                            $sql = "SELECT * FROM orderitem WHERE Order_Num = ? AND Item_Num = ?";
                            $paramList = array();
                            $paramList[] =  $data['Order_Num'];
                            $paramList[] =  $Item_Num;

                            $stmt = $conn->prepare($sql);

                            DynamicBindVariables($stmt, $paramList);
                            if (!$stmt->execute())
                                throw new Exception($stmt->error);

                            $SQLresult = $stmt->get_result();
                            $itemRow = null;
                            if (!$itemRow = $SQLresult->fetch_assoc())
                                throw new Exception($Item_Num . "品項不存在");
                            $stmt->close();

                            $params = array();;
                            if ((int)$orderRow['OrderStatus'] === 0) {
                                $params['Design_Num'] = $data['Design_Num'][$index];
                                $params['Design_Mate'] = $data['Design_Mate'][$index];
                                $params['Item_Color'] = $data['Item_Color'][$index];
                                $params['Item_BgColor'] = $data['Item_BgColor'][$index];
                                $params['Item_Effect'] = $data['Item_Effect'][$index];
                            }

                            if ((int)$orderRow['OrderStatus'] >= 1 &&  $data['Item_Qty'][$index] < $itemRow['Item_Qty'])
                                throw new Exception("品項數量錯誤");
                            $params['Item_Extra'] = $data['Item_Extra'][$index];
                            $params['Item_EPrice'] = $data['Item_EPrice'][$index];
                            $params['Item_Price'] = $data['Item_Price'][$index];
                            $params['Item_Qty'] = $data['Item_Qty'][$index];
                            $params['Item_PDate'] = $data['Plan_Date'];
                            $params['Item_Amt'] = $data['Item_Amt'][$index];
                            $params['Item_Bside'] = $data['Item_Bside'][$index];
                            $params['Item_Breast'] = $data['Item_Breast'][$index];
                            $params['Item_Spon'] = $data['Item_Spon'][$index];
                            $params['Item_Cup'] = $data['Item_Cup'][$index];
                            $params['Item_Pocket'] = $data['Item_Pocket'][$index];
                            $params['Item_Strap'] = $data['Item_Strap'][$index];
                            $params['Item_Wear'] = $data['Item_Wear'][$index];




                            $where = array();
                            $where['Order_Num'] = $data['Order_Num'];
                            $where['Item_Num'] = $Item_Num;
                            DynamicUpdate($conn, "orderitem", $params, $where);



                            $index++;
                        }
                    } else
                        throw new Exception("A01 權限不足");
                } else if ($data['form'] == "customer") {
                    if (checkPermission(null, 'A02') >= 3) {
                        $sql = "SELECT 1 FROM `customer` A
                                LEFT OUTER JOIN `sysoprolebranch` B ON (A.Bran_Num = B.Bran_Num)
                                WHERE A.Cust_Num = ? AND B.Or_No = ?";
                        $paramList = array();
                        $paramList[] =  $data['Cust_Num'];
                        $paramList[] =  $_SESSION['role'];

                        $stmt = $conn->prepare($sql);

                        DynamicBindVariables($stmt, $paramList);
                        if (!$stmt->execute())
                            throw new Exception($stmt->error);

                        if (!$stmt->get_result()->fetch_assoc() &&  $_SESSION['role'] !== '000')
                            throw new Exception("無此顧客權限");
                        $stmt->close();

                        $paramList = array();
                        $paramList['Cust_Name'] = $data['Cust_Name'];
                        $paramList['Cust_Birth'] = $data['Cust_Birth'];
                        $paramList['Cust_Postal'] = $data['Cust_Postal'];
                        $paramList['Cust_Addr'] = $data['Cust_Addr'];
                        $paramList['Cust_Tel'] = $data['Cust_Tel'];
                        $paramList['Cust_Mobile'] = $data['Cust_Mobile'];
                        $paramList['Cust_Email'] = $data['Cust_Email'];
                        $paramList['Cust_Memo'] = $data['Cust_Memo'];
                        $paramList['Chguser'] = $_SESSION['Emp_Num'];

                        $where = array();
                        $where['Cust_Num'] = $data['Cust_Num'];
                        DynamicUpdate($conn, "customer", $paramList, $where);
                    } else
                        throw new Exception("A02 權限不足");
                } else if ($data['form'] == "measurement") {
                    if (checkPermission(null, 'A03') >= 3) {

                        $sql = "SELECT * FROM custorder 
                                WHERE Cust_Num = ? AND BodyM_Date = ? AND OrderCancel=0 ";


                        $paramList = array();
                        $paramList[] =  $data['Cust_Num'];
                        $paramList[] =  $data['BodyM_Date'];

                        $stmt = $conn->prepare($sql);
                        DynamicBindVariables($stmt, $paramList);

                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        $SQLresult = $stmt->get_result();

                        while ($row = $SQLresult->fetch_assoc())
                            if ((int)$row['OrderStatus'] > 0)
                                throw new Exception("已存在執行中訂單，無法修改");
                        $stmt->close();


                        $paramList = $data;
                        unset($paramList['form']);
                        unset($paramList['Cust_Num']);
                        unset($paramList['BodyM_Date']);

                        $where = array();
                        $where['Cust_Num'] = $data['Cust_Num'];
                        $where['BodyM_Date'] = $data['BodyM_Date'];

                        DynamicUpdate($conn, "custmeasure", $paramList, $where);
                    } else
                        throw new Exception("A03 權限不足");
                } else if ($data['form'] == "working") {
                    if (checkPermission(null, 'A04') >= 3) {

                        if (isset($data['Work_Qty'])) {

                            $conn->query("LOCK TABLES `working`,`orderitem` WRITE");
                            $sql = "SELECT A.Order_Num,A.Item_Num,A.Work_Qty,B.Item_Qty,B.Work_Qty as Item_Work_Qty FROM working A
                                LEFT OUTER JOIN `orderitem` B ON (A.Order_Num = B.Order_Num AND A.Item_Num = B.Item_Num)
                                WHERE A.Work_Num = ? AND A.Work_Status = 0";
                            $paramList = array();
                            $paramList[] =  $data['Work_Num'];
                            $stmt = $conn->prepare($sql);
                            DynamicBindVariables($stmt, $paramList);
                            if (!$stmt->execute())
                                throw new Exception($stmt->error);
                            $SQLresult = $stmt->get_result();
                            $workInfo = null;
                            if ($row = $SQLresult->fetch_assoc())
                                $workInfo = $row;
                            else
                                throw new Exception("無此派工單");
                            $stmt->close();

                            $max = (int)$workInfo['Item_Qty'] - ((int)$workInfo['Item_Work_Qty'] - (int)$workInfo['Work_Qty']);
                            if ((int)$data['Work_Qty'] > $max)
                                throw new Exception("派工件數最多為" . $max);

                            $paramList = array();
                            $paramList['Work_Qty'] =  (int)$workInfo['Item_Work_Qty'] - (int)$workInfo['Work_Qty'] + (int)$data['Work_Qty'];
                            $paramList['Chguser'] = $_SESSION['Emp_Num'];
                            $where = array();
                            $where['Order_Num'] = $workInfo['Order_Num'];
                            $where['Item_Num'] = $workInfo['Item_Num'];
                            DynamicUpdate($conn, "orderitem", $paramList, $where);
                        }

                        $paramList = $data;
                        unset($paramList['form']);
                        if (isset($paramList['Sour_Po']) && $paramList['Sour_Po'] === "")
                            unset($paramList['Sour_Po']);
                        if (isset($paramList['Dest_Po']) && $paramList['Dest_Po'] === "")
                            unset($paramList['Dest_Po']);
                        if (isset($paramList['ProtoM_Num']) && $paramList['ProtoM_Num'] === "")
                            unset($paramList['ProtoM_Num']);
                        if (isset($paramList['Cust_Num']) && $paramList['Cust_Num'] === "")
                            unset($paramList['Cust_Num']);
                        if (isset($paramList['Work_Status']) && $paramList['Work_Status'] == "1") {
                            $paramList['Okay_Date'] = date("Y-m-d");
                        }
                        $where = array();
                        $where['Work_Num'] = $data['Work_Num'];
                        DynamicUpdate($conn, "working", $paramList, $where);
                    } else
                        throw new Exception("A04 權限不足");
                } else if ($data['form'] == "mateusa") {
                    if (checkPermission(null, 'A05') >= 3) {
                        $conn->query("LOCK TABLES `mateusa`,`stock` WRITE");
                        foreach ($data['WU_Item'] as $key => $WU_Item) {
                            $stmt = $conn->prepare("SELECT * FROM `mateusa` WHERE WU_Num=? AND WU_Item=?");
                            $paramList = [];
                            $paramList[] = $data['WU_Num'];
                            $paramList[] = $data['WU_Item'][$key];
                            DynamicBindVariables($stmt, $paramList);
                            if (!$stmt->execute())
                                throw new Exception($stmt->error);
                            $mateusaRow = null;
                            if ($row = $stmt->get_result()->fetch_assoc())
                                $mateusaRow = $row;

                            $stmt = $conn->prepare("SELECT * FROM `stock` WHERE Mate_Num=? AND Stk_Date<=NOW() ORDER BY `Stk_Date` DESC  LIMIT 0,1");
                            $paramList = [];
                            $paramList[] = $mateusaRow['Mate_Num'];
                            DynamicBindVariables($stmt, $paramList);
                            if (!$stmt->execute())
                                throw new Exception($stmt->error);
                            if ($stockRow = $stmt->get_result()->fetch_assoc()) {
                                if ($stockRow['Stk_Date'] === date("Y-m-d")) //今天存在庫存資料
                                {
                                    $paramList = array();
                                    $paramList['Stk_Out'] = (int)$stockRow['Stk_Out'] - (int)$mateusaRow['WU_Qty'] + (int)$data['WU_Qty'][$key];
                                    $paramList['Stk_Qty'] = (int)$stockRow['Stk_Pre'] + (int)$stockRow['Stk_In'] - (int)$paramList['Stk_Out'];
                                    $paramList['Chguser'] = $_SESSION['Emp_Num'];
                                    $where = array();
                                    $where['Mate_Num'] = $mateusaRow['Mate_Num'];
                                    $where['Stk_Date'] = $stockRow['Stk_Date'];
                                    DynamicUpdate($conn, "stock", $paramList, $where);
                                } else {
                                    $paramList = array();
                                    $paramList['Mate_Num'] = $mateusaRow['Mate_Num'];
                                    $paramList['Stk_Date'] = date("Y-m-d");
                                    $paramList['Stk_Pre'] = $stockRow['Stk_Qty'];
                                    $paramList['Stk_In'] = 0;
                                    $paramList['Stk_Out'] = (int)$data['WU_Qty'][$key] - (int)$mateusaRow['WU_Qty'];
                                    $paramList['Stk_Qty'] = (int)$paramList['Stk_Pre'] + (int)$paramList['Stk_In'] - (int)$paramList['Stk_Out'];
                                    $paramList['Adduser'] = $_SESSION['Emp_Num'];
                                    $paramList['Chguser'] = $_SESSION['Emp_Num'];
                                    DynamicInsert($conn, 'stock', $paramList);
                                }


                                $paramList = array();
                                $paramList['WU_Unit'] = $data['WU_Unit'][$key];
                                $paramList['WU_Qty'] = $data['WU_Qty'][$key];
                                $where = array();
                                $where['WU_Num'] = $data['WU_Num'];
                                $where['WU_Item'] = $data['WU_Item'][$key];
                                DynamicUpdate($conn, "mateusa", $paramList, $where);
                            } else
                                throw new Exception("庫存資料不存在");

                            $stmt->close();
                        }
                    } else
                        throw new Exception("A05 權限不足");
                } else if ($data['form'] == "orderstatus") {
                    if (checkPermission(null, 'A06') >= 3) {


                        $paramList = array();
                        $paramList['OrderStatus'] = $data['OrderStatus'];
                        $where = array();
                        $where['Order_Num'] = $data['Order_Num'];
                        DynamicUpdate($conn, "custorder", $paramList, $where);
                    } else
                        throw new Exception("A06 權限不足");
                } else if ($data['form'] == "supply") {
                    if (checkPermission(null, 'B01') >= 3) {

                        $paramList = array();
                        $paramList['Supply_Name'] = $data['Supply_Name'];
                        $paramList['Supply_Adrs'] = $data['Supply_Adrs'];
                        $paramList['Supply_Tel'] = $data['Supply_Tel'];
                        $paramList['Supply_Mobi'] = $data['Supply_Mobi'];
                        $paramList['Supply_Respon'] = $data['Supply_Respon'];
                        $paramList['Cate'] = $data['Cate'];
                        $paramList['Chguser'] = $_SESSION['Emp_Num'];
                        $where = array();
                        $where['Supply_Num'] = $data['Supply_Num'];
                        DynamicUpdate($conn, "supply", $paramList, $where);
                    } else
                        throw new Exception("B01 權限不足");
                } else if ($data['form'] == "material") {
                    if (checkPermission(null, 'B02') >= 3) {
                        $date = date('Y-m-d');

                        if ($stmt = $conn->prepare("UPDATE `material` SET `Mate_Name`=?,`CT_No`=?,`CI_No`=?,`Mate_Color`=?,`Mate_Unit`=?,`Supply_Num`=?,`Chguser`=? WHERE `Mate_Num`= ?")) {


                            $paramList[] = $data['Mate_Name'];
                            $paramList[] = $data['CT_No'];
                            $paramList[] = $data['CI_No'];
                            $paramList[] = $data['Mate_Color'];
                            $paramList[] = $data['Mate_Unit'];
                            $paramList[] = $data['Supply_Num'];
                            $paramList[] = $_SESSION['Emp_Num'];
                            $paramList[] = $data['Mate_Num'];
                            DynamicBindVariables($stmt, $paramList);


                            if (!$stmt->execute())
                                throw new Exception($stmt->error);
                            $stmt->close();
                        } else {
                        }
                    } else
                        throw new Exception("B02 權限不足");
                } else if ($data['form'] == "department") {
                    if (checkPermission(null, 'C01') >= 3) {

                        $sql = "UPDATE `department` SET `Dep_Num`=?,`Dep_Name`=?,`Dep_Supr`=?,`Chguser`=? WHERE `Dep_Num`=?";
                        $paramList[] = $data['Dep_Num'];
                        $paramList[] = $data['Dep_Name'];
                        $paramList[] = $data['Dep_Supr'];
                        $paramList[] = $_SESSION['Emp_Num'];
                        $paramList[] = $data['Dep_Num'];


                        $stmt = $conn->prepare($sql);

                        DynamicBindVariables($stmt, $paramList);
                        if (!$stmt->execute())
                            throw new Exception($stmt->error);

                        $stmt->close();
                    } else
                        throw new Exception("C01 權限不足");
                } else if ($data['form'] == "employee") {
                    if (checkPermission(null, 'C02') >= 3) {

                        $sql = "UPDATE `employee` SET `Emp_Name`=?,`Emp_ID`=?,`Emp_Addr`=?,`Emp_Tel`=?,`Emp_Mobile`=?,`Emp_Start`=?,`Emp_Invalid`=?,`Emp_Level`=?,`Dep_Num`=?,`Bran_Num`=?,`Emp_Role`=?,`Chguser`=? ";
                        $paramList[] = $data['Emp_Name'];
                        $paramList[] = $data['Emp_ID'];
                        $paramList[] = $data['Emp_Addr'];
                        $paramList[] = $data['Emp_Tel'];
                        $paramList[] = $data['Emp_Mobile'];
                        $paramList[] = $data['Emp_Start'];
                        $paramList[] = $data['Emp_Invalid'];
                        $paramList[] = $data['Emp_Level'];
                        $paramList[] = $data['Dep_Num'];
                        $paramList[] = $data['Bran_Num'];
                        $paramList[] = $data['Emp_Role'];
                        $paramList[] = $_SESSION['Emp_Num'];
                        if (isset($data['Emp_PSW'])) {
                            $sql .= " ,`Emp_PSW`=? ";
                            $paramList[] = hash('sha3-256', $data['Emp_PSW']);
                        }
                        $paramList[] = $data['Emp_Num'];
                        $sql .= "WHERE `Emp_Num`=?";


                        $stmt = $conn->prepare($sql);

                        DynamicBindVariables($stmt, $paramList);
                        if (!$stmt->execute())
                            throw new Exception($stmt->error);

                        $stmt->close();
                    } else
                        throw new Exception("C02 權限不足");
                } else if ($data['form'] == "branch") {
                    if (checkPermission(null, 'D01') >= 3) {
                        $stmt = $conn->prepare("UPDATE `branch` SET `Bran_Name`=?,`Bran_Start`=?,`Bran_Addr`=?,`Bran_Tel`=?,`Bran_Supr`=?,`Bran_Depo`=?,`Bran_Deco`=?,`Bran_Memo`=?,`Chguser`=? WHERE `Bran_Num`= ?");


                        $paramList[] = $data['Bran_Name'];
                        $paramList[] = $data['Bran_Start'];
                        $paramList[] = $data['Bran_Addr'];
                        $paramList[] = $data['Bran_Tel'];
                        $paramList[] = $data['Bran_Supr'];
                        $paramList[] = $data['Bran_Depo'];
                        $paramList[] = $data['Bran_Deco'];
                        $paramList[] = $data['Bran_Memo'];
                        $paramList[] = $_SESSION['Emp_Num'];
                        $paramList[] = $data['Bran_Num'];
                        DynamicBindVariables($stmt, $paramList);

                        if (!$stmt->execute())
                            throw new Exception($stmt->error);

                        $stmt->close();
                    } else
                        throw new Exception("D01 權限不足");
                } else if ($data['form'] == "expenditure") {
                    if (checkPermission(null, 'D02') >= 3) {
                        $stmt = $conn->prepare("UPDATE `branchexpenditure` SET `EB_Date`=?,`EB_Cate`=?,`EB_Amt`=?,`EB_Msg`=?,`Chguser`=? WHERE `EB_Id`= ?");


                        $paramList[] = $data['EB_Date'];
                        $paramList[] = $data['EB_Cate'];
                        $paramList[] = $data['EB_Amt'];
                        $paramList[] = $data['EB_Msg'];
                        $paramList[] = $_SESSION['Emp_Num'];
                        $paramList[] = $data['EB_Id'];
                        DynamicBindVariables($stmt, $paramList);

                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        $stmt->close();
                    } else
                        throw new Exception("D02 權限不足");
                } else if ($data['form'] == "syscodetype") {
                    if (checkPermission(null, 'Z01') >= 3) {
                        $date = date('Y-m-d');
                        $stmt = $conn->prepare("UPDATE `syscodetype` SET `CT_Name`=?,`Chguser`=? WHERE `CT_No`= ?");


                        $paramList[] = $data['CT_Name'];
                        $paramList[] = $_SESSION['Emp_Num'];
                        $paramList[] = $data['CT_No'];
                        DynamicBindVariables($stmt, $paramList);


                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        $stmt->close();
                    } else
                        throw new Exception("Z01 權限不足");
                } else if ($data['form'] == "syscodeinfo") {
                    if (checkPermission(null, 'Z01') >= 3) {
                        $date = date('Y-m-d');
                        $stmt = $conn->prepare("UPDATE `syscodeinfo` SET `CI_Name`=?,`CI_Value`=?,`Chguser`=? WHERE `CT_No`= ? AND `CI_No`=?");


                        $paramList[] = $data['CI_Name'];
                        if (!isset($data['CI_Value']))
                            $paramList[] = "";
                        else
                            $paramList[] = $data['CI_Value'];
                        $paramList[] = $_SESSION['Emp_Num'];
                        $paramList[] = $data['CT_No'];
                        $paramList[] = $data['CI_No'];
                        DynamicBindVariables($stmt, $paramList);

                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        $stmt->close();
                    } else
                        throw new Exception("Z01 權限不足");
                } else if ($data['form'] == "role") {
                    if (checkPermission(null, 'Z02') >= 3) {

                        $stmt = $conn->prepare("UPDATE `sysoprole` SET `Or_Name`=?,`Or_Type`=?,`Chguser`=?,Chgtime=? WHERE `Or_No`=?");
                        $paramList = array();



                        $paramList[] = $data['Or_Name'];
                        $paramList[] = $data['Or_Type'];
                        $paramList[] = $_SESSION['Emp_Num'];
                        $paramList[] = date('Y-m-d H:i:s');
                        $paramList[] = $data['Or_No'];
                        DynamicBindVariables($stmt, $paramList);

                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        $stmt->close();
                        $stmt = $conn->prepare("DELETE FROM `sysoprolebranch` WHERE Or_No = ?");

                        $paramList = array();
                        $paramList[] = $data['Or_No'];
                        DynamicBindVariables($stmt, $paramList);

                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        $stmt->close();

                        $stmt = $conn->prepare("INSERT INTO `sysoprolebranch`(`Or_No`, `Bran_Num`, `Adduser`, `Chguser`) VALUES (?,?,?,?)");
                        if (isset($data['bran_num'])) {

                            foreach ($data['bran_num'] as $key => $bran_num) {

                                $paramList = [];
                                $paramList[] = $data['Or_No'];
                                $paramList[] = $bran_num;
                                $paramList[] = $_SESSION['Emp_Num'];
                                $paramList[] = $_SESSION['Emp_Num'];

                                DynamicBindVariables($stmt, $paramList);
                                if (!$stmt->execute())
                                    throw new Exception($stmt->error);
                            }
                        }
                        $stmt->close();




                        $stmt = $conn->prepare("DELETE FROM `sysoprolefunc` WHERE Or_No = ?");

                        $paramList = array();
                        $paramList[] = $data['Or_No'];
                        DynamicBindVariables($stmt, $paramList);

                        if (!$stmt->execute())
                            throw new Exception($stmt->error);

                        $stmt->close();

                        $stmt = $conn->prepare("INSERT INTO `sysoprolefunc`(`Or_No`, `Func_No`, `Func_Right`, `Adduser`, `Chguser`) VALUES  (?,?,?,?,?)");
                        foreach ($data['Func_Right'] as $Func_No => $Func_Right) {
                            if ($Func_Right !== '-1') {
                                $paramList = [];
                                $paramList[] = $data['Or_No'];
                                $paramList[] = $Func_No;
                                $paramList[] = $Func_Right;
                                $paramList[] = $_SESSION['Emp_Num'];
                                $paramList[] = $_SESSION['Emp_Num'];

                                DynamicBindVariables($stmt, $paramList);
                                if (!$stmt->execute())
                                    throw new Exception($stmt->error);
                            }
                        }

                        $stmt->close();
                    } else
                        throw new Exception("Z02 權限不足");
                } else
                    throw new Exception("form error");
            } else
                throw new Exception("form error");
        } else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') //delete
        {

            $data = array();
            parse_str(file_get_contents('php://input'), $data);
            if (isset($data['form'])) {

                if ($data['form'] == "order") {
                    if (checkPermission(null, 'A01') >= 4) {
                        $sql = "SELECT A.*,B.Cust_Name,C.CI_Name as OrderStatus_Name  FROM custorder A 
                                LEFT OUTER JOIN customer B ON (A.Cust_Num = B.Cust_Num)
                                LEFT OUTER JOIN syscodeinfo C ON (C.CT_No = A.OrderStatus_CT AND C.CI_No = A.OrderStatus)
                                WHERE A.Order_Num = ?";
                        $paramList = array();
                        $paramList[] =  $data['Order_Num'];
                        $stmt = $conn->prepare($sql);
                        DynamicBindVariables($stmt, $paramList);
                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        $SQLresult = $stmt->get_result();
                        $row = $SQLresult->fetch_assoc();
                        $stmt->close();
                        $PKs[] = $row['Order_Num'];
                        $PKs[] = $row['Cust_Name'];
                        $PKs[] = $row['OrderStatus_Name'];
                        if ($row['Bran_Num'] !== $_SESSION['Bran_Num'] && $_SESSION['role'] !== '000')
                            throw new Exception("非建檔分店人員，不可修改訂單");
                        if ((int)$row['OrderStatus'] > 0)
                            throw new Exception("訂單執行中，無法刪除");


                        if (!isset($data['check']) || $data['check'] === '0') {
                            $sql = "UPDATE `custorder` SET `OrderCancel`=?,`OrderReason`=? WHERE Order_Num = ?";
                            $paramList = array();
                            $paramList[] = '1';
                            $paramList[] = $data['OrderReason'];
                            $paramList[] = $data['Order_Num'];

                            $stmt = $conn->prepare($sql);
                            DynamicBindVariables($stmt, $paramList);

                            if (!$stmt->execute())
                                throw new Exception($stmt->error);
                            if ($stmt->affected_rows === 0)
                                throw new Exception("影響 0 列");
                            $stmt->close();

                            writeLog($conn, 'A01', '004', $PKs);
                        }
                    } else
                        throw new Exception("A01 權限不足");
                } else if ($data['form'] == "customer") {

                    if (checkPermission(null, 'A02') >= 4) {
                        $sql = "SELECT A.*,B.OrderCancel FROM customer A
                        LEFT OUTER JOIN `custorder` B ON (A.Cust_Num = B.Cust_Num)
                         WHERE A.Cust_Num = ?";
                        $paramList = array();
                        $paramList[] =  $data['id'];
                        $stmt = $conn->prepare($sql);
                        DynamicBindVariables($stmt, $paramList);
                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        $SQLresult = $stmt->get_result();
                        $row = $SQLresult->fetch_assoc();
                        $stmt->close();

                        if ($row['OrderCancel'] === '0')
                            throw new Exception("此顧客資料使用中");

                        $PKs[] = $row['Cust_Num'];
                        $PKs[] = $row['Cust_Name'];


                        $sql = "DELETE A FROM `customer` A
                                LEFT OUTER JOIN `sysoprolebranch` C ON (C.Or_No = ? AND A.Bran_Num = C.Bran_Num)
                                WHERE A.Cust_Num = ?";
                        $paramList = [];
                        $paramList[] = $_SESSION['role'];
                        $paramList[] = $data['id'];
                        if ($_SESSION['role'] !== '000') // !=supervisor
                            $sql .= " AND C.Or_No != NULL ";

                        $stmt = $conn->prepare($sql);
                        DynamicBindVariables($stmt, $paramList);

                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        if ($stmt->affected_rows === 0)
                            throw new Exception("影響 0 列");
                        $stmt->close();



                        //$PKs[] = $data['id'];

                        writeLog($conn, 'A02', '004', $PKs);
                    } else
                        throw new Exception("A02 權限不足");
                } else if ($data['form'] == "measurement") {
                    if (checkPermission(null, 'A03') >= 4) {
                        $conn->query("LOCK TABLES `custorder`,`custmeasure` WRITE");

                        $sql = "SELECT A.*,B.Cust_Name,C.Emp_Name, F.Bran_Name,G.OrderCancel FROM custmeasure A 
                                LEFT OUTER JOIN customer B ON (A.Cust_Num = B.Cust_Num)
                                LEFT OUTER JOIN employee C ON (A.Emp_Num = C.Emp_Num)
                                LEFT OUTER JOIN branch F ON (A.Bran_Num = F.Bran_Num )
                                LEFT OUTER JOIN custorder G ON (A.Cust_Num = G.Cust_Num AND A.BodyM_Date = G.BodyM_Date)
                                WHERE A.Cust_Num = ? AND A.BodyM_Date = ?";
                        $paramList = array();
                        $paramList[] =  $data['Cust_Num'];
                        $paramList[] =  $data['BodyM_Date'];
                        $stmt = $conn->prepare($sql);
                        DynamicBindVariables($stmt, $paramList);
                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        $SQLresult = $stmt->get_result();
                        $row = $SQLresult->fetch_assoc();
                        $stmt->close();

                        if ($row['OrderCancel'] === '0')
                            throw new Exception("此量身資料使用中");

                        $PKs[] = $row['Cust_Num'];
                        $PKs[] = $row['Cust_Name'];
                        $PKs[] = $row['BodyM_Date'];

                        $sql = "SELECT Order_Num FROM custorder WHERE Cust_Num = ? AND BodyM_Date = ? AND OrderCancel=0 ";


                        $paramList = array();
                        $paramList[] =  $data['Cust_Num'];
                        $paramList[] =  $data['BodyM_Date'];

                        $stmt = $conn->prepare($sql);

                        DynamicBindVariables($stmt, $paramList);


                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        $SQLresult = $stmt->get_result();

                        if ($row = $SQLresult->fetch_assoc())
                            throw new Exception("訂單 " . $row['Order_Num'] . " 已使用，無法刪除");
                        $stmt->close();



                        $sql = "DELETE FROM `custmeasure` WHERE Cust_Num = ? AND BodyM_Date = ?";
                        $stmt = $conn->prepare($sql);

                        $paramList = array();
                        $paramList[] = $data['Cust_Num'];
                        $paramList[] = $data['BodyM_Date'];
                        DynamicBindVariables($stmt, $paramList);

                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        if ($stmt->affected_rows === 0)
                            throw new Exception("影響 0 列");
                        $stmt->close();


                        /*$PKs[] = $data['Cust_Num'];
                        $PKs[] = $data['BodyM_Date'];*/

                        writeLog($conn, 'A03', '004', $PKs);
                    } else
                        throw new Exception("A03 權限不足");
                } else if ($data['form'] == "working") {
                    if (checkPermission(null, 'A04') >= 4) {
                        $conn->query("LOCK TABLES `working`,`orderitem` WRITE");
                        $sql = "SELECT A.*,B.CI_Name as Work_Type_Name,C.Emp_Name FROM working A
                                LEFT OUTER JOIN syscodeinfo B ON (A.Type_CT = B.CT_No AND A.Work_Type = B.CI_No)
                                LEFT OUTER JOIN employee C ON (A.Work_Emp = C.Emp_Num)
                                WHERE A.Work_Num = ?";
                        $paramList = array();
                        $paramList[] =  $data['id'];
                        $stmt = $conn->prepare($sql);
                        DynamicBindVariables($stmt, $paramList);
                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        $SQLresult = $stmt->get_result();
                        $row = $SQLresult->fetch_assoc();
                        $stmt->close();

                        $PKs[] = $row['Work_Num'];
                        $PKs[] = $row['Emp_Name'];

                        $sql = "SELECT * FROM orderitem WHERE Order_Num=? AND Item_Num=?";
                        $paramList = array();
                        $paramList[] =  $row['Order_Num'];
                        $paramList[] =  $row['Item_Num'];
                        $stmt = $conn->prepare($sql);
                        DynamicBindVariables($stmt, $paramList);
                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        $SQLresult = $stmt->get_result();
                        $itemInfo = null;
                        if ($row = $SQLresult->fetch_assoc())
                            $itemInfo = $row;
                        else
                            throw new Exception("無此品項");
                        $stmt->close();

                        $paramList = array();
                        $paramList['Work_Qty'] =  (int)$itemInfo['Work_Qty']  - (int)$row['Work_Qty'];
                        $where = array();
                        $where['Order_Num'] = $itemInfo['Order_Num'];
                        $where['Item_Num'] = $itemInfo['Item_Num'];
                        DynamicUpdate($conn, "orderitem", $paramList, $where);


                        $sql = "DELETE FROM `working` WHERE Work_Num = ? AND Work_Status=0";
                        $stmt = $conn->prepare($sql);

                        $paramList = array();
                        $paramList[] = $data['id'];
                        DynamicBindVariables($stmt, $paramList);

                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        if ($stmt->affected_rows === 0)
                            throw new Exception("影響 0 列");
                        $stmt->close();



                        //$PKs[] = $data['id'];
                        writeLog($conn, 'A04', '004', $PKs);
                    } else
                        throw new Exception("權限不足");
                } else if ($data['form'] == "mateusa") {
                    if (checkPermission(null, 'A05') >= 4) {
                        $conn->query("LOCK TABLES `mateusa`,`stock` WRITE");
                        $sql = "SELECT A.*,B.Mate_Name,C.CI_Name FROM `mateusa` A
                                LEFT OUTER JOIN material B ON (A.Mate_Num = B.Mate_Num)
                                LEFT OUTER JOIN syscodeinfo C ON (B.Unit_CT = C.CT_No  AND B.Mate_Unit = C.CI_No)
                                WHERE A.WU_Num = ? AND A.WU_Item = ?";
                        $paramList = array();
                        $paramList[] =  $data['WU_Num'];
                        $paramList[] =  $data['WU_Item'];
                        $stmt = $conn->prepare($sql);
                        DynamicBindVariables($stmt, $paramList);
                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        $SQLresult = $stmt->get_result();
                        $row = $SQLresult->fetch_assoc();
                        $stmt->close();

                        $PKs[] = $row['WU_Num'];
                        $PKs[] = $row['Mate_Name'];
                        $PKs[] = $row['WU_Qty'];
                        $PKs[] = $row['CI_Name'];

                        $stmt = $conn->prepare("SELECT * FROM `stock` WHERE Mate_Num=? AND Stk_Date<=NOW() ORDER BY `Stk_Date` DESC  LIMIT 0,1");
                        $paramList = [];
                        $paramList[] = $row['Mate_Num'];
                        DynamicBindVariables($stmt, $paramList);
                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        if ($stockRow = $stmt->get_result()->fetch_assoc()) {
                            $paramList = array();
                            $paramList['Stk_Out'] = (int)$stockRow['Stk_Out'] - (int)$row['WU_Qty'];
                            $paramList['Stk_Qty'] = (int)$stockRow['Stk_Pre'] + (int)$stockRow['Stk_In'] - (int)$paramList['Stk_Out'];
                            $paramList['Chguser'] = $_SESSION['Emp_Num'];
                            $where = array();
                            $where['Mate_Num'] = $row['Mate_Num'];
                            $where['Stk_Date'] = $stockRow['Stk_Date'];
                            DynamicUpdate($conn, "stock", $paramList, $where);
                        } else
                            throw new Exception("庫存資料不存在");

                        $stmt->close();

                        $sql = "DELETE FROM `mateusa` WHERE WU_Num = ? AND WU_Item = ?";
                        $stmt = $conn->prepare($sql);

                        $paramList = array();
                        $paramList[] = $data['WU_Num'];
                        $paramList[] = $data['WU_Item'];
                        DynamicBindVariables($stmt, $paramList);

                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        if ($stmt->affected_rows === 0)
                            throw new Exception("影響 0 列");
                        $stmt->close();


                        writeLog($conn, 'A05', '004', $PKs);
                    } else
                        throw new Exception("權限不足");
                } else if ($data['form'] == "supply") {
                    if (checkPermission(null, 'B01') >= 4) {
                        $sql = "SELECT * FROM supply WHERE Supply_Num = ?";
                        $paramList = array();
                        $paramList[] =  $data['Supply_Num'];
                        $stmt = $conn->prepare($sql);
                        DynamicBindVariables($stmt, $paramList);
                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        $SQLresult = $stmt->get_result();
                        $row = $SQLresult->fetch_assoc();
                        $stmt->close();

                        $PKs[] = $row['Supply_Num'];
                        $PKs[] = $row['Supply_Name'];

                        $sql = "DELETE FROM `supply` WHERE Supply_Num = ?";
                        $stmt = $conn->prepare($sql);

                        $paramList = array();
                        $paramList[] = $data['Supply_Num'];
                        DynamicBindVariables($stmt, $paramList);

                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        if ($stmt->affected_rows === 0)
                            throw new Exception("影響 0 列");
                        $stmt->close();



                        //$PKs[] = $data['Supply_Num'];

                        writeLog($conn, 'B01', '004', $PKs);
                    } else
                        throw new Exception("權限不足");
                } else if ($data['form'] == "material") {
                    if (checkPermission(null, 'B02') >= 4) {
                        $sql = "SELECT * FROM material WHERE Mate_Num = ?";
                        $paramList = array();
                        $paramList[] =  $data['id'];
                        $stmt = $conn->prepare($sql);
                        DynamicBindVariables($stmt, $paramList);
                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        $SQLresult = $stmt->get_result();
                        $row = $SQLresult->fetch_assoc();
                        $stmt->close();

                        $PKs[] = $row['Mate_Num'];
                        $PKs[] = $row['Mate_Name'];

                        $sql = "DELETE FROM `material` WHERE Mate_Num = ?";
                        $stmt = $conn->prepare($sql);

                        $paramList = array();
                        $paramList[] = $data['id'];
                        DynamicBindVariables($stmt, $paramList);

                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        if ($stmt->affected_rows === 0)
                            throw new Exception("影響 0 列");
                        $stmt->close();



                        //$PKs[] = $data['id'];

                        writeLog($conn, 'B02', '004', $PKs);
                    } else
                        throw new Exception("B01 權限不足");
                } else if ($data['form'] == "purchase") {
                    if (checkPermission(null, 'B03') >= 4) {
                        $sql = "SELECT A.*,B.Mate_Name,E.Supply_Name  FROM purchase A 
                            LEFT OUTER JOIN material B ON (A.Mate_Num = B.Mate_Num)
                            LEFT OUTER JOIN supply E ON (E.Supply_Num = A.Supply_Num)
                            WHERE A.Pur_Num = ?";
                        $paramList = array();
                        $paramList[] =  $data['id'];
                        $stmt = $conn->prepare($sql);
                        DynamicBindVariables($stmt, $paramList);
                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        $SQLresult = $stmt->get_result();
                        $row = $SQLresult->fetch_assoc();
                        $stmt->close();

                        $PKs[] = $row['Pur_Num'];
                        $PKs[] = $row['Mate_Name'];
                        $PKs[] = $row['Supply_Name'];


                        $conn->query("LOCK TABLES `purchase`,`stock` WRITE");

                        $stmt = $conn->prepare("SELECT * FROM `purchase` WHERE Pur_Num = ?");

                        $paramList = array();
                        $paramList[] = $data['id'];
                        DynamicBindVariables($stmt, $paramList);

                        if (!$stmt->execute())
                            throw new Exception($stmt->error);

                        $SQLresult = $stmt->get_result();
                        if ($row = $SQLresult->fetch_assoc())
                            $data = $row;

                        $stmt->close();

                        $stmt = $conn->prepare("DELETE FROM `purchase` WHERE Pur_Num = ?");

                        $paramList = array();
                        $paramList[] = $data['Pur_Num'];
                        DynamicBindVariables($stmt, $paramList);

                        if (!$stmt->execute())
                            throw new Exception($stmt->error);


                        $stmt = $conn->prepare("SELECT * FROM `stock` WHERE Stk_Date >= ? AND Mate_Num=?  ORDER BY `Stk_Date` ASC");
                        $paramList = [];
                        $paramList[] = $data['Pur_Date'];
                        $paramList[] = $data['Mate_Num'];
                        DynamicBindVariables($stmt, $paramList);


                        if (!$stmt->execute())
                            throw new Exception($stmt->error);

                        $SQLresult = $stmt->get_result();
                        $stmt->close();
                        while ($row = $SQLresult->fetch_assoc()) {
                            $paramList = [];
                            $sql = "UPDATE `stock` SET ";

                            if ($row['Stk_Date'] === $data['Pur_Date']) {
                                $sql .= " `Stk_In`=?, ";
                                $paramList[] = (int)$row['Stk_In'] - (int)$data['Pur_Qty'];
                            } else {
                                $sql .= " `Stk_Pre`=?, ";
                                $paramList[] = (int)$row['Stk_Pre'] - (int)$data['Pur_Qty'];
                            }
                            $sql .= " `Stk_Qty`=?, `Chguser`= ? WHERE `Mate_Num`=? AND Stk_Date=?";
                            $paramList[] = (int)$row['Stk_Qty'] - (int)$data['Pur_Qty'];
                            $paramList[] = $_SESSION['Emp_Num'];
                            $paramList[] = $row['Mate_Num'];
                            $paramList[] = $row['Stk_Date'];


                            $stmt = $conn->prepare($sql);
                            DynamicBindVariables($stmt, $paramList);



                            if (!$stmt->execute())
                                throw new Exception($stmt->error);
                        }
                        if ($stmt->affected_rows === 0)
                            throw new Exception("影響 0 列");
                        $stmt->close();

                        //$PKs[] = $data['Pur_Num'];

                        writeLog($conn, 'B03', '004', $PKs);
                    } else
                        throw new Exception("B03 權限不足");
                } else if ($data['form'] == "department") {
                    if (checkPermission(null, 'C01') >= 4) {
                        $sql = "SELECT A.*,B.Emp_Name as Dep_Supr_Name FROM `department` A 
                                LEFT OUTER JOIN employee B ON (A.Dep_Supr = B.Emp_Num)
                                WHERE A.Dep_Num=? ";
                        $paramList = array();
                        $paramList[] =  $data['id'];
                        $stmt = $conn->prepare($sql);
                        DynamicBindVariables($stmt, $paramList);
                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        $SQLresult = $stmt->get_result();
                        $row = $SQLresult->fetch_assoc();
                        $stmt->close();

                        $PKs[] = $row['Dep_Num'];
                        $PKs[] = $row['Dep_Name'];
                        $PKs[] = $row['Dep_Supr_Name'];

                        $sql = "DELETE FROM `department` WHERE Dep_Num = ?";
                        $stmt = $conn->prepare($sql);

                        $paramList = array();
                        $paramList[] = $data['id'];
                        DynamicBindVariables($stmt, $paramList);

                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        if ($stmt->affected_rows === 0)
                            throw new Exception("影響 0 列");
                        $stmt->close();



                        //$PKs[] = $data['id'];

                        writeLog($conn, 'C01', '004', $PKs);
                    } else
                        throw new Exception("C01 權限不足");
                } else if ($data['form'] == "employee") {
                    if (checkPermission(null, 'C02') >= 4 && $data['id'] != 'Admin') {
                        $sql = "SELECT * FROM employee WHERE Emp_Num = ?";
                        $paramList = array();
                        $paramList[] =  $data['id'];
                        $stmt = $conn->prepare($sql);
                        DynamicBindVariables($stmt, $paramList);
                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        $SQLresult = $stmt->get_result();
                        $row = $SQLresult->fetch_assoc();
                        $stmt->close();

                        $PKs[] = $row['Emp_Num'];
                        $PKs[] = $row['Emp_Name'];

                        $sql = "DELETE FROM `employee` WHERE Emp_Num = ?";

                        $stmt = $conn->prepare($sql);

                        $paramList = array();
                        $paramList[] = $data['id'];
                        DynamicBindVariables($stmt, $paramList);

                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        if ($stmt->affected_rows === 0)
                            throw new Exception("影響 0 列");
                        $stmt->close();



                        //$PKs[] = $data['id'];

                        writeLog($conn, 'C02', '004', $PKs);
                    } else
                        throw new Exception("C02 權限不足");
                } else if ($data['form'] == "branch") {
                    if (checkPermission(null, 'D01') >= 4) {
                        $sql = "SELECT * FROM branch WHERE Bran_Num = ?";
                        $paramList = array();
                        $paramList[] =  $data['id'];
                        $stmt = $conn->prepare($sql);
                        DynamicBindVariables($stmt, $paramList);
                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        $SQLresult = $stmt->get_result();
                        $row = $SQLresult->fetch_assoc();
                        $stmt->close();

                        $PKs[] = $row['Bran_Num'];
                        $PKs[] = $row['Bran_Name'];

                        $sql = "DELETE FROM `branch` WHERE Bran_Num = ?";

                        $stmt = $conn->prepare($sql);

                        $paramList = array();
                        $paramList[] = $data['id'];
                        DynamicBindVariables($stmt, $paramList);


                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        if ($stmt->affected_rows === 0)
                            throw new Exception("影響 0 列");
                        $stmt->close();



                        //$PKs[] = $data['id'];

                        writeLog($conn, 'D01', '004', $PKs);
                    } else
                        throw new Exception("D01 權限不足");
                } else if ($data['form'] == "expenditure") {
                    if (checkPermission(null, 'D02') >= 4) {
                        $sql = "SELECT A.*,B.Bran_Name,C.CI_Name as EB_Cate_Name FROM branchexpenditure A 
                            LEFT OUTER JOIN branch B ON (A.Bran_Num = B.Bran_Num)
                            LEFT OUTER JOIN syscodeinfo C ON (C.CT_No = A.EB_CT AND C.CI_No = A.EB_Cate)
                            WHERE A.EB_Id = ?";
                        $paramList = array();
                        $paramList[] =  $data['id'];
                        $stmt = $conn->prepare($sql);
                        DynamicBindVariables($stmt, $paramList);
                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        $SQLresult = $stmt->get_result();
                        $row = $SQLresult->fetch_assoc();
                        $stmt->close();

                        $PKs[] = $row['Bran_Name'];
                        $PKs[] = $row['EB_Cate_Name'];
                        $PKs[] = $row['EB_Msg'];

                        $sql = "DELETE FROM `branchexpenditure` WHERE EB_Id = ?";

                        $stmt = $conn->prepare($sql);

                        $paramList = array();
                        $paramList[] = $data['id'];
                        DynamicBindVariables($stmt, $paramList);

                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        if ($stmt->affected_rows === 0)
                            throw new Exception("影響 0 列");
                        $stmt->close();



                        //$PKs[] = $data['id'];

                        writeLog($conn, 'D02', '004', $PKs);
                    } else
                        throw new Exception("D02 權限不足");
                } else if ($data['form'] == "syscodetype") {
                    if (checkPermission(null, 'Z01') >= 4) {
                        $sql = "SELECT * FROM syscodetype WHERE CT_No = ?";
                        $paramList = array();
                        $paramList[] =  $data['CT_No'];
                        $stmt = $conn->prepare($sql);
                        DynamicBindVariables($stmt, $paramList);
                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        $SQLresult = $stmt->get_result();
                        $row = $SQLresult->fetch_assoc();
                        $stmt->close();

                        $PKs[] = $row['CT_No'];
                        $PKs[] = $row['CT_Name'];

                        $sql = "DELETE FROM `syscodetype` WHERE CT_No = ?";
                        $stmt = $conn->prepare($sql);

                        $paramList = array();
                        $paramList[] = $data['CT_No'];
                        DynamicBindVariables($stmt, $paramList);

                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        if ($stmt->affected_rows === 0)
                            throw new Exception("影響 0 列");
                        $stmt->close();



                        //$PKs[] = $data['CT_No'];

                        writeLog($conn, 'Z01', '004', $PKs);
                    } else
                        throw new Exception("Z01 權限不足");
                } else if ($data['form'] == "syscodeinfo") {
                    if (checkPermission(null, 'Z01') >= 4) {
                        $sql = "SELECT * FROM `syscodeinfo` WHERE CT_No = ? AND CI_No=?";
                        $paramList = array();
                        $paramList[] = $data['CT_No'];
                        $paramList[] = $data['CI_No'];
                        $stmt = $conn->prepare($sql);
                        DynamicBindVariables($stmt, $paramList);
                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        $SQLresult = $stmt->get_result();
                        $row = $SQLresult->fetch_assoc();
                        $stmt->close();

                        $PKs[] = $row['CT_No'];
                        $PKs[] = $row['CI_No'];
                        $PKs[] = $row['CI_Name'];
                        $PKs[] = $row['CI_Value'];

                        $sql = "DELETE FROM `syscodeinfo` WHERE CT_No = ? AND CI_No=?";
                        $stmt = $conn->prepare($sql);

                        $paramList = array();
                        $paramList[] = $data['CT_No'];
                        $paramList[] = $data['CI_No'];
                        DynamicBindVariables($stmt, $paramList);

                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        if ($stmt->affected_rows === 0)
                            throw new Exception("影響 0 列");
                        $stmt->close();



                        /*$PKs[] = $data['CT_No'];
                        $PKs[] = $data['CI_No'];*/

                        writeLog($conn, 'Z01', '004', $PKs);
                    } else
                        throw new Exception("Z01 權限不足");
                } else if ($data['form'] == "role") {
                    if (checkPermission(null, 'Z02') >= 4) {
                        $sql = "SELECT * FROM `sysoprole` WHERE Or_No = ? ";
                        $paramList = array();
                        $paramList[] = $data['id'];
                        $stmt = $conn->prepare($sql);
                        DynamicBindVariables($stmt, $paramList);
                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        $SQLresult = $stmt->get_result();
                        $row = $SQLresult->fetch_assoc();
                        $stmt->close();

                        $PKs[] = $row['Or_No'];
                        $PKs[] = $row['Or_Name'];



                        $stmt = $conn->prepare("DELETE FROM `sysoprolefunc` WHERE Or_No = ?");

                        $paramList = array();
                        $paramList[] = $data['id'];
                        DynamicBindVariables($stmt, $paramList);

                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        $stmt->close();


                        $stmt = $conn->prepare("DELETE FROM `sysoprolebranch` WHERE Or_No = ?");

                        $paramList = array();
                        $paramList[] = $data['id'];
                        DynamicBindVariables($stmt, $paramList);

                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        $stmt->close();


                        $stmt = $conn->prepare("DELETE FROM `sysoprole` WHERE Or_No = ?");

                        $paramList = array();
                        $paramList[] = $data['id'];
                        DynamicBindVariables($stmt, $paramList);

                        if (!$stmt->execute())
                            throw new Exception($stmt->error);
                        if ($stmt->affected_rows === 0)
                            throw new Exception("影響 0 列");
                        $stmt->close();




                        //$PKs[] = $data['id'];

                        writeLog($conn, 'Z02', '004', $PKs);
                    } else
                        throw new Exception("Z02 權限不足");
                } else
                    throw new Exception("form error");
            } else
                throw new Exception("form error");
        } else
            throw new Exception("");
        $conn->commit();
    } else
        throw new Exception("form error");
} catch (Exception $e) {
    if ($conn !== null)
        $conn->rollback();
    $result['status'] = "error";
    if (strpos($e->getMessage(), 'Cannot delete or update a parent row') !== false)
        $result['error'] = "此項目使用中" . "(" . $e->getLine() . ")";
    else
        $result['error'] = $e->getMessage() . "(" . $e->getLine() . ")";
}
if ($conn !== null) {
    $conn->query("UNLOCK TABLES");
    $conn->close();
}
echo json_encode($result);
