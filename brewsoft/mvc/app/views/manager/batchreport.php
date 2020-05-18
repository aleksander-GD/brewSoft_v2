<!DOCTYPE html>
<html>

<head>

    <?php

    $dateTime = $viewbag['datetime'];

    $tempAndHumid = $viewbag['tempandhumid'];
    $highlow = $viewbag['highlowtemphumid'];
    $products = $viewbag['products'];
    $sortedTimes = $viewbag['sortedTimes'];


    ?>
</head>

<?php include_once '../app/views/partials/menu.php'; ?>
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
    google.charts.setOnLoadCallback(drawLineChart);
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
    //Line 
    function drawLineChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('number', 'X');
        data.addColumn('number', 'Temperature');
        data.addColumn('number', 'Humidity');

        data.addRows([
            <?php
            $count = 0;
            foreach ($tempAndHumid as $temp) {
                echo "[" . $count . "," . $temp['temperature'] . "," . $temp['humidity'] . "],";
                $count++;
            }
            ?>
        ]);

        var options = {
            height: 450,
            hAxis: {
                title: 'Entry points'
            },
            explorer: {
                actions: ['dragToZoom', 'rightClickToReset'],
                axis: 'horizontal',
                keepInBounds: true,
                maxZoomIn: 4.0

            },
            vAxis: {
                title: 'Temperature/Humidity',

                viewWindow: {
                    //dynamic view window with buffer of two on the min / max values of temp and humidity
                    min: <?php echo min($highlow) - 2; ?>,
                    max: <?php echo max($highlow) + 2; ?>
                },
            },
            backgroundColor: 'white'
        };

        var chart = new google.visualization.LineChart(document.getElementById('line_div'));
        chart.draw(data, options);
    }
    //Line end

    //Pie Chart
    function drawPieChart() {

        var data = google.visualization.arrayToDataTable([
            ['Status', 'Amount'],
            <?php

            echo
                "[ 'Accepted'" . "," . $products['acceptedcount'] . "]," .
                    "[ 'Rejected'" . "," . $products['defectcount'] . "]," .
                    "[ 'Not produced'" . "," . ($products['totalcount'] - $products['acceptedcount'] - $products['defectcount']) . "]";
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
    <div id="productioninfo-div">
        <h2>Production Info</h2>
        <p>Peak humidity: <?php echo $highlow['maxhumid'] ?> </p>
        <p>Peak temprature: <?php echo $highlow['maxtemp'] ?> </p>
        <div id="line_div" style="width: 800px; height: 450px;"></div>
    </div>
    <div id="piechart-div">
        <h2>Productionstatus</h2>
        <p>Total amount of products: <?php echo $products['totalcount']; ?> </p>
        <div id="piechart" style="width: 800px; height: 400px;"></div>
    </div>

    <?php include '../app/views/partials/foot.php'; ?>
    <?php 
    $end_time = microtime(true);
    $execution_time = ($end_time - $viewbag['start']);
    echo "The batch report was generated in " . $execution_time . " seconds ";
    ?>