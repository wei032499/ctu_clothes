<?php
session_start();
require_once("./DB.php");
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->query('SET CHARACTER SET utf8');
$conn->query("SET collation_connection = 'utf8mb4_unicode_ci'");
if ($_POST['form'] == "account") {
    $result = array();
    if ($stmt = $conn->prepare("SELECT A.`Emp_Num`,A.`Emp_Name`,A.`Bran_Num`,A.`Emp_PSW`,A.`Emp_Role`,B.`Bran_Name`,C.`Or_Name` FROM `employee` A
                                LEFT OUTER JOIN `branch` B ON (A.Bran_Num = B.Bran_Num)
                                LEFT OUTER JOIN `sysoprole` C ON (A.Emp_Role = C.Or_No)
                                WHERE `Emp_Num`=? AND (A.Emp_Invalid>NOW() OR A.Emp_Invalid is NULL) AND (A.Emp_Start<=NOW() OR A.Emp_Start is NULL)")) {
        $_POST['password'] = hash('sha3-256', $_POST['password']);
        if (isset($_POST['account'])) {
            $stmt->bind_param("s", $_POST['account']);
            if ($stmt->execute()) {
                $stmt->bind_result($id, $name, $Bran_Num, $password, $role, $Bran_Name, $Or_Name);
                if ($stmt->fetch()) {
                    $stmt->close();
                    if ($password === $_POST['password']) {
                        $result['data'][] = array('role' =>  $role);
                        $_SESSION['Emp_Num'] = $_POST['account'];
                        $_SESSION['name'] = $name;
                        $_SESSION['role'] = $role;
                        $_SESSION['Or_Name'] = $Or_Name;
                        $_SESSION['Bran_Num'] = $Bran_Num;
                        $_SESSION['Bran_name'] = $Bran_Name;
                    } else {
                        if (!isset($_SESSION['loginErrorTime']))
                            $_SESSION['loginErrorTime'] = 1;
                        else
                            $_SESSION['loginErrorTime'] = ($_SESSION['loginErrorTime'] + 1) % 3;
                        $result['error'] = "帳號或密碼錯誤";

                        if ($_SESSION['loginErrorTime'] === 0) {
                            if ($stmt = $conn->prepare("INSERT INTO `sysoplog`( `Op_Msg`,`Adduser`) VALUES (?,?)")) {
                                $msg = "帳號" . $_POST["account"] . "密碼錯誤3次";
                                $user = "SYSTEM";
                                $stmt->bind_param("ss", $msg, $user);
                                $stmt->execute();
                                $stmt->close();
                            }
                        }
                    }
                } else {
                    $stmt->close();
                    $result['error'] = "無此帳號";
                }
            } else
                $result['error'] = $stmt->error;
        } else
            $result['error'] = "NULL";
    } else
        $result['error'] = "SQL_error";
    if (!array_key_exists('error', $result))
        $conn->commit();
    echo json_encode($result);
}
/*if ($_POST['form'] == "account") {
    $connection = new PDO('mysql:host=' . $servername . ';dbname=' . $dbname . ';charset=utf8', $username, $password);
    if ($stmt1 = $connection->prepare("LOCK TABLES `account` WRITE")) {
        if ($stmt1->execute()) {
            $result['data'] = array();



            if ($stmt2 = $connection->prepare("SELECT `permission` FROM `account` WHERE `ID`=:ID AND `password`=:pwd")) {


                if ($stmt2->execute(array('ID' => $_POST['account'], 'pwd' => $_POST['password']))) {
                    while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                        $result['data'][] = array('permission' =>  $row['permission']);
                        $_SESSION['Emp_Num'] = $_POST['account'];
                        $_SESSION['permission'] = $row['permission'];
                    }
                } else
                    $result['error'] = $stmt2->error;
            } else
                $result['error'] = "SQL_error";


            if ($stmt3 = $connection->prepare("UNLOCK TABLES")) {
                if (!$stmt3->execute())
                    $result['error'] = $stmt3->error;
            } else
                $result['error'] = "SQL_error(unlock table)";
        } else
            $result['error'] = $stmt1->error;
    } else
        $result['error'] = "SQL_error(lock table)";
    echo json_encode($result);
}*/
