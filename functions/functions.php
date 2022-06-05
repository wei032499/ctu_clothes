<?php
@session_start();
@require_once($_SERVER["DOCUMENT_ROOT"] . "/clothes/ajax/DB.php");
date_default_timezone_set("Asia/Taipei");

function varDumpToString($var) {
    ob_start();
    var_dump($var);
    $result = ob_get_clean();
    return $result;
 }

function DynamicBindVariables($stmt, $params)
{
    if ($params != null) {
        // Generate the Type String (eg: 'issisd')
        $types = '';
        foreach ($params as $param) {
            if (is_int($param)) {
                // Integer
                $types .= 'i';
            } elseif (is_float($param)) {
                // Double
                $types .= 'd';
            } elseif (is_string($param)) {
                // String
                $types .= 's';
            } else {
                // Blob and Unknown
                $types .= 'b';
            }
        }

        // Add the Type String as the first Parameter
        $bind_names[] = $types;

        // Loop thru the given Parameters
        for ($i = 0; $i < count($params); $i++) {
            // Create a variable Name
            $bind_name = 'bind' . $i;
            // Add the Parameter to the variable Variable
            $$bind_name = $params[$i];
            // Associate the Variable as an Element in the Array
            $bind_names[] = &$$bind_name;
        }

        // Call the Function bind_param with dynamic Parameters
        call_user_func_array(array($stmt, 'bind_param'), $bind_names);
    }
    return $stmt;
}

function DynamicInsert($conn, $table, $params)
{
    $paramList = array();
    $sql = "INSERT INTO " . $table . " ( ";
    $sqlValues = "(";
    foreach ($params as $name => $value) {
        $sql .= ($name . " ,");
        $paramList[] = $value;

        $sqlValues .= "?,";
    }
    $sqlValues[strlen($sqlValues) - 1] = ")";
    $sql[strlen($sql) - 1] = ")";
    $sql .= " VALUES " . $sqlValues;

    $stmt = $conn->prepare($sql);
    DynamicBindVariables($stmt, $paramList);
    if (!$stmt->execute())
        throw new Exception($stmt->error);
    $stmt->close();
}

function DynamicUpdate($conn, $table, $params, $where)
{
    $paramList = array();
    $sql = "UPDATE " . $table . " SET ";
    foreach ($params as $name => $value) {
        $sql .= ($name . "=?,");
        $paramList[] = $value;
    }
    $sql[strlen($sql) - 1] = " ";

    $sql .= " WHERE 1 ";
    foreach ($where as $name => $value) {
        $sql .= (" AND " . $name . "=? ");
        $paramList[] = $value;
    }


    $stmt = $conn->prepare($sql);
    DynamicBindVariables($stmt, $paramList);
    if (!$stmt->execute())
        throw new Exception($stmt->error);

    $stmt->close();
}


function checkPermission($bran_num, $func_no)
{
    if (!isset($_SESSION['role']))
        return -1;
    else if ($_SESSION['role'] === '000')
        return 999;
    global $servername;
    global $username;
    global $password;
    global $dbname;
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $conn->query('SET CHARACTER SET utf8');
    $conn->query("SET collation_connection = 'utf8mb4_unicode_ci'");

    $sql = "SELECT `Func_Right` FROM `sysoprolefunc` WHERE 1";
    $paramList = array();
    if (isset($_SESSION['role'])) {
        $sql .= " AND `Or_No` = ? ";
        $paramList[] =  $_SESSION['role'];
    } else {
        $conn->close();
        return -1;
    }
    /*if ($bran_num !== null) {
        $sql .= " AND `bran_num` = ? ";
        $paramList[] =  $bran_num;
    }*/
    if ($func_no !== null) {
        $sql .= " AND `Func_No` = ? ";
        $paramList[] =  $func_no;
    } else {
        $conn->close();
        return -1;
    }
    $sql .= " ORDER BY `Func_Right` DESC";


    if ($stmt = $conn->prepare($sql)) {

        DynamicBindVariables($stmt, $paramList);

        if ($stmt->execute()) {
            $stmt->bind_result($Func_Right);
            if ($stmt->fetch()) {
                $stmt->close();
                $conn->close();
                return (int) $Func_Right;
            }
        }
    }
    $stmt->close();
    $conn->close();
    return -1;
}


function writeLog($conn, $func, $op, $PKs)
{
    //$stmt = $conn->prepare("SELECT `CI_Name` FROM `syscodeinfo` WHERE `CT_No`='001' AND `CI_No`=?");

    $stmt = $conn->prepare("SELECT `CI_Name` FROM `syscodeinfo` WHERE `CT_No`='003' AND `CI_No`=?");

    $paramList = array();
    $paramList[] = $op;
    DynamicBindVariables($stmt, $paramList);
    if ($stmt->execute()) {
        $SQLresult = $stmt->get_result();
        if ($row = $SQLresult->fetch_assoc())
            $msg = $row['CI_Name'];
        $stmt->close();
    } else {
        throw new Exception($stmt->error);
    }
    $msg .= " ";
    foreach ($PKs as $pk)
        $msg .= $pk . " ";

    $stmt = $conn->prepare("INSERT INTO `sysoplog`(`Func_No`, `Op_No`, `Op_Msg`, `Adduser`, `Chguser`) VALUES (?,?,?,?,?)");
    $paramList = [];
    $paramList[] = $func;
    $paramList[] = $op;

    $paramList[] = $msg;
    $paramList[] = $_SESSION['Emp_Num'];
    $paramList[] = $_SESSION['Emp_Num'];

    DynamicBindVariables($stmt, $paramList);
    if (!$stmt->execute())
        throw new Exception($stmt->error);
    $stmt->close();
}
