<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 

    session_start();
    require_once '../mysql.php';

    if (isset($_POST['serialform'])) {
        $type_id = $_POST['type_id'];
        $position_id = $_POST['position_id'];
        $serial_number = $_POST['serial_number'];
        $serial_name = $_POST['serial_name'];
        $serial_status = $_POST['serial_status'];
        $date_first = date('Y-m-d H:i:s');

        
        if (empty($serial_number)) {
            $_SESSION['error'] = 'กรุณากรอกเลขครุภัณฑ์';
            header("location: admin.php");
        } else if(empty($serial_name)) {
            $_SESSION['error'] = 'กรุณากรอกชื่ออุปกรณ์';
            header("location: admin.php");
        } else {
            try {

                if (!isset($_SESSION['error'])) {
                    $sql = "INSERT INTO serial(type_id, position_id, serial_number, serial_name, serial_status, date_first) 
                            VALUES(:type_id, :position_id, :serial_number, :serial_name, :serial_status, :date_first)"; 

                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":type_id", $type_id);
                    $stmt->bindParam(":position_id", $position_id);
                    $stmt->bindParam(":serial_number", $serial_number);
                    $stmt->bindParam(":serial_name", $serial_name);
                    $stmt->bindParam(":serial_status", $serial_status);
                    $stmt->bindParam(":date_first", $date_first);
                    $stmt->execute();

                    $_SESSION['success'] = "เพิ่มอุปกรณ์เรียบร้อยแล้ว";
                    echo "<script>
                         $(document).ready(function() {
                             Swal.fire({
                                 title: 'success',
                                 text: 'เพิ่มอุปกรณ์เรียบร้อยแล้ว!',
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