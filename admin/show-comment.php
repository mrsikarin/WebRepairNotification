<?php
session_start();
require_once '../mysql.php';
if (!isset($_SESSION['admin_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: index.php');
}
$userid = $_GET['id'];
//$userid = 1;
$sql = "SELECT users.firstname , users.lastname , ratings.comment_rating , ratings.rating_value 
        FROM users INNER JOIN ratings ON ratings.users_id = users.id 
        WHERE ratings.emp_id = $userid";
$stmt = $conn->query($sql);
$stmt->execute();

$data = $stmt->fetchAll();


?>


<!DOCTYPE html>
<html>

<head>
    <title>Comment Page</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link href='https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>

</head>

<body>
    <?php
    if (isset($_SESSION['admin_login'])) {
        $admin_id = $_SESSION['admin_login'];
        $stmt = $conn->query("SELECT * 
                              FROM users 
                              WHERE id = $admin_id");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    ?>
    <?php

    if (isset($userid)) {
        $stmtemp = $conn->query("SELECT * 
                                FROM users 
                                WHERE id = $userid");
        $stmtemp->execute();
        $rowemp = $stmtemp->fetch(PDO::FETCH_ASSOC);
    }
    ?>


    <div class="sidebar">
        <div class="logo-details">
            <i class='bx bx-wrench'></i>
            <span class="logo_name">RepairNotify</span>
        </div>
        <ul class="nav-links">
            <?php include 'menu.php'; ?>
        </ul>
    </div>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">Dashboard</span>
            </div>
        </nav>


        <div class="home-content">
            <div class="sales-boxes">
                <div class="recent-sales box">              
                    <h3 class="mt-4">แบบประเมินของ <?php echo " : " . $rowemp['firstname'] . ' ' . $rowemp['lastname'] ?></h3>
                    

                    <table id="myTable">
                        <thead>
                            <tr>
                                <th>ผู้ทำการให้คะแนน</th>
                                <th>คะแนนที่ได้</th>
                                <th>Comment</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $userTable) { ?>
                                <tr>
                                    <td><?php echo $userTable['firstname'] . " " . $userTable['lastname']; ?></td>
                                    <td><?php echo $userTable['rating_value']; ?> </td>
                                    <td><?php if (empty($userTable['comment_rating'])) {
                                            echo "ไม่มีคอมเมนต์";
                                        } else {
                                            echo $userTable['comment_rating'];
                                        } ?> </td>
                                </tr>
                        
                            <?php } ?>
                        </tbody>
                    </table>


                </div>
            </div>


        </div>

    </section>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>

    <script>
        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".sidebarBtn");
        sidebarBtn.onclick = function() {
            sidebar.classList.toggle("active");
            if (sidebar.classList.contains("active")) {
                sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
            } else
                sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
        }
    </script>

</body>

</html>