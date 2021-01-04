<?php
include('header.php');
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style.css">
</head>

<body style="background-color: #121212;">
    <script src="//cdnjs.cloudflare.com/ajax/libs/d3/3.5.3/d3.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/topojson/1.6.9/topojson.min.js"></script>
    <script src="datamaps.world.hires.min.js"></script>
    <script src="Chart.min.js"></script>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="maps" id="container1"></div>
            </div>
            <div class="col-md-2">
                <div>

                    <?php include("modules/countrystats.php"); ?>
                    <div class="col-md-2 tables">
                        <!-- LAST IP shit-->
                        <?php include("modules/lastip.php"); ?>
                    </div>
                </div>

            <div class="col-md-12">
                <div class="col-md-12">
                    <?php include("modules/osstats.php"); ?>
                    <canvas class="oschart" id="myOSChart" width="400" height="400"></canvas>
                </div>
                <div class="col-md-12">
                    <!-- Timeline shit-->
                    <?php include("modules/statusstats.php"); ?>
                    <canvas class="oschart" id="myStatsChart" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        let jsiparr = <?php echo json_encode($iparr); ?> ;
        let statusinfo = <?php echo json_encode($statarr); ?> ;
        let jsosinfo = <?php echo json_encode($osarr); ?> ;

        function data_to_array(data) {
            var array = [];
            for (var key in data) {
                var value = data[key];
                if (typeof value === 'string') {
                    array[key] = value;
                } else {
                    array[key] = data_to_array(value);
                }
            }
            return array;
        }

        var cntiparray = data_to_array(jsiparr);
        var series = cntiparray;
        var data = data_to_array(jsosinfo);
        var statusdata = data_to_array(statusinfo);

        var oscnt = [];
        var osname = [];
        var vpnname = [];
        var statcnt = [];
        for (var i = 0; i < data.length; i++) {
            oscnt = oscnt.concat(data[i][1]);
            osname = osname.concat(data[i][0]);
        }

        for (var i = 0; i < statusdata.length; i++) {
            statcnt = statcnt.concat(statusdata[i][1]);
            vpnname = vpnname.concat(statusdata[i][0]);
        }



        var ctx = document.getElementById('myStatsChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: vpnname,
                datasets: [{
                    data: statcnt,
                    backgroundColor: [
                        '#16D298',
                        '#4EE787',
                        '#263E51',
                        '#072238'

                    ],
                    borderColor: [
                        '#16D298',
                        '#4EE787',
                        '#263E51',
                        '#072238'
                    ],
                    borderWidth: 1
                }]
            },
            options: {}
        });

     var ctx = document.getElementById('myOSChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: osname,
                datasets: [{
                    data: oscnt,
                    backgroundColor: [
                        '#00BE9C',
                        '#',
                        '#',
                        '#',
                        '#',
                        '#'
                    ],
                    borderColor: [
                        '#00BE9C',
                        '#',
                        '#',
                        '#',
                        '#',
                        '#'
                    ],
                    borderWidth: 1
                }]
            },
            options: {}
        });


        // example data from server



        var dataset = {};

        // We need to colorize every country based on "numberOfWhatever"
        // colors should be uniq for every value.
        // For this purpose we create palette(using min/max series-value)
        var onlyValues = series.map(function (obj) {
            return obj[1];
        });
        var minValue = Math.min.apply(null, onlyValues),
            maxValue = Math.max.apply(null, onlyValues);

        // create color palette function
        // color can be whatever you wish
        var paletteScale = d3.scale.linear()
            .domain([minValue, maxValue])
            .range(["#332940", "#8670a2"]); // purple color

        // fill dataset in appropriate format
        series.forEach(function (item) { //
            // item example value ["USA", 70]
            var iso = item[0],
                value = item[1];
            dataset[iso] = {
                numberOfThings: value,
                fillColor: paletteScale(value)
            };
        });

        // render map
        new Datamap({
            element: document.getElementById('container1'),
            projection: 'mercator', // big world map
            // countries don't listed in dataset will be painted with this color
            fills: {
                defaultFill: '#222222'
            },
            data: dataset,
            geographyConfig: {
                borderColor: '#332940  ',
                highlightBorderWidth: 1,
                // don't change color on mouse hover
                highlightFillColor: function (geo) {
                    return geo['fillColor'] || '#121212';
                },
                // only change border
                highlightBorderColor: '#B7B7B7',
                // show desired information in tooltip
                popupTemplate: function (geo, data) {
                    // don't show tooltip if country don't present in dataset
                    if (!data) {
                        return;
                    }
                    // tooltip content
                    return ['<div class="hoverinfo">',
                        '<strong>', geo.properties.name, '</strong>',
                        '<br>Count: <strong>', data.numberOfThings, '</strong>',
                        '</div>'
                    ].join('');
                }
            }
        });
    </script>

</body>

</html>
