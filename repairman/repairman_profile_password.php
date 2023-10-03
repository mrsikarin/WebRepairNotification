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
            เปลี่ยนรหัสผ่าน            
          </div>
          <div class="sales-details">
            <hr>
          <form action="repairman_password_db.php" method="POST">

            <div class="mb-3">
                <input type="hidden" class="w3-input w3-border" name="id" aria-describedby="name" value="<?php echo $row['id']; ?>">
            </div>

            <div class="mb-3">
                <label for="new password" class="form-label">รหัสผ่านใหม่</label>
                <input type="password" class="w3-input w3-border" name="password">
            </div>
            <div class="mb-3">
                <label for="confirm password" class="form-label">ยืนยันรหัสผ่านใหม่</label>
                <input type="password" class="w3-input w3-border" name="c_password">
            </div>
            <br>
            <button type="submit" name="passwordform" class="buttonOK">ยืนยัน</button>

        </form>
      </div>
    </div>
  </div> 

</section>

<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready( function () {
    $('#myTable').DataTable();
    } );
</script>

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