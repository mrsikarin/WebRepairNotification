<?php

session_start();
require_once '../mysql.php';
if (!isset($_SESSION['admin_login'])) {
  $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
  header('location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Page</title>
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <link href='https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="../style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    #chartContainer {
      display: flex;
      justify-content: center;
      height: 100vh;
    }


    table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
  </style>
</head>

<body>
  <?php
  if (isset($_SESSION['admin_login'])) {
    $admin_id = $_SESSION['admin_login'];
    $stmt = $conn->query("SELECT * FROM users WHERE id = $admin_id");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
  }
  ?>
  <?php
  $stmt = $conn->prepare("SELECT COUNT(id) AS total, DATE_FORMAT(date_success, '%Y') AS datesave
                                    FROM repair
                                    WHERE repair_status = 'successfully'
                                    GROUP BY DATE_FORMAT(date_success, '%Y%')
                                    ORDER BY DATE_FORMAT(date_success, '%Y%') DESC");
  $stmt->execute();
  $result = $stmt->fetchAll();

  $datesave = array();
  $total = array();
  foreach ($result as $rs) {
    $datesave[] = "\"" . $rs['datesave'] . "\"";
    $total[] = "\"" . $rs['total'] . "\"";
  }
  $datesave = implode(",", $datesave);
  $total = implode(",", $total);


  $sql = "SELECT COUNT(*) as count_progress FROM repair WHERE repair_status = 'in progress'";
  $result = $conn->query($sql);
  $row = $result->fetch(PDO::FETCH_ASSOC);
  $progress = $row["count_progress"];

  $sql = "SELECT COUNT(*) as count_successfully FROM repair WHERE repair_status = 'successfully'";
  $result = $conn->query($sql);
  $row = $result->fetch(PDO::FETCH_ASSOC);
  $successfully = $row["count_successfully"];

  $sql = "SELECT COUNT(*) as count_pending FROM repair WHERE repair_status = 'pending'";
  $result = $conn->query($sql);
  $row = $result->fetch(PDO::FETCH_ASSOC);
  $pending = $row["count_pending"];


  $query = "SELECT date_first, COUNT(date_first) AS totol, DATE_FORMAT(date_first, '%Y') AS date_first 
  FROM repair GROUP BY DATE_FORMAT(date_first, '%Y%') ORDER BY DATE_FORMAT(date_first, '%Y') DESC;";
  $result = $conn->query($query);
  $datesave = array();
  $totol = array();

  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $datesave[] = "\"" . $row['date_first'] . "\"";
    $totol[] = "\"" . $row['totol'] . "\"";
  }
  $datesave = implode(",", $datesave);
  $totol = implode(",", $totol);
  //print_r($datesave);
  //print_r($totol);

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
          <div class="title">สถิติ</div>
          <div class="sales-details">
            <hr>
            <div class="container">
              <div class="row">
                <div class="col-md-12">
                  <br>
                  <h2 align="left" style="margin-top: 20px"> กราฟ </h2>
                  <a href="admin.php" class="btn btn-outline-primary">หน้าแรก</a>
                  <a href="admin.php?p=daily" class="btn btn-info">รายวัน</a>
                  <a href="admin.php?p=monthy" class="btn btn-success">รายเดือน</a>
                  <a href="admin.php?p=yearly" class="btn btn-warning">รายปี</a>
                  <?php
                  $p = (isset($_GET['p']) ? $_GET['p'] : '');
                  if ($p == 'daily') {
                    include('g_daily.php');
                  } elseif ($p == 'monthy') {
                    include('g_monthy.php');
                  } elseif ($p == 'yearly') {
                    include('g_yearly.php');
                  } else {
                    include('g_daily.php');
                  }
                  ?>


                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </section>


  <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
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