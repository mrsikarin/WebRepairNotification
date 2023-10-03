<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php

            $dates = array();

            for ($i = 6; $i >= 0; $i--) {
                $date = "\"" . date('d-M-Y', strtotime("-$i days")) . "\"";
                $dates[] = $date;
            }
            $query = "SELECT id,DATE_FORMAT(date_first, '%d-%M-%Y') AS date_first FROM repair WHERE date_first IS NOT NULL AND date_first BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW();";
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
                    print($k . " : " . $d);
                    if ($k == $d) {
                        $count++;
                    }
                }
                $result1[] = $count;
            }


            $query = "SELECT id,DATE_FORMAT(date_accept, '%d-%M-%Y') AS date_accept FROM repair WHERE date_accept IS NOT NULL AND date_accept BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW();";
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

            $query = "SELECT id,DATE_FORMAT(date_success, '%d-%M-%Y') AS date_success FROM repair WHERE date_success IS NOT NULL AND date_success BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW();";
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

            $query = "SELECT id,DATE_FORMAT(date_cancel, '%d-%M-%Y') AS date_cancel FROM repair WHERE date_cancel IS NOT NULL AND date_cancel BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW();";
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