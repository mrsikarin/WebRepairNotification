<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 

    session_start();
    require_once '../mysql.php';

        $id = $_GET['id'];

        $date_delete = date('Y-m-d H:i:s'); 
        $status = 'inactive';       

        try {
                if (!isset($_SESSION['error'])) {
                    $sql = "UPDATE users 
                    SET date_delete = :date_delete, status = :status
                    WHERE id = :id"; 

                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":id", $id); 
                    $stmt->bindParam(":date_delete", $date_delete);
                    $stmt->bindParam(":status", $status);
                    $stmt->execute();                                             

                    $_SESSION['success'] = "ลบผู้ใช้งานเรียบร้อยแล้ว";
                    echo "<script>
                        $(document).ready(function() {
                            Swal.fire({
                                title: 'success',
                                text: 'ลบผู้ใช้งานเรียบร้อยแล้ว!',
                                icon: 'success',
                                timer: 5000,
                                showConfirmButton: false
                            });
                        });
                    </script>";
                    header("refresh:2; url=admin_user.php");
                } else {
                    $_SESSION['error'] = "มีบางอย่างผิดพลาด";
                    header("location: admin.php");
                }
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
?>