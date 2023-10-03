<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 

    session_start();
    require_once '../mysql.php';

    if (isset($_POST['positionform'])) {

        $building_id = $_POST['building_id'];
        $detail_floor = $_POST['detail_floor'];
        $detail_room = $_POST['detail_room'];
        $position_status = 'active';
        
        if (empty($detail_floor)) {
            $_SESSION['error'] = 'กรุณากรอกชั้น';
            header("location: admin.php");
        } else if(empty($detail_room)) {
            $_SESSION['error'] = 'กรุณากรอกห้อง';
            header("location: admin.php");
        } else {
            try {

                if (!isset($_SESSION['error'])) {
                    $sql = "INSERT INTO positions(building_id, detail_floor, detail_room, position_status) 
                            VALUES(:building_id, :detail_floor, :detail_room, :position_status)";     

                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":building_id", $building_id);
                    $stmt->bindParam(":detail_floor", $detail_floor);
                    $stmt->bindParam(":detail_room", $detail_room);
                    $stmt->bindParam(":position_status", $position_status);
                    $stmt->execute();

                    $_SESSION['success'] = "เพิ่มสถานที่เรียบร้อยแล้ว";
                    echo "<script>
                        $(document).ready(function() {
                            Swal.fire({
                                title: 'success',
                                text: 'เพิ่มสถานที่เรียบร้อยแล้ว!',
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