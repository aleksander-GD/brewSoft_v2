<!DOCTYPE html>
<html>

<head>

    <?php

    $dateTime = $viewbag['datetime'];   
 

    $tempAndHumid = $viewbag['tempandhumid'];

    $highlow = $viewbag['highlowtemphumid'];
    $sortedTimes = $viewbag['sortedTimes'];
    $finalbatchinformation = $viewbag['finalbatchinformation'];



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
    <?php 
    if(!empty($dateTime)){ ?>
    google.charts.setOnLoadCallback(drawTimeline);
    <?php } ?>
    //Callback lineChart
    <?php 
    if(!empty($tempAndHumid)){ ?>
    google.charts.setOnLoadCallback(drawTemperatureLineChart);
    google.charts.setOnLoadCallback(drawHumidityLineChart);
    <?php } ?>

    //Callback PieChart
    <?php 
    if(!empty($finalbatchinformation)){ ?>
    google.charts.setOnLoadCallback(drawPieChart);
    <?php } ?>

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
            foreach ($tempAndHumid as $temp) {
                //echo "[" . $count . "," . $temp['temperature'] . "," . $temp['humidity'] . "],";
                echo "[" . "new Date('". $temp['entrydate'] . " " . $temp['entrytime'] . "')" . "," . $temp['temperature'] . "],";
                //$count++;
            }
            ?>
        ]);
        var options = {
            height: 450,
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
            foreach ($tempAndHumid as $temp) {
                //echo "[" . $count . "," . $temp['temperature'] . "," . $temp['humidity'] . "],";
                echo "[" . "new Date('". $temp['entrydate'] . " " . $temp['entrytime'] . "')" . "," . $temp['humidity'] . "],";
                //$count++;
            }
            ?>
        ]);

        var options = {
            height: 450,
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
    <div id="overallinfo-div">
        <h2>Batch OEE</h2>
        <p>Batch id: <?php echo $finalbatchinformation['batchid'] ?> </p>
        <p>Beer type: <?php echo $finalbatchinformation['productname'] ?> </p>
        <p>Queue date: <?php echo $finalbatchinformation['dateofcreation'] ?> </p>
        <p>Deadline for production: <?php echo $finalbatchinformation['deadline'] ?> </p>
        <p>Batch was produced: <?php echo $finalbatchinformation['dateofcompletion'] ?> </p>
        <p>Batch was produced by machine number : <?php echo $finalbatchinformation['brewerymachineid'] ?> </p>
    </div>
    <div id="oee-div">
        <h2>Batch OEE</h2>
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
    <div id="timeline-div">
        <h2>Timeline for production</h2>
        <div id="chart_div" style="width: 800px; height: 450px;"></div>
    </div>
    <div id="timeInState-div">
        <h2>Total time spent in each state</h2>
        <?php foreach ($sortedTimes as $time) {
            $timeObject = $time['timeinstate'];
            $timeObject->format("%H:%I:%S");
            echo "<p>" . $time['machinestate'] . ": " . $timeObject->format("%H:%I:%S") . "</p>";
        }
        ?>
    </div>
    <div id="tempinfo-div">
        <h2>Temperature Info</h2>
        <p>Peak temprature: <?php echo $highlow['maxtemp'] ?> </p>
        <p>Lowest temperature: <?php echo $highlow['mintemp'] ?> </p>
        <div id="templine_div" style="width: 800px; height: 450px;"></div>
    </div>
    <div id="humidinfo-div">
        <h2>Humidity Info</h2>
        <p>Peak humidity: <?php echo $highlow['maxhumid'] ?> </p>
        <p>Lowest humidity: <?php echo $highlow['minhumid'] ?> </p>
        <div id="humidline_div" style="width: 800px; height: 450px;"></div>
    </div>
    <div id="piechart-div">
        <h2>Productionstatus</h2>
        <p>Total amount of products: <?php echo $finalbatchinformation['totalcount'] ?> </p>
        <div id="piechart" style="width: 800px; height: 400px;"></div>
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