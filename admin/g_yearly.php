<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php

            $dates = array();
            $currentDate = new DateTime();  // วันที่ปัจจุบัน
            $currentYear = $currentDate->format('Y');  // ปีปัจจุบัน
            $dates[] = "\"" . $currentYear . "\"";  // เพิ่มปีปัจจุบันลงในอาร์เรย์

            for ($i = 0; $i < 2; $i++) {
                $currentDate->modify('-1 year');  // ย้อนกลับเป็นปีก่อนหน้า
                $year = $currentDate->format('Y');  // ดึงปี
                $dates[] = "\"" . $year . "\"";  // เพิ่มปีลงในอาร์เรย์
            }



            $uniqueYears = array_unique($dates);  // เอาเฉพาะปีที่ไม่ซ้ำกัน

            // $dates[] =  "\"" .$currentMonth . "\"";  // เพิ่มเดือนปัจจุบันลงในอาร์เรย์

            $query = "SELECT DATE_FORMAT(date_first, '%Y') AS date_first 
                      FROM repair WHERE date_first >=  DATE_SUB(CURDATE(), INTERVAL 3 YEAR) AND date_first IS NOT NULL;";
            $resultQuery = $conn->query($query);
            $data = array();
            while ($row = $resultQuery->fetch(PDO::FETCH_ASSOC)) {
                $data[] = "\"" . $row['date_first'] . "\"";
            }
            print_r($data);
            $result1 = array();

            foreach ($dates as $d) {
                $count = 0;
                foreach ($data as $k) {
                    if ($k == $d) {
                        $count++;
                    }
                }
                $result1[] = $count;
                print($count);
            }

            $query = "SELECT DATE_FORMAT(date_accept, '%Y') AS date_accept 
                      FROM repair WHERE date_accept >= DATE_SUB(CURDATE(), INTERVAL 3 YEAR) AND date_accept IS NOT NULL;";
            $resultQuery = $conn->query($query);
            $data = array();
            while ($row = $resultQuery->fetch(PDO::FETCH_ASSOC)) {
                $data[] = "\"" . $row['date_accept'] . "\"";
            }
            $result2 = array();

            foreach ($dates as $d) {
                $count = 0;
                foreach ($data as $k) {
                    if ($k == $d) {
                        $count++;
                    }
                }
                $result2[] = $count;
            }


            $query = "SELECT DATE_FORMAT(date_success, '%Y') AS date_success 
                      FROM repair WHERE date_success >= DATE_SUB(CURDATE(), INTERVAL 3 YEAR) AND date_success IS NOT NULL;";
            $resultQuery = $conn->query($query);
            $data = array();
            while ($row = $resultQuery->fetch(PDO::FETCH_ASSOC)) {
                $data[] = "\"" . $row['date_success'] . "\"";
            }
            $result3 = array();

            foreach ($dates as $d) {
                $count = 0;
                foreach ($data as $k) {
                    if ($k == $d) {
                        $count++;
                    }
                }
                $result3[] = $count;
            }

            $query = "SELECT DATE_FORMAT(date_cancel, '%Y') AS date_cancel 
            FROM repair WHERE date_cancel >= DATE_SUB(CURDATE(), INTERVAL 3 YEAR) AND date_cancel IS NOT NULL;";
            $resultQuery = $conn->query($query);
            $data = array();
            while ($row = $resultQuery->fetch(PDO::FETCH_ASSOC)) {
                $data[] = "\"" . $row['date_cancel'] . "\"";
            }
            $result4 = array();

            foreach ($dates as $d) {
                $count = 0;
                foreach ($data as $k) {
                    if ($k == $d) {
                        $count++;
                    }
                }
                $result4[] = $count;
            }
            ?>
            <h3 align="center">รายงานในแบบกราฟ</h3>


            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <hr>
            <p align="center">

                <canvas id="myChart1" width="800px" height="600px"></canvas>



            <table>
                <tr>
                    <th>Date</th>
                    <th>รอดำเนินการ</th>
                    <th>กำลังดำเนินการ</th>
                    <th>เสร็จสิ้น</th>
                    <th>ยกเลิก</th>
                </tr>
                <?php
                for ($i = 0; $i < count($dates); $i++) {
                    echo "<tr>";
                    echo "<td>" . $dates[$i] . "</td>";
                    echo "<td>" . $result1[$i] . "</td>";
                    echo "<td>" . $result2[$i] . "</td>";
                    echo "<td>" . $result3[$i] . "</td>";
                    echo "<td>" . $result4[$i] . "</td>";
                    echo "</tr>";
                }
                $result1 = implode(",", $result1);
                $result2 = implode(",", $result2);
                $result3 = implode(",", $result3);
                $result4 = implode(",", $result4);
                $dates = implode(",", $dates);
                ?>
            </table>
            <script>
                var ctx = document.getElementById("myChart1").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: [<?php echo $dates; ?>],
                        datasets: [{
                            label: 'รอดำเนินการ',
                            data: [<?php echo $result1; ?>],
                            backgroundColor: [
                                'rgba(60, 179, 113, 0.2)'
                            ],
                            borderColor: [
                                'rgba(54, 162, 235, 1)'
                            ],
                            borderWidth: 1
                        }, {
                            label: 'กำลังดำเนินการ',
                            data: [<?php echo $result2; ?>],
                            backgroundColor: [
                                'rgba(106, 90, 205, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)'
                            ],
                            borderWidth: 1
                        }, {
                            label: 'เสร็จสิ้น',
                            data: [<?php echo $result3; ?>],
                            backgroundColor: [
                                'rgba(255, 165, 0, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)'
                            ],
                            borderWidth: 1
                        }, {
                            label: 'ยกเลิก',
                            data: [<?php echo $result4; ?>],
                            backgroundColor: [
                                'rgba(255, 165, 0, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {

                        responsive: false,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>

        </div>
    </div>
</div>