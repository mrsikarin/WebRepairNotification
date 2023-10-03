
<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
    session_start();
    require_once '../mysql.php';

    if (isset($_POST['formadd'])) {
        $id = $_POST['informer_id'];
        $serial_id = $_POST['serial_id'];
        $detailrepair = $_POST['detailrepair'];
        $repair_status = $_POST['repair_status'];
        $date_first = date('Y-m-d H:i:s');

        if (empty($detailrepair)) {
            $_SESSION['error'] = 'กรุณากรอกรายละเอียดเพิ่มเติม';
            header("location: employee.php");
        } else {
            try {

                if (!isset($_SESSION['error'])) {
                    $sql = "INSERT INTO repair(informer_id, serial_id, detailrepair, repair_status, date_first) 
                            VALUES(:id, :serial_id, :detailrepair, :repair_status, :date_first)";         
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":id", $id);
                    $stmt->bindParam(":serial_id", $serial_id);
                    $stmt->bindParam(":detailrepair", $detailrepair);
                    $stmt->bindParam(":repair_status", $repair_status);
                    $stmt->bindParam(":date_first", $date_first);
                    $stmt->execute();

                    $_SESSION['success'] = "แจ้งซ่อมเรียบร้อยแล้ว";
                    echo "<script>
                        $(document).ready(function() {
                            Swal.fire({
                                title: 'success',
                                text: 'แจ้งซ่อมเรียบร้อยแล้ว!',
                                icon: 'success',
                                timer: 5000,
                                showConfirmButton: false
                            });
                        });
                    </script>";
                    header("refresh:2; url=employee_table.php");
                } else {
                    $_SESSION['error'] = "มีบางอย่างผิดพลาด";
                    header("location: employee.php");
                }

            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    } 

?>