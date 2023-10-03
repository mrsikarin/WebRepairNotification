<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 

    session_start();
    require_once '../mysql.php';

        $id = $_GET['id'];
        $serial_status = 'unuse';
        $date_edit = date('Y-m-d H:i:s');               

        try {
            if (!isset($_SESSION['error'])) {
                $sql = "UPDATE serial 
                        SET serial_status = :serial_status, date_edit = :date_edit 
                        WHERE id = :id";         
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":id", $id);
                $stmt->bindParam(":serial_status", $serial_status);
                $stmt->bindParam(":date_edit", $date_edit);
                $stmt->execute();

                    $_SESSION['success'] = "ลบอุปกรณ์เรียบร้อยแล้ว";
                    echo "<script>
                        $(document).ready(function() {
                            Swal.fire({
                                title: 'success',
                                text: 'ลบอุปกรณ์เรียบร้อยแล้ว!',
                                icon: 'success',
                                timer: 5000,
                                showConfirmButton: false
                            });
                        });
                    </script>";
                    header("refresh:2; url=admin_serial.php");
                } else {
                    $_SESSION['error'] = "มีบางอย่างผิดพลาด";
                    header("location: admin.php");
                }

            } catch(PDOException $e) {
                echo $e->getMessage();
            }
?>