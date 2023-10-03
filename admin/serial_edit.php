<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 

    session_start();
    require_once '../mysql.php';

    if (isset($_GET['serialform'])) {
        $id = $_GET['ser_id2'];

        $serial_number = $_GET['serial_number'];
        $serial_name = $_GET['serial_name'];
        $serial_status = $_GET['serial_status'];
        $date_edit = date('Y-m-d H:i:s');

        if (empty($serial_number)) {
            $_SESSION['error'] = 'กรุณากรอกเลขครุภัณฑ์';
            header("location: admin.php");
        } else if(empty($serial_name)) {
            $_SESSION['error'] = 'กรุณากรอกชื่ออุปกรณ์';
            header("location: admin.php");
        } else {
            try {

                if (!isset($_SESSION['error'])) {                   
                    $sql = "UPDATE serial 
                            SET serial_number = :serial_number, serial_name = :serial_name, serial_status = :serial_status, date_edit = :date_edit 
                            WHERE id = :id";         
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":id", $id);
                    $stmt->bindParam(":serial_number", $serial_number);
                    $stmt->bindParam(":serial_name", $serial_name);
                    $stmt->bindParam(":serial_status", $serial_status);
                    $stmt->bindParam(":date_edit", $date_edit);
                    $stmt->execute();
                    
                    $_SESSION['success'] = "แก้ไขอุปกรณ์เรียบร้อยแล้ว";
                    echo "<script>
                        $(document).ready(function() {
                            Swal.fire({
                                title: 'success',
                                text: 'แก้ไขอุปกรณ์เรียบร้อยแล้ว!',
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
        }
    }


?>