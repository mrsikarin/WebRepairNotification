<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php

session_start();
require_once '../mysql.php';
  //print_r($_GET);
  if (isset($_GET['successform'])) {
  $id = $_GET['ser_id2']; 

  $detailsuccess = $_GET['detailsuccess'];
  $date_success = date('Y-m-d H:i:s');
  $repair_status = 'successfully';


  try {
    if (!isset($_SESSION['error'])) {
        $sql = "UPDATE repair 
                SET date_success = :date_success, repair_status = :repair_status, detailsuccess = :detailsuccess
                WHERE id = :id";         
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id", $id); 
        $stmt->bindParam(":date_success", $date_success);
        $stmt->bindParam(":repair_status", $repair_status);
        $stmt->bindParam(":detailsuccess", $detailsuccess);
        $stmt->execute();
        
        $_SESSION['success'] = "เรียบร้อยแล้ว";
        echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'success',
                    text: 'จบงานเรียบร้อยแล้ว!',
                    icon: 'success',
                    timer: 5000,
                    showConfirmButton: false
                });
            });
        </script>";
        header("refresh:2; url=repairman_table_success.php");
    } else {
        $_SESSION['error'] = "มีบางอย่างผิดพลาด";
        header("location: repairman.php");
    }
} catch(PDOException $e) {
    echo $e->getMessage();
}
}
?>