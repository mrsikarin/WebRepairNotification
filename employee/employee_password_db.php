<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 

    session_start();
    require_once '../mysql.php';

    if (isset($_POST['passwordform'])) {
        $id = $_POST['id'];
        $password = $_POST['password'];
        $c_password = $_POST['c_password'];
        $date_edit = date('Y-m-d H:i:s');

        if (empty($password)) {
            $_SESSION['error'] = 'กรุณากรอกรหัสผ่าน';
            header("location: employee.php");
        } else if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
            $_SESSION['error'] = 'รหัสผ่านต้องมีความยาวระหว่าง 5 ถึง 20 ตัวอักษร';
            header("location: employee.php");
        } else if (empty($c_password)) {
            $_SESSION['error'] = 'กรุณายืนยันรหัสผ่าน';
            header("location: employee.php");
        } else if ($password != $c_password) {
            $_SESSION['error'] = 'รหัสผ่านไม่ตรงกัน';
            header("location: employee.php");
        } else {
            try {
                if (!isset($_SESSION['error'])) {
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    $sql = "UPDATE users 
                            SET password = :password, date_edit = :date_edit
                            WHERE id = :id";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":id", $id);
                    $stmt->bindParam(":date_edit", $date_edit);
                    $stmt->bindParam(":password", $passwordHash);
                    $stmt->execute();

                    $_SESSION['success'] = "เปลี่ยนรหัสผ่านเรียบร้อยแล้ว!";
                    echo "<script>
                        $(document).ready(function() {
                            Swal.fire({
                                title: 'success',
                                text: 'เปลี่ยนรหัสผ่านเรียบร้อยแล้ว!',
                                icon: 'success',
                                timer: 5000,
                                showConfirmButton: false
                            });
                        });
                    </script>";
                    header("refresh:2; url=employee_profile.php");
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


    


