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
            ข้อมูลอุปกรณ์
          </div>
          <hr>
          <div class="sales-details">
          <table id="myTable">
              <thead>
                <th>#</th>
                <th>อุปกรณ์</th>
                <th>สถานะ</th>
                <th>เวลา</th>
              </thead>
            <tbody>
            <?php 
            $num=1;
              $stmt = $conn->query("SELECT se.* , ty.type_name , po.detail_floor , po.detail_room , bu.building_name
                                    FROM serial se
                                    INNER JOIN type ty ON ty.id = se.type_id
                                    INNER JOIN positions po ON po.id = se.position_id 
                                    INNER JOIN building bu ON bu.id = po.building_id
                                    WHERE se.serial_status = 'use'");
              $stmt->execute();

              $users = $stmt->fetchAll();
              foreach($users as $user) { 
            ?>
              <tr>
              <th scope="row"><?php echo $num++; ?></th>
                <td><?php echo $user['type_name'].' - '.$user['serial_name'].' - Serial:'.$user['serial_number'].'<br/>'.$user['building_name'].' ชั้น: '.$user['detail_floor'].' ห้อง: '.$user['detail_room'] ?></td>
                <td><?php if($user['serial_status']=='use'){echo 'ใช้งาน';} elseif($user['serial_status']=='repair notifi'){echo 'แจ้งซ่อม';} else {echo 'ไม่ได้ใช้งาน';} ?></td>
                <td><?php echo $user['date_first'] ?></td>
              </tr>
            <?php 
              }
            ?>
            </tbody>
           </table>
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


