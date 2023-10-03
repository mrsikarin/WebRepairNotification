<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 

    session_start();
    require_once '../mysql.php';

    if (isset($_GET['positionform'])) {
        $id = $_GET['ser_id2'];
        
        $building_id = $_GET['building_id'];
        $detail_floor = $_GET['detail_floor'];
        $detail_room = $_GET['detail_room'];

        if (empty($detail_floor)) {
            $_SESSION['error'] = 'กรุณากรอกชั้น';
            header("location: admin.php");
        } else if(empty($detail_room)) {
            $_SESSION['error'] = 'กรุณากรอกห้อง';
            header("location: admin.php");
        } else {
            try {

                if (!isset($_SESSION['error'])) {

                    $sql = "UPDATE positions 
                            SET building_id = :building_id, detail_floor = :detail_floor, detail_room = :detail_room 
                            WHERE id = :id";         
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":id", $id); 
                    $stmt->bindParam(":building_id", $building_id);
                    $stmt->bindParam(":detail_floor", $detail_floor);
                    $stmt->bindParam(":detail_room", $detail_room);
                    $stmt->execute();

                    $_SESSION['success'] = "แก้ไขสถานที่เรียบร้อยแล้ว";
                    echo "<script>
                        $(document).ready(function() {
                            Swal.fire({
                                title: 'success',
                                text: 'แก้ไขสถานที่เรียบร้อยแล้ว!',
                                icon: 'success',
                                timer: 5000,
                                showConfirmButton: false
                            });
                        });
                    </script>";
                    header("refresh:2; url=admin_position.php");
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