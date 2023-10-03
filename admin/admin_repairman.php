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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="../style.css">
    
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
              $stmt = $conn->prepare("SELECT COUNT(id) AS countuser 
                                      FROM users
                                      WHERE status = 'active';");
              $stmt->execute();
              $s = $stmt->fetchAll();
            ?>
            <?php
              $stmt = $conn->prepare("SELECT COUNT(id) AS countadmin 
                                      FROM users
                                      WHERE urole = 'admin' AND status = 'active';");
              $stmt->execute();
              $l = $stmt->fetchAll();
            ?>
            <?php
              $stmt = $conn->prepare("SELECT COUNT(id) AS countrepairman 
                                      FROM users 
                                      WHERE urole = 'repairman' AND status = 'active';");
              $stmt->execute();
              $r = $stmt->fetchAll();
            ?>
            <?php
              $stmt = $conn->prepare("SELECT COUNT(id) AS countemp 
                                      FROM users 
                                      WHERE urole = 'employee' AND status = 'active';");
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


<div id="id01" class="w3-modal">
  <div class="w3-modal-content w3-animate-opacity">
    <div class="w3-container">
      <h3 class="mt-4">เพิ่มสมาชิก</h3>
      <span onclick="document.getElementById('id01').style.display='none'" 
      class="w3-button w3-display-topright">&times;</span>
      <hr>   
      <form action="user_add.php" method="post">
            <div class="mb-3">
                <label for="firstname" class="form-label">ชื่อ</label>
                <input type="text" class="w3-input w3-border" name="firstname" aria-describedby="name">
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label">นามสกุล</label>
                <input type="text" class="w3-input w3-border" name="lastname" aria-describedby="name">
            </div>
            <div class="mb-3">
                <label for="tel" class="form-label">เบอร์ติดต่อ</label>
                <input type="text" class="w3-input w3-border" name="tel">
            </div>
            <br>
            <div class="mb-3">
            <label for="sex" class="form-label">เพศ</label>
            <input type="radio" id="sex" name="sex" value="male">
            <label for="sex">ชาย</label>
            <input type="radio" id="sex" name="sex" value="female">
            <label for="sex">หญิง</label><br>
            </div>
            <br>
            <div class="mb-3">
                <label for="email" class="form-label">อีเมล</label>
                <input type="email" class="w3-input w3-border" name="email" aria-describedby="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">รหัสผ่าน</label>
                <input type="password" class="w3-input w3-border" name="password">
            </div>
            <div class="mb-3">
                <label for="confirm password" class="form-label">ยืนยันรหัสผ่าน</label>
                <input type="password" class="w3-input w3-border" name="c_password">
            </div>
            <br>
            <div class="mb-3">
            <label for="urole" class="form-label">ระดับ</label>
              <select name="urole" class="form-control" required>
                <option value="employee">พนักงาน</option>
                <option value="admin">เจ้าหน้าที่</option>
                <option value="repairman">ช่างซ่อม</option>
              </select>
            </div>
            <br>
            <button type="submit" name="signup" class="buttonOK">ยืนยัน</button>
        </form>
    </div>
  </div>
</div>

<div class="home-content"> 
<div class="overview-boxes">
        <div class="box">
          <div class="right-side">
            
            <div class="box-topic">ผู้ใช้งานทั้งหมด</div>
            <div class="number">
              <?php foreach($s as $rows) { ?>
                <?=$rows['countuser'];?>
              <?php } ?>
            </div>
            <div class="indicator">
              <a class="text" href="admin_user.php">More info</a>
            </div>
          </div>
          <i class='bx bx-user-circle cart'></i>
        </div>

        <div class="box">
          <div class="right-side">
            
            <div class="box-topic">แอดมิน</div>
            <div class="number">
            <?php foreach($l as $rowl) { ?>
              <?=$rowl['countadmin'];?>
            <?php } ?>
            </div>
            <div class="indicator">
              <a class="text" href="admin_admin.php">More info</a>
            </div>
          </div>
          <i class='bx bx-user-circle cart two' ></i>
        </div>

        <div class="box">
          <div class="right-side">
            
            <div class="box-topic">ช่างซ่อม</div>
            <div class="number">
              <?php foreach($r as $rowr) { ?>
                <?=$rowr['countrepairman'];?>
              <?php } ?>
            </div>
            <div class="indicator">
              <a class="text" href="admin_repairman.php">More info</a>
            </div>
          </div>
          <i class='bx bx-user-circle cart three' ></i>
        </div>

        <div class="box">
          <div class="right-side">
            
            <div class="box-topic">พนักงาน</div>
            <div class="number">
              <?php foreach($b as $rowb) { ?>
                <?=$rowb['countemp'];?>
              <?php } ?>
            </div>
            <div class="indicator">
              <a class="text" href="admin_employee.php">More info</a>
            </div>
          </div>
          <i class='bx bx-user-circle cart four' ></i>
        </div>
      </div>

<div class="sales-boxes">
    <div class="recent-sales box">
        <div class="title">
            ข้อมูลผู้ใช้
            <div class="box">
              <button onclick="document.getElementById('id01').style.display='block'" class="button a" title="เพิ่ม">
              <i class='bx bx-duplicate'></i>
              </button>
            </div> 
        </div>
        <hr>
          <div class="sales-details">
            <table id="myTable">
              <thead>
                <th>ลำดับที่</th>
                <th>ชื่อ-นามสกุล</th>
                <th>เพศ</th>
                <th>อีเมล</th>
                <th>เบอร์ติดต่อ</th>
                <th>ตำแหน่ง</th>
                <th>แก้ไข/เปลี่ยนรหัสผ่าน/ลบ/ดูประเมิน</th>
              </thead>
            <tbody>
            <?php 
              $num=1;
              $stmt = $conn->prepare("SELECT * ,ROUND(AVG(ratings.rating_value),1) AS AverageRatings 
                                      FROM users 
                                      INNER JOIN ratings ON ratings.emp_id = users.id 
                                      WHERE status = 'active' AND urole = 'repairman'"); 
              $stmt->execute();

              $users = $stmt->fetchAll();
             
              
              foreach($users as $user) { 
            ?>
              <tr>
                <th scope="row"><?php echo $num++; ?></th>
                <td><?php echo $user['firstname'].' '.$user['lastname'] . "  (".$user['AverageRatings']."/5)" ?></td>
                <td><?php if($user['sex']=="male"){ echo "ชาย";} else{ echo "หญิง";}?></td>
                <td><?php echo $user['email'] ?></td>
                <td><?php echo $user['tel'] ?></td>
                <td><?php if($user['urole']=="admin"){ echo "เจ้าหน้าที่";} elseif($user['urole']=="employee"){ echo "พนักงาน";} else{ echo "ช่างซ่อม";}?></td>
                <td>
                  <a href="admin_user_edit.php?id=<?php echo $user[0]; ?>" title="แก้ไข" class="button button4"><i class='bx bx-edit'></i></a>
                  <a href="admin_password.php?id=<?php echo $user[0]; ?>" title="เปลี่ยนรหัสผ่าน" class="button button1"><i class='bx bx-key'></i></a>
                  <a href="user_delete.php?id=<?php echo $user[0]; ?>" title="ลบ" class="button button3"><i class='bx bx-eraser'></i></a>
                  <a href="show-comment.php?id=<?php echo $user[0]; ?>" title="ดูรายละเอียดประเมิน" class="button button2"><i class='bx bx-star'></i></a>            
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