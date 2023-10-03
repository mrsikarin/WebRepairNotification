<?php 
    session_start();
    require_once '../mysql.php';
    if (!isset($_SESSION['employee_login'])) {
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
</head>

<body>
        <?php 

            if (isset($_SESSION['employee_login'])) {
                $employee_id = $_SESSION['employee_login'];
                $stmt = $conn->query("SELECT * FROM users WHERE id = $employee_id");
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
            }
        ?>
<?php
  $stmt = $conn->prepare("SELECT COUNT(id) AS countpending 
                          FROM repair 
                          WHERE repair_status = 'pending';");
  $stmt->execute();
  $s = $stmt->fetchAll();
?>
<?php
  $stmt = $conn->prepare("SELECT COUNT(id) AS countprogress 
                          FROM repair 
                          WHERE repair_status = 'in progress';");
  $stmt->execute();
  $l = $stmt->fetchAll();
?>
<?php
  $stmt = $conn->prepare("SELECT COUNT(id) AS countfinish 
                          FROM repair 
                          WHERE repair_status = 'successfully';");
  $stmt->execute();
  $r = $stmt->fetchAll();
?>
<?php
  $stmt = $conn->prepare("SELECT COUNT(id) AS countcancel 
                          FROM repair 
                          WHERE repair_status = 'cancel';");
  $stmt->execute();
  $b = $stmt->fetchAll();
?>

    <div class="sidebar">
    <div class="logo-details">
      <i class='bx bx-wrench'></i>
      <span class="logo_name">RepairNotify</span>
    </div>
      <ul class="nav-links">
        <?php include 'menu.php';?>
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
          <div class="title">
            ข่าวสาร
          </button>
          </div>
          <div class="sales-details">
          <hr>
          <?php if(isset($_SESSION['error'])) { ?>
                <div class="buttonOK" role="alert">
                    <?php 
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    ?>
                </div>
            <?php } ?>
            <?php if(isset($_SESSION['success'])) { ?>
                <div class="buttonOK" role="alert">
                    <?php 
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                    ?>
                </div>
            <?php } ?>
            <?php if(isset($_SESSION['warning'])) { ?>
                <div class="buttonOK" role="alert">
                    <?php 
                        echo $_SESSION['warning'];
                        unset($_SESSION['warning']);
                    ?>
                </div>
            <?php } ?>
          </div>
        </div>   
      </div>
    </div>
  </section>

  <script>
  let sidebar = document.querySelector(".sidebar");
  let sidebarBtn = document.querySelector(".sidebarBtn");
  sidebarBtn.onclick = function() {
    sidebar.classList.toggle("active");
    if(sidebar.classList.contains("active")){
    sidebarBtn.classList.replace("bx-menu" ,"bx-menu-alt-right");
  }else
    sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
  }
  </script>

</body>
</html>