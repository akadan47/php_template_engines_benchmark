<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Typical page benchmark for PHP template engines</title>
    <link rel="stylesheet" href="/_files/css/bootstrap.min.css">
    <link rel="stylesheet" href="/_files/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/_files/css/style.css">
    <script type="text/javascript" src="/_files/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="/_files/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/_files/js/smoothie.js"></script>
    <script type="text/javascript" src="/_files/js/jquery.tablesorter.min.js"></script>
    <script type="text/javascript" src="/_files/js/benchmark.js"></script>
    <script type="text/javascript">
            var ENGINES = [
                {
                    "id": "gekkon",
                    "name": "Gekkon",
                    "url": "/gekkon/"
                },
                {
                    "id": "smarty",
                    "name": "Smarty",
                    "url": "/smarty/"
                },
                {
                    "id": "twig",
                    "name": "Twig",
                    "url": "/twig/"
                },
                {
                    "id": "gekkon_includes",
                    "name": "Gekkon with includes",
                    "url": "/gekkon/?include"
                },
                {
                    "id": "smarty_includes",
                    "name": "Smarty with includes",
                    "url": "/smarty/?include"
                },

                {
                    "id": "twig_includes",
                    "name": "Twig with includes",
                    "url": "/twig/?include"
                }
            ];
    </script>
</head>

<body>

<div class="container bs-docs-container">

    <div class="jumbotron">
        <button class="btn btn-lg btn-success" id="start">Start benchmark!</button>
    </div>

    <div class="row">

        <div class="col-md-7">
            <div id="process"></div>
        </div>

        <div class="col-md-5">
            <div class="bs-sidebar hidden-print affix-top">
                <div class="panel panel-default hidden" id="result_init">
                    <div class="panel-heading"><h4 class="panel-title">Generation time (less is the better, ms)</h4></div>

                    <div class="panel-body">
                        <table class="table" id="table_init">
                            <thead>
                                <tr>
                                    <th style="width: 90%;">Engine</th>
                                    <th><b>Avg</b></th>
                                    <th>Min</th>
                                    <th>Max</th>
                                </tr>
                            </thead>
                            <tbody id="score_init">

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="panel panel-default hidden" id="result_render">
                    <div class="panel-heading"><h5 class="panel-title">Render time (less is the better, ms)</h5></div>

                    <div class="panel-body">
                        <table class="table" id="table_render">
                            <thead>
                            <tr>
                                <th style="width: 90%;">Engine</th>
                                <th><b>Avg</b></th>
                                <th>Min</th>
                                <th>Max</th>
                            </tr>
                            </thead>
                            <tbody id="score_render">

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>


<script type="text/javascript">
    $(function () {

        function start(engine){
            engine.line = new TimeSeries();
            engine.chart = new SmoothieChart({millisPerPixel:50,maxValueScale:2,minValue:0,grid:{fillStyle:'#ffffff',strokeStyle:'rgba(119,119,119,0.11)',sharpLines:true,borderVisible:false},labels:{fillStyle:'#242424'}});
            engine.chart.addTimeSeries(engine.line, {lineWidth:0.25, strokeStyle:'#03dc00', fillStyle:'#03dc00'});
            engine.chart.streamTo(document.getElementById("chart_"+engine.id), 100);
            engine.chart.start();
            $('#panel_'+engine.id).addClass('panel-warning');
        }

        function step(engine, time_init, time_render, count) {
            engine.line.append(new Date().getTime(), time_init);
        }

        function end(engine, avg_init, min_init, max_init, avg_render, min_render, max_render) {
            engine.chart.stop();
            $('.panel-warning').removeClass('panel-warning');
            $('#score_init').append($('<tr><td><b>'+engine.name+'</b></td><td><b>'+avg_init+'</b></td><td>'+min_init+'</td><td>'+max_init+'</td></tr>'));
            $('#score_render').append($('<tr><td><b>'+engine.name+'</b></td><td><b>'+avg_render+'</b></td><td>'+min_render+'</td><td>'+max_render+'</td></tr>'));
        }

        function complete() {
            $("#table_init").trigger('update').tablesorter();
            $("#table_render").trigger('update').tablesorter();
            $('#result_init').addClass('panel-warning');
            $('#result_render').addClass('panel-warning');
            $('#start').text('Restart Benchmark!').removeAttr('disabled');
        }

        $('#start').on('click', function(){
            $(this).attr('disabled', 'disabled');
            $('#process').children().remove();
            $('#score_init').children().remove();
            $('#score_render').children().remove();
            $('#result_init').addClass('hidden');
            $('#result_render').addClass('hidden');
            $.each(ENGINES, function(i, engine){
                var engine_panel = $(
                    '<div id="panel_' + engine.id + '" class="panel panel-default">' +
                        '<div class="panel-heading">' +
                            '<h3 class="panel-title">'+engine.name+' <span class="label label-default pull-right"><a href="'+engine.url+'" target="_blank">HTML</a></span></h3>' +
                        '</div>' +
                        '<div class="panel-body panel-chart">' +
                            '<canvas id="chart_' + engine.id + '" width="500" height="77">' +
                            '<div class="progress progress-striped active"><div class="progress-bar progress-bar-success"></div></div>' +
                        '</div>' +
                    '</div>'
                );
                $('#process').append(engine_panel);
                $('#result_init').removeClass('hidden');
                $('#result_render').removeClass('hidden');
            });
            var benchmark = new Benchmark(ENGINES, {'on_start': start, 'on_step': step, 'on_end': end, 'on_complete': complete});
            benchmark.start();
        });

    });
</script>

</body>
</html>
