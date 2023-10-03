<button onclick="document.getElementById('id01').style.display='block'" title="Add" class="button">
    <i class='bx bx-duplicate'></i>
</button>

<!-- model form add -->
<div id="id01" class="w3-modal">
  <div class="w3-modal-content w3-animate-opacity">
    <div class="w3-container">
      <h3 class="mt-4">แบบฟอร์มแจ้งซ่อม</h3>
      <span onclick="document.getElementById('id01').style.display='none'" 
      class="w3-button w3-display-topright">&times;</span>
      <hr>   
        <form action="form_add.php" method="post">
            
            <div class="mb-3">
              <input type="hidden" class="w3-input w3-border" name="informer_id" value="<?php echo $row['id'];?>" readonly>
            </div>
            
            <div class="mb-3">
              <label class="form-label">ผู้แจ้งซ่อม</label>
              <input type="text" class="w3-input w3-border" value="<?php echo $row['firstname'] . ' ' . $row['lastname'] ?>" readonly>
            </div>
            
            <div class="mb-3">
              <label for="type">ประเภทอุปกรณ์</label>
              <select name="serial_id" id="type" class="form-control">
                <option value="">เลือกประเภท</option>
                <?php foreach($t as $type) { ?>
                  <option value="<?=$type['id'];?>"><?=$type['type_name'];?></option>
               <?php } ?>
              </select>
            </div>
            
            <div class="mb-3">
              <label for="serial">อุปกรณ์</label>
              <select name="serial_id" id="serial" class="form-control"></select>
            </div>
            
            <div class="mb-3">
              <label for="building">อาคาร</label>
              <select name="id" id="building" class="form-control">
                <option value="">เลือกอาคาร</option>
                <?php foreach($b as $building) { ?>
                  <option value="<?=$building['id'];?>"><?=$building['building_name'];?></option>
               <?php } ?>
              </select>
            </div>
            
            <div class="mb-3">
              <label for="positions">สถานที่</label>
              <select name="id" id="positions" class="form-control"></select>
            </div>
            
            <div class="mb-3">
              <label for="detailrepair" class="form-label">รายละเอียด</label>
              <textarea type="text" class="w3-input w3-border" name="detailrepair"></textarea>
            </div>
            
            <div class="mb-3">
              <input type="hidden" class="w3-input w3-border" name="repair_status" value="pending" readonly>
            </div>

            <button type="submit" name="formadd" class="buttonOK">ยืนยัน</button>
        </form>
    </div>
  </div>
</div>