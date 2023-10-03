<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 

    session_start();
    require_once '../mysql.php';

    if (isset($_POST['userform'])) {
        $id = $_POST['id'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $tel = $_POST['tel'];
        $date_edit = date('Y-m-d H:i:s');

            try {
                if (!isset($_SESSION['error'])) {

                    $sql = "UPDATE users 
                            SET firstname = :firstname, lastname = :lastname, tel = :tel, date_edit = :date_edit
                            WHERE id = :id";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":id", $id);
                    $stmt->bindParam(":firstname", $firstname);
                    $stmt->bindParam(":lastname", $lastname);
                    $stmt->bindParam(":tel", $tel);
                    $stmt->bindParam(":date_edit", $date_edit);
                    $stmt->execute();

                    $_SESSION['success'] = "แก้ไขข้อมูลเรียบร้อยแล้ว!";
                    echo "<script>
                        $(document).ready(function() {
                            Swal.fire({
                                title: 'success',
                                text: 'แก้ไขโปรไฟล์เรียบร้อยแล้ว!',
                                icon: 'success',
                                timer: 5000,
                                showConfirmButton: false
                            });
                        });
                    </script>";
                    header("refresh:2; url=repairman_profile.php");
                } else {
                    $_SESSION['error'] = "มีบางอย่างผิดพลาด";
                    header("location: repairman.php");
                }

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }


?>


    


