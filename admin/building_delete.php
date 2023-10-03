<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 

    session_start();
    require_once '../mysql.php';

        $id = $_GET['id'];

        $building_status = 'inactive';

        try {

            if (!isset($_SESSION['error'])) {
                    $sql = "UPDATE building 
                            SET building_status = :building_status
                            WHERE id = :id";

                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":id", $id);
                    $stmt->bindParam(":building_status", $building_status);
                    $stmt->execute();

                    $_SESSION['success'] = "ลบอาคารเรียบร้อยแล้ว";
                    echo "<script>
                        $(document).ready(function() {
                            Swal.fire({
                                title: 'success',
                                text: 'ลบอาคารเรียบร้อยแล้ว!',
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
?>