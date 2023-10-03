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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
      <div class="overview-boxes">
        <div class="box">
          <div class="right-side">

            <div class="box-topic">แจ้งซ่อม</div>
            <div class="number">
              <?php foreach ($s as $rows) { ?>
                <?= $rows['countpending']; ?>
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
              <?php foreach ($l as $rowl) { ?>
                <?= $rowl['countprogress']; ?>
              <?php } ?>
            </div>
            <div class="indicator">
              <a class="text" href="employee_table_progress.php">More info</a>
            </div>
          </div>
          <i class='bx bx-archive-in cart two'></i>
        </div>

        <div class="box">
          <div class="right-side">

            <div class="box-topic">เสร็จแล้ว</div>
            <div class="number">
              <?php foreach ($r as $rowr) { ?>
                <?= $rowr['countfinish']; ?>
              <?php } ?>
            </div>
            <div class="indicator">
              <a class="text" href="employee_table_success.php">More info</a>
            </div>
          </div>
          <i class='bx bx-archive cart three'></i>
        </div>

        <div class="box">
          <div class="right-side">

            <div class="box-topic">ยกเลิก</div>
            <div class="number">
              <?php foreach ($b as $rowb) { ?>
                <?= $rowb['countcancel']; ?>
              <?php } ?>
            </div>
            <div class="indicator">
              <a class="text" href="employee_table_cancel.php">More info</a>
            </div>
          </div>
          <i class='bx bx-minus-circle cart four'></i>
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
                <th>เวลาที่เสร็จ</th>
                <th>สถานะ</th>
                <th>แบบประเมิน</th>
              </thead>
              <tbody>
                <?php
                $num = 1;
                $stmt = $conn->query("SELECT us.firstname , us.lastname,emp.firstname As empF, emp.lastname As empL, us.tel ,sr.serial_number , sr.serial_name , ty.type_name , po.detail_floor , po.detail_room , bu.building_name , rp.*
                                    FROM repair rp 
                                    inner JOIN users us ON us.id = rp.informer_id
                                    inner JOIN users emp ON emp.id = rp.repairman_id    
                                    inner JOIN serial sr ON sr.id = rp.serial_id
                                    inner JOIN type ty ON ty.id = sr.type_id
                                    inner JOIN positions po ON po.id = sr.position_id
                                    inner JOIN building bu ON bu.id = po.building_id
                                    WHERE repair_status = 'successfully';");
                $stmt->execute();

                $repair = $stmt->fetchAll();
        
                foreach ($repair as $repairs) {
                ?>

                  <tr></tr>
                  <th scope="row"><?php echo $num++; ?></th>
                  <td><?php echo $repairs['firstname'] . ' ' . $repairs['lastname'] . ' <br/>Tel.' . $repairs['tel']; ?></td>
                  <td><?php echo $repairs['type_name'] . '<br/>' . $repairs['serial_name'] . '<br/>SN:' . $repairs['serial_number']; ?></td>
                  <td><?php echo $repairs['building_name'] . '<br/>ชั้น: ' . $repairs['detail_floor'] . '<br/>ห้อง: ' . $repairs['detail_room']; ?></td>
                  <td><?php echo $repairs['detailrepair']; ?></td>
                  <td><?php echo $repairs['date_first']; ?></td>
                  <td><?php echo $repairs['empF'] . ' ' . $repairs['empL'];?></br><?php echo $repairs['date_accept']; ?></td>
                  <td><?php echo $repairs['date_success']; ?></td>
                  <td>
                    <?php if ($repairs['repair_status'] == "pending") {
                        echo "รอดำเนินการ";
                      } elseif ($repairs['repair_status'] == "in progress") {
                        echo "กำลังดำเนินการ";
                      } elseif ($repairs['repair_status'] == "successfully") {
                        echo "เสร็จสิ้น";
                      } else {
                        echo "ยกเลิก";
                      } ?> 
                  </td>
                  <td>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#rating-modal" 
                    data-emp_id=" <?php echo $repairs['repairman_id']; ?> " 
                    data-userid=" <?php echo $_SESSION['employee_login']; ?> " 
                    data-employee=" <?php echo $repairs['empF'] . ' ' . $repairs['empL']; ?> ">ประเมิน</button>
                  </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>

          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="modal fade" id="rating-modal" tabindex="-1" role="dialog" aria-labelledby="rating-modal-label">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="rating-modal-label">ประเมินจากพนักงาน</h4>
        </div>
        <div class="modal-body">
          <form id="rating-form">
            <div class="form-group">
              <label for="employee-name">Employee Name</label>
              <input type="hidden" class="form-control" id="employee-id" readonly>
              <input type="text" class="form-control" id="employee-name" readonly>
              <input type="hidden" class="form-control" id="employee-userid" readonly>
            </div>
            <div class="form-group">
              <label for="rating">Rating</label>
              <select class="form-control" id="rating">
                <option value="1">1 Star</option>
                <option value="2">2 Stars</option>
                <option value="3">3 Stars</option>
                <option value="4">4 Stars</option>
                <option value="5">5 Stars</option>
              </select>
            </div>
            <div class="form-group">
              <label for="comment">Comment</label>
              <textarea class="form-control" id="comment"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#myTable').DataTable();
    });
  </script>

  <script>
    $(function() {
      $('#rating-modal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var employee = button.data('employee');
        var userid = button.data('userid');
        var emp_id = button.data('emp_id');
        var modal = $(this);
        modal.find('.modal-title').text('Rate ' + employee);
        modal.find('#employee-name').val(employee);
        modal.find('#employee-userid').val(userid);
        modal.find('#employee-id').val(emp_id);

      });


      $('#rating-form').on('submit', function(event) {
        event.preventDefault();
        var employee = $('#employee-name').val();
        var emp_id = $('#employee-id').val();
        var userid = $('#employee-userid').val();
        var rating = $('#rating').val();
        var comment = $('#comment').val();
        $.ajax({
          url: 'save_rating.php',
          type: 'post',
          data: {
            employee: employee,
            emp_id: emp_id,
            rating: rating,
            comment: comment,
            userid: userid
          },
          success: function() {
            alert('Rating submitted successfully');
            $('#rating-modal').modal('hide');
            $('#' + employee.toLowerCase().replace(' ', '-') + '-rating').text(rating);
            location.reload();
          },
          error: function() {
            alert('Rating submission failed');
            location.reload();
          }
        });
      });
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