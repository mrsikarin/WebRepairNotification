<?php
session_start();
    require_once '../mysql.php';
    if (!isset($_SESSION['employee_login'])) {
        $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
        header('location: index.php');
    }

//$employee = $_POST['employee'];
$emp_id = $_POST['emp_id'];
$userid = $_POST['userid'];

$rating = $_POST['rating'];
$comment = $_POST['comment'];

$sql = "INSERT INTO `ratings`(`emp_id`, `users_id`, `comment_rating`, `rating_value`) VALUES ('$emp_id','$userid','$comment','$rating')";
$stmt = $conn->query($sql);

?>