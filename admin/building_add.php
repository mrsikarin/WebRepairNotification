<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 

    session_start();
    require_once '../mysql.php';

    if (isset($_POST['buildingform'])) {
        $building_name = $_POST['building_name'];
        $building_status = 'active';

            try {
                if (!isset($_SESSION['error'])) {
                    $sql = "INSERT INTO building(building_name, building_status) 
                            VALUES(:building_name, :building_status)";     

                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":building_name", $building_name);
                    $stmt->bindParam(":building_status", $building_status);
                    $stmt->execute();

                    $_SESSION['success'] = "เพิ่มสถานที่เรียบร้อยแล้ว";
                    echo "<script>
                        $(document).ready(function() {
                            Swal.fire({
                                title: 'success',
                                text: 'เพิ่มอาคารเรียบร้อยแล้ว!',
                                icon: 'success',
                                timer: 5000,
                                showConfirmButton: false
                            });
                        });
                    </script>";
                    header("refresh:2; url=admin_building.php");
                } else {
                    $_SESSION['error'] = "มีบางอย่างผิดพลาด";
                    header("location: admin.php");
                }

            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
?>