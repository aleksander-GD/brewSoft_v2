<?php

$array = $viewbag['alltimes'];


foreach ($array as $entry) {
    print "</pre>";
    print_r($entry['timeinstate']->s); // get seconds from DateInterval object. 
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
                ['Activity', 'Start Time', 'End Time'],
                ['Sleep',
                    new Date(2014, 10, 15, 0, 30),
                    new Date(2014, 10, 15, 6, 30)
                ],
                ['Eat Breakfast',
                    new Date(2014, 10, 15, 6, 45),
                    new Date(2014, 10, 15, 7)
                ],
                ['Get Ready',
                    new Date(2014, 10, 15, 7, 4),
                    new Date(2014, 10, 15, 7, 30)
                ],
                ['Commute To Work',
                    new Date(2014, 10, 15, 7, 30),
                    new Date(2014, 10, 15, 8, 30)
                ],
                ['Work',
                    new Date(2014, 10, 15, 8, 30),
                    new Date(2014, 10, 15, 17)
                ],
                ['Commute Home',
                    new Date(2014, 10, 15, 17),
                    new Date(2014, 10, 15, 18)
                ],
                ['Gym',
                    new Date(2014, 10, 15, 18),
                    new Date(2014, 10, 15, 18, 45)
                ],
                ['Eat Dinner',
                    new Date(2014, 10, 15, 19),
                    new Date(2014, 10, 15, 20)
                ],
                ['Get Ready For Bed',
                    new Date(2014, 10, 15, 21),
                    new Date(2014, 10, 15, 22)
                ]
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