<?php

$dateTime = $viewbag['datetime'];
$tempAndHumid = $viewbag['tempandhumid'];
$products = $viewbag['products'];


print_r($products);
echo $products['acceptedcount'];




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
                title: 'Timeline of production',
                height: 450,
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
                        min: 20,
                        max: 40
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
                echo "[ 'Accepted'" . "," . $products['acceptedcount'] . "]," .
                    "[ 'Rejected'" . "," . $products['defectcount'] . "]";
                ?>

            ]);

            var options = {

            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }
    </script>
</head>

<body>
    <h2>Timeline for production</h2>
    <div id="chart_div" style="width: 800px; height: 450px;"></div>
    <h2>Production Info</h2>
    <div id="line_div" style="width: 800px; height: 450px;"></div>
    <h2>Productionstatus</h2>
    <div id="piechart" style="width: 800px; height: 400px;"></div>
</body>

</html>