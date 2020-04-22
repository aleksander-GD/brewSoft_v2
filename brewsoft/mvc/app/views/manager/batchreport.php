<?php

$dateTime = $viewbag['datetime'];

$tempAndHumid = $viewbag['tempandhumid'];
$highlow = $viewbag['highlowtemphumid'];


$products = $viewbag['products'];


?>

<html>

<head>
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
                vAxis: {
                    title: 'Temperature/Humidity',
                    viewWindow: {
                        //dynamic view window with buffer of two on the min / max values of temp and humidity
                        min: <?php echo min($highlow) - 2;?> ,
                        max: <?php echo max($highlow) + 2;?>
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
    <div id="timeline-div">
        <h2>Timeline for production</h2>
        <div id="chart_div" style="width: 800px; height: 450px;"></div>
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
</body>

</html>