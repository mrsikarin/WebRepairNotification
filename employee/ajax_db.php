<?php

    require_once '../mysql.php';


  if (isset($_POST['function']) && $_POST['function'] == 'type') {
  	$id = $_POST['id'];
  	$sql = "SELECT * 
            FROM serial 
            WHERE type_id='$id' 
            AND serial_status='use'";
  	$stmt = $conn->query($sql);
  	echo '<option value="" selected disabled>-กรุณาเลือกอุปกรณ์-</option>';
  	foreach ($stmt as $value) {
  		echo '<option value="'.$value['id'].'">'.$value['serial_name'].' Serial:'.$value['serial_number'].'</option>';
  		
  	}
  }

  if (isset($_POST['function']) && $_POST['function'] == 'building') {
    $id = $_POST['id'];
    $sql = "SELECT * 
            FROM positions 
            WHERE building_id='$id' 
            AND position_status ='active'";
    $stmt = $conn->query($sql);
    echo '<option value="" selected disabled>-กรุณาเลือกสถานที่-</option>';
    foreach ($stmt as $value) {
        echo '<option value="'.$value['id'].'">ชั้น:'.$value['detail_floor'].' ห้อง:'.$value['detail_room'].'</option>';
        
    }
}
?>