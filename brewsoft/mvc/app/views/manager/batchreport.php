<?php

$array = $viewbag['alltimes'];
$dateTime = $viewbag['datetime'];



foreach ($array as $entry) {
    print "</pre>";
    print_r($entry);
    print_r($entry['timeinstate']->s); // get seconds from DateInterval object. 
    //print_r($entry['dateobject']);
    print "<pre>";
}

?>

<html>

<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['timeline']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['State', 'Start Time', 'End Time'],
                
                ['Sleep',
                    new Date('2020-04-20 09:55:26'),
                    new Date('2020-04-20 10:55:26')
                ],
                ['Eat Breakfast',
                    new Date('2020-04-20 10:55:26'),
                    new Date('2020-04-20 11:55:26')
                ],
                
            ]);

            var options = {
                height: 450,
            };

            var chart = new google.visualization.Timeline(document.getElementById('chart_div'));

            chart.draw(data, options);
        }
    </script>
</head>

<body>
    <div id="chart_div" style="width: 800px; height: 600px;"></div>
</body>

</html>