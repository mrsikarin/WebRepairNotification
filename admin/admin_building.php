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

<div id="id01" class="w3-modal">
        <div class="w3-modal-content w3-animate-opacity">      
        <div class="w3-container">
        <h3 class="mt-4">เพิ่มอาคาร</h3>
        <span onclick="document.getElementById('id01').style.display='none'" 
        class="w3-button w3-display-topright">&times;</span>
        <hr>
            <form action="building_add.php" method="post">
            
            <div class="mb-3">
                <label for="building_name" class="form-label">ชื่ออาคาร</label>
                <input type="text" class="w3-input w3-border" name="building_name">
            </div>

            <button type="submit" name="buildingform" class="buttonOK">ยืนยัน</button>
            </form>
        </div>
    </div>
</div>

<div class="home-content">
<div class="sales-boxes">
    <div class="recent-sales box">
        <div class="title">
            ข้อมูลอาคาร
              <button onclick="document.getElementById('id01').style.display='block'" class="button" title="เพิ่ม"><i class='bx bx-duplicate'></i></button>
        </div>
          <div class="sales-details">
            <hr>
            <table id="myTable">
              <thead>
                <th>ลำดับที่</th>
                <th>ชื่ออาคาร</th>
                <th>แก้ไข/ลบ</th>
              </thead>
            <tbody>
            <?php 
            $num=1;
              $stmt = $conn->query("SELECT * 
                                    FROM building
                                    Where building_status = 'active'");
              $stmt->execute();

              $users = $stmt->fetchAll();
              foreach($users as $user) { 
            ?>
              <tr>
              <th scope="row"><?php echo $num++; ?></th>
                <td><?php echo $user['building_name'] ?></td>
                
                <td>
                  <a href="admin_building_edit.php?id=<?php echo $user['id']; ?>" title="แก้ไข" class="button button4">
                  <i class='bx bx-edit'></i>
                  </a>
                  <a href="building_delete.php?id=<?php echo $user['id'];?>" title="ลบ" class="button button3">
                  <i class='bx bx-eraser'></i>
                  </a>
                </td>
              </tr>
            <?php 
              }
            ?>
            </tbody>
           </table>
          </div>
        </div>
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