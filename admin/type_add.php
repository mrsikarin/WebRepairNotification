<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 

    session_start();
    require_once '../mysql.php';

    if (isset($_POST['typeform'])) {
        $type_name = $_POST['type_name'];
        $type_status = 'active';

        if (empty($type_name)) {
            $_SESSION['error'] = 'กรุณากรอกชื่อประเภท';
            header("location: admin.php");
        } else {
            try {

                if (!isset($_SESSION['error'])) {
                    $sql = "INSERT INTO type(type_name, type_status) 
                            VALUES(:type_name, :type_status)";     
                                
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":type_name", $type_name);
                    $stmt->bindParam(":type_status", $type_status);
                    $stmt->execute();

                    $_SESSION['success'] = "เพิ่มประเภทเรียบร้อยแล้ว";
                    echo "<script>
                        $(document).ready(function() {
                            Swal.fire({
                                title: 'success',
                                text: 'เพิ่มประเภทเรียบร้อยแล้ว!',
                                icon: 'success',
                                timer: 5000,
                                showConfirmButton: false
                            });
                        });
                    </script>";
                    header("refresh:2; url=admin_type.php");
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