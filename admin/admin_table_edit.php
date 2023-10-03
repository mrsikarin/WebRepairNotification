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
        <?php 
        if(isset($_GET['id'])){
        $id = $_GET['id'];
        $query = "SELECT us.firstname , us.lastname , us.tel ,sr.serial_number , sr.serial_name , ty.type_name , po.detail_floor , po.detail_room , bu.building_name , rp.*
                  FROM repair rp 
                  inner JOIN users us ON us.id = rp.informer_id 
                  inner JOIN serial sr ON sr.id = rp.serial_id
                  inner JOIN type ty ON ty.id = sr.type_id
                  inner JOIN positions po ON po.id = sr.position_id
                  inner JOIN building bu ON bu.id = po.building_id
                  WHERE rp.id=$id";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $rowx = $stmt->fetch(PDO::FETCH_ASSOC);
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
          <div class="title">แก้ไขข้อมูล</i></div>
          <hr>
          <div class="sales-details">
          
          <form action="form_edit.php" method="GET">
            <input type="hidden" name="ser_id2" value="<?php echo $_GET['id'];?>">
            <input type="hidden" class="w3-input w3-border" name="user_id" value="<?php echo $rowx['id'];?>" readonly>
            
            <div class="mb-3">
              <label class="form-label">ผู้แจ้งซ่อม</label>
              <input type="text" class="w3-input w3-border" value="<?php echo $rowx['firstname'] . ' ' . $rowx['lastname'] ?>" readonly>
            </div>
            
            <div class="mb-3">           
              <label for="serial_id" class="form-label">อุปกรณ์</label>
              <input type="text" class="w3-input w3-border" value="<?php echo $rowx['serial_name'] . ' Serial:' . $rowx['serial_number'] ?>" readonly>  
            </div>
      
            <div class="mb-3">
              <label for="positions_id" class="form-label">สถานที่</label>
              <input type="text" class="w3-input w3-border" value="<?php echo $rowx['building_name'] . ' ชั้น:' . $rowx['detail_floor'] . ' ห้อง:' . $rowx['detail_room'] ?>" readonly>
            </div>
            
            <div class="mb-3">
              <label for="r_status" class="form-label">สถานะ</label>
              <select name="r_status" class="form-control" required>
                <option value="pending">รอดำเนินการ</option>
                <option value="in progress">กำลังดำเนินการ</option>
                <option value="cancel">ยกเลิก</option>
                <option value="successfully">เสร็จสิ้น</option>
              </select>
            </div>
            
            <div class="mb-3">
              <label for="detailrepair" class="form-label">รายละเอียด</label>
              <input type="text" class="w3-input w3-border" name="detailrepair" value="<?= $rowx['detailrepair'];?>">
            </div>

            <button type="submit" name="formedit" class="buttonOK" >ยืนยัน</button>
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


