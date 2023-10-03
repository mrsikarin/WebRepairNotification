<?php 

    session_start();
    require_once '../mysql.php';
    if (!isset($_SESSION['repairman_login'])) {
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
            if (isset($_SESSION['repairman_login'])) {
                $repairman_id = $_SESSION['repairman_login'];
                $stmt = $conn->query("SELECT * FROM users WHERE id = $repairman_id");
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
            }
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
            ลงรายเอียดการซ่อม
          </div>
          <div class="sales-details">
            <hr>
            <form action="repairman_success.php" method="GET">

            <div class="mb-3">
                <label class="form-label">ชื่อ</label>
                <input type="text" class="w3-input w3-border" value="<?php echo $row['firstname'] . ' ' . $row['lastname'] ?>"readonly>
            </div>
            <br>
            <div class="mb-3">
                <input type="hidden" name="ser_id2" value="<?php echo $_GET['id'];?>">
            </div>

            <div class="mb-3">
                <label for="detailsuccess" class="form-label">รายละเอียด</label>
                <input type="textarea" class="w3-input w3-border" name="detailsuccess">
            </div>

            <button type="submit" name="successform" class="buttonOK">ยืนยัน</button>

            </form>
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