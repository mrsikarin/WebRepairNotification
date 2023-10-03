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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
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
            ข้อมูลผู้ใช้งาน
          </button>
          
          </div>
          <div class="sales-details">
          <hr>
          <form action="employee_profile_db.php" method="POST">

            <div class="mb-3">
                <input type="hidden" class="w3-input w3-border" name="id" aria-describedby="name" value="<?php echo $row['id']; ?>">
            </div>

            <div class="mb-3">
                <label for="firstname" class="form-label">ชื่อ</label>
                <input type="text" class="w3-input w3-border" name="firstname" aria-describedby="name" value="<?php echo $row['firstname']; ?>">
            </div>

            <div class="mb-3">
                <label for="lastname" class="form-label">นามสกุล</label>
                <input type="text" class="w3-input w3-border" name="lastname" aria-describedby="name" value="<?php echo $row['lastname']; ?>">
            </div>

            <div class="mb-3">
                <label for="tel" class="form-label">เบอร์ติดต่อ</label>
                <input type="text" class="w3-input w3-border" name="tel" value="<?php echo $row['tel']; ?>">
            </div>

            <button type="submit" name="userform" class="buttonOK">ยืนยัน</button>

        </form>
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