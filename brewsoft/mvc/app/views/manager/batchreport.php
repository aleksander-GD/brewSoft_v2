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
    <title>Batch report</title>

    <link rel="stylesheet" href="<?php echo DOC_ROOT; ?>/css/batchreport.css">
    <?php include_once '../app/views/partials/head.php'; ?>

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
                /*  height: 450, */

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
                /* height: 450, */
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
                /* height: 450, */
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
                /* height: 450, */
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
                    title: 'Vibration',

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

        $(window).resize(function() {
            drawTimeline();
            drawPieChart();
            drawTemperatureLineChart();
            drawHumidityLineChart();
            drawVibrationLineChart();
        });
    </script>
    </head>

    <body>
        <?php include_once '../app/views/partials/menu.php'; ?>

        <div class="container">
            <div class="card-deck">
                <div class="row">
                    <div class="card">
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
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Total time spent in each state</h2>
                        </div>
                        <div class="card-body">
                            <?php foreach ($sortedTimes as $time) {
                                $timeObject = $time['timeinstate'];
                                $timeObject->format("%H:%I:%S");
                                echo "<p>" . $time['machinestate'] . ": " . $timeObject->format("%H:%I:%S") . "</p>";
                            } ?>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Batch OEE <?php if (!empty($viewbag['oeeForBatch'])) {
                                                                    echo $viewbag['oeeForBatch'] . '&#37';
                                                                } ?></h2>
                        </div>
                        <div class="card-body">
                            <p for="OEE">
                                <?php
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

        </div>

        <div class="row">
            <div class="col-md-6">
                <H2>Timeline for production</H2>
                <div id="chart_div" class="chart"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <h2>Temperature chart</h2>
                <div id="templine_div" class="chart"></div>
                <p>Peak temprature: <?php echo $highlow['maxtemp'] ?> </p>
                <p>Lowest temperature: <?php echo $highlow['mintemp'] ?> </p>

            </div>
            <div class="col-md-6">
                <h2>Humidity chart</h2>
                <div id="humidline_div" class="chart"></div>
                <p>Peak humidity: <?php echo $highlow['maxhumid'] ?> </p>
                <p>Lowest humidity: <?php echo $highlow['minhumid'] ?> </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">

                <h2>Vibration chart</h2>


                <div id="vibrationline_div" class="chart">

                </div>
                <p>Peak vibration: <?php echo $highlow['maxvibration'] ?> </p>
                <p>Lowest vibration: <?php echo $highlow['minvibration'] ?> </p>


            </div>
            <div class="col-md-6">

                <H2>Products</H2>

                <div id="piechart" class="chart"></div>
                <p>Total amount of products: <?php echo $finalbatchinformation['totalcount'] ?> </p>


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
