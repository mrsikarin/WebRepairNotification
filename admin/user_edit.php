<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 

    session_start();
    require_once '../mysql.php';

    if (isset($_GET['userform'])) {
        $id = $_GET['ser_id2'];

        $firstname = $_GET['firstname'];
        $lastname = $_GET['lastname'];
        $tel = $_GET['tel'];
        $urole = $_GET['urole'];
        $status = $_GET['status'];
        $date_edit = date('Y-m-d H:i:s');

        try {
                if (!isset($_SESSION['error'])) {
                    $sql = "UPDATE users 
                            SET firstname = :firstname, lastname = :lastname, tel = :tel, urole = :urole, status = :status, date_edit = :date_edit
                            WHERE id = :id";         
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":id", $id); 
                    $stmt->bindParam(":firstname", $firstname);
                    $stmt->bindParam(":lastname", $lastname);
                    $stmt->bindParam(":tel", $tel);
                    $stmt->bindParam(":urole", $urole);
                    $stmt->bindParam(":status", $status);
                    $stmt->bindParam(":date_edit", $date_edit);
                    $stmt->execute();
                    
                    $_SESSION['success'] = "แก้ไขผู้ใช้งานเรียบร้อยแล้ว";
                    echo "<script>
                        $(document).ready(function() {
                            Swal.fire({
                                title: 'success',
                                text: 'แก้ไขผู้ใช้งานเรียบร้อยแล้ว!',
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
    }
    

?>