<!DOCTYPE html>
<html>

<head>

    <?php

    $dateTime = $viewbag['datetime'];

    $productionInfo = $viewbag['productioninfo'];

    $highlow = $viewbag['highlowtemphumid'];
    $sortedTimes = $viewbag['sortedTimes'];
    $finalbatchinformation = $viewbag['finalbatchinformation'];
    $rowCount = 0;
    $pixel = 0;


    ?>
</head>

<?php include_once '../app/views/partials/menu.php'; ?>
<?php if (isset($_SESSION['usertype']) && ($_SESSION['usertype'] == 'Manager' || $_SESSION['usertype'] == 'Admin')) : ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        //Timeline
        google.charts.load('current', {
            'packages': ['timeline']
        });
        //Line
        google.charts.load('current', {
            'packages': ['corechart', 'line']
        });
        //Line
        google.charts.load('current', {
            'packages': ['corechart']
        });

        //Callback timeline
        google.charts.setOnLoadCallback(drawTimeline);
        //Callback lineChart
        google.charts.setOnLoadCallback(drawTemperatureLineChart);
        google.charts.setOnLoadCallback(drawHumidityLineChart);
        google.charts.setOnLoadCallback(drawVibrationLineChart);
        //Callback PieChart
        google.charts.setOnLoadCallback(drawPieChart);


        //timeline
        function drawTimeline() {
            var data = google.visualization.arrayToDataTable([
                ['State', 'Start Time', 'End Time'],
                <?php

                foreach ($dateTime as $result) {
                    echo "['" . $result['machinestate'] . "'," .
                        "new Date('" . $result['starttimeinstate'] . "'), " .
                        "new Date('" . $result['endtimeinstate'] . "') " . "],";
                }
                ?>
            ]);
            var options = {
                height: 450,

                hAxis: {
                    format: 'HH:mm:ss',
                },
                timeline: {
                    tooltipDateFormat: 'HH:mm:ss'
                }
            };
            var chart = new google.visualization.Timeline(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
        //Timeline end
        //Temperature line
        function drawTemperatureLineChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('datetime', 'time');
            data.addColumn('number', 'Temperature');

            data.addRows([
                <?php
                //$count = 0;
                foreach ($productionInfo as $temp) {
                    //echo "[" . $count . "," . $temp['temperature'] . "," . $temp['humidity'] . "],";
                    echo "[" . "new Date('" . $temp['entrydate'] . " " . $temp['entrytime'] . "')" . "," . $temp['temperature'] . "],";
                    //$count++;
                }
                ?>
            ]);
            var options = {
                height: 450,
                colors: ['red'],
                hAxis: {
                    title: 'Time',
                    format: 'HH:mm:ss',
                },
                explorer: {
                    actions: ['dragToZoom', 'rightClickToReset'],
                    axis: 'horizontal',
                    keepInBounds: true,
                    maxZoomIn: 15.0
                },
                vAxis: {
                    title: 'Temperature',
                    viewWindow: {
                        //dynamic view window with buffer of two on the min / max values of temp and humidity
                        min: <?php echo $highlow['mintemp'] - 2; ?>,
                        max: <?php echo $highlow['maxtemp'] + 2; ?>
                    },
                },
                backgroundColor: 'white'
            };

            var chart = new google.visualization.LineChart(document.getElementById('templine_div'));
            chart.draw(data, options);
        }
        //Line end
        //Humidity line
        function drawHumidityLineChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('datetime', 'time');
            data.addColumn('number', 'Humidity');

            data.addRows([
                <?php
                //$count = 0;
                foreach ($productionInfo as $temp) {
                    //echo "[" . $count . "," . $temp['temperature'] . "," . $temp['humidity'] . "],";
                    echo "[" . "new Date('" . $temp['entrydate'] . " " . $temp['entrytime'] . "')" . "," . $temp['humidity'] . "],";
                    //$count++;
                }
                ?>
            ]);

            var options = {
                height: 450,
                colors: ['blue'],
                hAxis: {
                    title: 'Time',
                    format: 'HH:mm:ss',

                },
                explorer: {
                    actions: ['dragToZoom', 'rightClickToReset'],
                    axis: 'horizontal',
                    keepInBounds: true,
                    maxZoomIn: 15.0

                },
                vAxis: {
                    title: 'Humidity',

                    viewWindow: {
                        //dynamic view window with buffer of two on the min / max values of temp and humidity
                        min: <?php echo $highlow['minhumid'] - 2; ?>,
                        max: <?php echo $highlow['maxhumid'] + 2; ?>
                    },
                },
                backgroundColor: 'white'
            };

            var chart = new google.visualization.LineChart(document.getElementById('humidline_div'));
            chart.draw(data, options);
        }
        //Line end
        //Humidity line
        function drawVibrationLineChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('datetime', 'time');
            data.addColumn('number', 'Vibration');

            data.addRows([
                <?php
                //$count = 0;
                foreach ($productionInfo as $temp) {
                    //echo "[" . $count . "," . $temp['temperature'] . "," . $temp['humidity'] . "],";
                    echo "[" . "new Date('" . $temp['entrydate'] . " " . $temp['entrytime'] . "')" . "," . $temp['vibration'] . "],";
                    //$count++;
                }
                ?>
            ]);

            var options = {
                height: 450,
                colors: ['blue'],
                hAxis: {
                    title: 'Time',
                    format: 'HH:mm:ss',

                },
                explorer: {
                    actions: ['dragToZoom', 'rightClickToReset'],
                    axis: 'horizontal',
                    keepInBounds: true,
                    maxZoomIn: 15.0

                },
                vAxis: {
                    title: 'Humidity',

                    viewWindow: {
                        //dynamic view window with buffer of two on the min / max values of temp and humidity
                        min: <?php echo $highlow['minvibration'] - 2; ?>,
                        max: <?php echo $highlow['maxvibration'] + 2; ?>
                    },
                },
                backgroundColor: 'white'
            };

            var chart = new google.visualization.LineChart(document.getElementById('vibrationline_div'));
            chart.draw(data, options);
        }
        //Line end

        //Pie Chart
        function drawPieChart() {

            var data = google.visualization.arrayToDataTable([
                ['Status', 'Amount'],
                <?php

                echo
                    "[ 'Accepted'" . "," . $finalbatchinformation['acceptedcount'] . "]," .
                        "[ 'Rejected'" . "," . $finalbatchinformation['defectcount'] . "]," .
                        "[ 'Not produced'" . "," . ($finalbatchinformation['totalcount'] - $finalbatchinformation['acceptedcount'] - $finalbatchinformation['defectcount']) . "]";
                ?>

            ]);
            var options = {
                pieSliceText: 'value',
            };
            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }
    </script>
    </head>

    <body>
        <?php include_once '../app/views/partials/menu.php'; ?>

        <div class="container">

            <div class="row">
                <div class="col-lg 3 col-md-3 col-sm-12 col-xs-12">
                    <div class="card" style="width: 30rem; height:23rem;">
                        <div class="card-header">
                            <h2 class="card-title">Batch number: <?php echo $finalbatchinformation['batchid'] ?></h2>
                        </div>
                        <div class="card-body">

                            <p>Beer type: <?php echo $finalbatchinformation['productname'] ?> </p>
                            <p>Production speed: <?php echo $finalbatchinformation['speed'] ?> </p>
                            <p>Queue date: <?php echo $finalbatchinformation['dateofcreation'] ?> </p>
                            <p>Deadline: <?php echo $finalbatchinformation['deadline'] ?> </p>
                            <p>Produced: <?php echo $finalbatchinformation['dateofcompletion'] ?> </p>
                            <p>Production machine : <?php echo $finalbatchinformation['brewerymachineid'] ?> </p>

                        </div>
                    </div>
                </div>
                <div class="col-lg 3 col-md-3 col-sm-12 col-xs-12">

                    <div class="card" style="width: 30rem; height:23rem;">
                        <div class="card-header">
                            <h2 class="card-title">Total time spent in each state</h2>
                        </div>
                        <div class="card-body">
                            <?php foreach ($sortedTimes as $time) {
                                $timeObject = $time['timeinstate'];
                                $timeObject->format("%H:%I:%S");
                                echo "<p>" . $time['machinestate'] . ": " . $timeObject->format("%H:%I:%S") . "</p>";
                                $rowCount++;
                            }
                            if ($rowCount >= 6) {
                                $pixel = 400;
                            } else {
                                $pixel = 300;
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg 3 col-md-3 col-sm-12 col-xs-12">
                    <div class="card" style="width: 30rem; height:20rem;">
                        <div class="card-header">
                            <h2 class="card-title">Products</h2>
                        </div>
                        <div id="piechart" style="width: 100%; height: 100%;"></div>
                        <div class="card-body">
                            <p>Total amount of products: <?php echo $finalbatchinformation['totalcount'] ?> </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg 3 col-md-3 col-sm-12 col-xs-12">
                    <div class="card" style="width: 30rem; height:20rem;">
                        <div class="card-header">
                            <h2 class="card-title">Batch OEE</h2>
                        </div>
                        <div class="card-body">
                            <p for="OEE">
                                <?php
                                if (!empty($viewbag['oeeForBatch'])) {
                                    echo 'OEE: ' . $viewbag['oeeForBatch'] . '&#37';
                                }
                                if (!empty($viewbag['availability'])) {
                                    echo "<br>" . 'Availability: ' . $viewbag['availability'] . '&#37';
                                }
                                if (!empty($viewbag['performance'])) {
                                    echo "<br>" . 'Performance: ' . $viewbag['performance'] . '&#37';
                                }
                                if (!empty($viewbag['quality'])) {
                                    echo "<br>" . 'Quality: ' . $viewbag['quality'] . '&#37';
                                } ?> </p><br>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-lg 3 col-md-3 col-sm-12 col-xs-12">
                    <div class="card" style="width: 100%; height:<?php echo $pixel ?>px;">
                        <div class="card-header">
                            <h2 class="card-title">Timeline for production</h2>
                        </div>

                        <div id="chart_div" style="width: 100%; height:100%;"></div>
                        <div class="card-body">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg 3 col-md-3 col-sm-12 col-xs-12">
                    <div class="card" style="width: 100%; ">
                        <div class="card-header">
                            <h2 class="card-title">Temperature Info</h2>
                        </div>

                        <div id="templine_div" style="width:100%; height: 100%;"></div>
                        <div class="card-body">
                            <p>Peak temprature: <?php echo $highlow['maxtemp'] ?> </p>
                            <p>Lowest temperature: <?php echo $highlow['mintemp'] ?> </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg 3 col-md-3 col-sm-12 col-xs-12">
                    <div class="card" style="width: 100%;">
                        <div class="card-header">
                            <h2 class="card-title">Humidity Info</h2>
                        </div>

                        <div id="humidline_div" style="width:100%; height: 100%;"></div>
                        <div class="card-body">
                            <p>Peak humidity: <?php echo $highlow['maxhumid'] ?> </p>
                            <p>Lowest humidity: <?php echo $highlow['minhumid'] ?> </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg 3 col-md-3 col-sm-12 col-xs-12">
                    <div class="card" style="width: 100%;">
                        <div class="card-header">
                            <h2 class="card-title">vibration Info</h2>
                        </div>

                        <div id="vibrationline_div" style="width:100%; height: 100%;"></div>
                        <div class="card-body">
                            <p>Peak vibration: <?php echo $highlow['maxvibration'] ?> </p>
                            <p>Lowest vibration: <?php echo $highlow['minvibration'] ?> </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>






        </div>
    <?php else : ?>
        <?php include_once '../app/views/brewworker/Dashboard.php'; ?>

    <?php endif; ?>
    <?php include '../app/views/partials/foot.php'; ?>

    <?php
    // Performance 03 requirement test 
    $end_time = microtime(true);
    $execution_time = ($end_time - $viewbag['start']);
    echo "The batch report was generated in " . $execution_time . " seconds ";
    ?>