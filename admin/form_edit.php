<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
    session_start();
    require_once '../mysql.php';

    if (isset($_GET['formedit'])) {
        $id = $_GET['ser_id2'];

        $admin_id = $_GET['admin_id'];
        $detailrepair = $_GET['detailrepair'];
        $repair_status = $_GET['repair_status'];

        if (empty($detailrepair)) {
            $_SESSION['error'] = 'กรุณากรอกรายละเอียดเพิ่มเติม';
             header("location: admin.php");
        } else {
            try {

                if (!isset($_SESSION['error'])) {
                    $sql = "UPDATE repair 
                            SET admin_id = :admin_id, detailrepair = :detailrepair, repair_status = :repair_status
                            WHERE id = :id";         
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":id", $id);   
                    $stmt->bindParam(":admin_id",$admin_id);
                    $stmt->bindParam(":detailrepair", $detailrepair);
                    $stmt->bindParam(":repair_status", $repair_status);
                    $stmt->execute();

                    $_SESSION['success'] = "แก้ไขข้อมูลแจ้งซ่อมเรียบร้อยแล้ว";
                    echo "<script>
                        $(document).ready(function() {
                            Swal.fire({
                                title: 'success',
                                text: 'แก้ไขข้อมูลแจ้งซ่อมเรียบร้อยแล้ว!',
                                icon: 'success',
                                timer: 5000,
                                showConfirmButton: false
                            });
                        });
                    </script>";
                    header("refresh:2; url=admin_table.php");
                } else {
                    $_SESSION['error'] = "มีบางอย่างผิดพลาด";
                     header("location: admin.php");
                }

            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }

?>