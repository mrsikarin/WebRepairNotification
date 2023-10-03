<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php

session_start();
require_once '../mysql.php';
  //print_r($_GET);
  $id = $_GET['id']; 

  $repairman_id = $_GET['repairman_id'];
  $date_accept = date('Y-m-d H:i:s');
  $repair_status = 'in progress';

  try {
    if (!isset($_SESSION['error'])) {
        $sql = "UPDATE repair 
                SET repairman_id = :repairman_id, date_accept = :date_accept, repair_status = :repair_status
                WHERE id = :id";         
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id", $id); 
        $stmt->bindParam(":repairman_id", $repairman_id);
        $stmt->bindParam(":date_accept", $date_accept);
        $stmt->bindParam(":repair_status", $repair_status);
        $stmt->execute();
        
        $_SESSION['success'] = "เรียบร้อยแล้ว";
        echo "<script>
                        $(document).ready(function() {
                            Swal.fire({
                                title: 'success',
                                text: 'รับเรื่องเรียบร้อยแล้ว!',
                                icon: 'success',
                                timer: 5000,
                                showConfirmButton: false
                            });
                        });
                    </script>";
                    header("refresh:2; url=repairman_table_progress.php");
    } else {
        $_SESSION['error'] = "มีบางอย่างผิดพลาด";
        header("location: repairman.php");
    }
} catch(PDOException $e) {
    echo $e->getMessage();
}

?>