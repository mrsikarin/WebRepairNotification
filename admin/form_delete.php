<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 

    session_start();
    require_once '../mysql.php';

        $id = $_GET['id'];
        $detailcancel = 'ยกเลิกแจ้งซ่อม';
        $date_cancel = date('Y-m-d H:i:s');
        $repair_status = 'cancel';

               
        
        try {

            if (!isset($_SESSION['error'])) {
                $sql = "UPDATE repair 
                SET id = :id, detailcancel = :detailcancel , date_cancel = :date_cancel , repair_status = :repair_status
                WHERE id = :id";         
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":id", $id);
                $stmt->bindParam(":detailcancel", $detailcancel);
                $stmt->bindParam(":date_cancel", $date_cancel);   
                $stmt->bindParam(":repair_status", $repair_status);
                $stmt->execute();

                    $_SESSION['success'] = "ลบข้อมูลแจ้งซ่อมเรียบร้อยแล้ว";
                    echo "<script>
                        $(document).ready(function() {
                            Swal.fire({
                                title: 'success',
                                text: 'ลบข้อมูลแจ้งซ่อมเรียบร้อยแล้ว!',
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

?>