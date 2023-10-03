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
<div class="overview-boxes">
        <div class="box">
          <div class="right-side">
            
            <div class="box-topic">แจ้งซ่อม</div>
            <div class="number">
              <?php foreach($s as $rows) { ?>
                <?=$rows['countpending'];?>
              <?php } ?>
            </div>
            <div class="indicator">
              <a class="text" href="employee_table.php">More info</a>
            </div>
          </div>
          <i class='bx bx-package cart'></i>
        </div>

        <div class="box">
          <div class="right-side">
            
            <div class="box-topic">กำลังดำเนินการ</div>
            <div class="number">
            <?php foreach($l as $rowl) { ?>
              <?=$rowl['countprogress'];?>
            <?php } ?>
            </div>
            <div class="indicator">
              <a class="text" href="employee_table_progress.php">More info</a>
            </div>
          </div>
          <i class='bx bx-archive-in cart two' ></i>
        </div>

        <div class="box">
          <div class="right-side">
            
            <div class="box-topic">เสร็จแล้ว</div>
            <div class="number">
              <?php foreach($r as $rowr) { ?>
                <?=$rowr['countfinish'];?>
              <?php } ?>
            </div>
            <div class="indicator">
              <a class="text" href="employee_table_success.php">More info</a>
            </div>
          </div>
          <i class='bx bx-archive cart three' ></i>
        </div>

        <div class="box">
          <div class="right-side">
            
            <div class="box-topic">ยกเลิก</div>
            <div class="number">
              <?php foreach($b as $rowb) { ?>
                <?=$rowb['countcancel'];?>
              <?php } ?>
            </div>
            <div class="indicator">
              <a class="text" href="employee_table_cancel.php">More info</a>
            </div>
          </div>
          <i class='bx bx-minus-circle cart four' ></i>
        </div>
      </div>

      <div class="sales-boxes">
        <div class="recent-sales box">
          <div class="title">
          ข้อมูลแจ้งซ่อม
          </div>
          <hr>
          <div class="sales-details">

            <table id="myTable">
              <thead>
                <th>ลำดับที่</th>
                <th>ชื่อผู้แจ้งซ่อม</th>
                <th>อุปกรณ์</th>
                <th>สถานที่</th>
                <th>รายละเอียด</th>
                <th>เวลาที่แจ้ง</th>
                <th>เวลา/ผู้รับเรื่อง</th>
                <th>สถานะ</th>
              </thead>
              <tbody>
            <?php 
              $num=1;
              $stmt = $conn->query("SELECT us.firstname , us.lastname , us.tel ,sr.serial_number , sr.serial_name , ty.type_name , po.detail_floor , po.detail_room , bu.building_name , rp.*
                                    FROM repair rp 
                                    inner JOIN users us ON us.id = rp.informer_id  
                                    inner JOIN serial sr ON sr.id = rp.serial_id
                                    inner JOIN type ty ON ty.id = sr.type_id
                                    inner JOIN positions po ON po.id = sr.position_id
                                    inner JOIN building bu ON bu.id = po.building_id
                                    WHERE repair_status = 'in progress';");
              $stmt->execute();

              $repair = $stmt->fetchAll();
              foreach($repair as $repairs) { 
            ?>
              <tr>
                <th scope="row"><?php echo $num++; ?></th>
                <td><?php echo $repairs['firstname'].' '. $repairs['lastname'].' <br/>Tel.'. $repairs['tel']; ?></td>
                <td><?php echo $repairs['type_name'] . '<br/>' . $repairs['serial_name'].'<br/>SN:'. $repairs['serial_number'];?></td>
                <td><?php echo $repairs['building_name'].'<br/>ชั้น: '. $repairs['detail_floor'].'<br/>ห้อง: '. $repairs['detail_room'];?></td>
                <td><?php echo $repairs['detailrepair'] ?></td>
                <td><?php echo $repairs['date_first'] ?></td>
                <td><?php if($repairs['repairman_id']=="2"){echo "ถวิต วัฒนโกศล";} else { echo "";}?><br/><?php echo $repairs['date_accept'];?></td>
                <td><?php if($repairs['repair_status']=="pending"){ echo "รอดำเนินการ";} elseif($repairs['repair_status']=="in progress"){ echo "กำลังดำเนินการ";} elseif($repairs['repair_status']=="successfully"){ echo "เสร็จสิ้น";} else{ echo "ยกเลิก";} ?></td>
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