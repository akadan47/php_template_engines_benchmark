<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
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
                    }
                ];
        </script>
    </head>
    <body>
        <div class="container">
            <div class="row header">
                <div class="col-xs-7">
                    <h3>Typical page benchmark <br/>for PHP template engines</h3>
                </div>
                <div class="col-xs-5">
                    <button class="btn btn-lg btn-warning" id="start">Start benchmark!</button>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-xs-7">
                    <div id="process"></div>
                </div>
                <div id="sidebar" class="col-xs-5 hidden">
                    <div class="bs-sidebar hidden-print affix-top">
                        <div class="panel panel-default hidden" id="result_init">
                            <div class="panel-heading"><h4 class="panel-title">Generation time (init & render) <span>less is the better, ms</span></h4></div>
                            <div class="panel-body">
                                <table class="table hidden" id="table_init">
                                    <thead>
                                        <tr>
                                            <th class="name"><span>Engine</span></th>
                                            <th><span><b>Avg</b></span></th>
                                            <th><span>Min</span></th>
                                            <th><span>Max</span></th>
                                        </tr>
                                    </thead>
                                    <tbody id="score_init">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="panel panel-default hidden" id="result_render">
                            <div class="panel-heading"><h5 class="panel-title">Render time <span>less is the better, ms</span></h5></div>
                            <div class="panel-body">
                                <table class="table hidden" id="table_render">
                                    <thead>
                                    <tr>
                                        <th class="name"><span>Engine</span></th>
                                        <th><span><b>Avg</b></span></th>
                                        <th><span>Min</span></th>
                                        <th><span>Max</span></th>
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
                var el_start__button = $('#start');

                var el_process = $('#process');
                var el_sidebar = $('#sidebar');

                var el_score__init = $('#score_init');
                var el_table__init = $('#table_init');
                var el_result__init = $('#result_init');

                var el_score__render = $('#score_render');
                var el_table__render = $('#table_render');
                var el_result__render = $('#result_render');

                function on_start(engine){
                    engine.line = new TimeSeries();
                    engine.line_includes = new TimeSeries();
                    engine.chart = new SmoothieChart({millisPerPixel:50,maxValueScale:2,minValue:0, maxValue:100,grid:{fillStyle:'#ffffff',strokeStyle:'rgba(119,119,119,0.11)',sharpLines:true,borderVisible:false},labels:{fillStyle:'#777777'}});
                    engine.chart.addTimeSeries(engine.line_includes, {lineWidth:0.25, strokeStyle:'#00acff', fillStyle:'#00acff'});

                    engine.chart.addTimeSeries(engine.line, {lineWidth:0.25, strokeStyle:'#58fa46', fillStyle:'#58fa46'});

                    engine.chart.streamTo(document.getElementById("chart_"+engine.id), 100);
                    engine.chart.start();
                    $('#panel_'+engine.id).addClass('panel-warning');
                }

                function on_update(engine, is_include, time_init, time_render, percent) {
                    $('#bar_'+engine.id).css('width', percent+"%");
                    if (is_include) {
                        engine.line_includes.append(new Date().getTime(), time_init);
                    } else {
                        engine.line.append(new Date().getTime(), time_init);
                    }

                }

                function on_complete(engine, results, results_includes) {
                    engine.chart.stop();
                    if (el_score__init.children())
                        el_table__init.removeClass('hidden');
                    if (el_score__render.children())
                        el_table__render.removeClass('hidden');
                    $('#bar_'+engine.id).css('opacity', '0.15');
                    $('.panel-warning').removeClass('panel-warning');
                    el_score__init.append($('<tr><td class="name"><b>'+engine.name+'</b></td><td><b>'+results.init.avg+'</b></td><td>'+results.init.min+'</td><td>'+results.init.max+'</td></tr>'));
                    el_score__init.append($('<tr><td class="name"><b>'+engine.name+' with includes</b></td><td><b>'+results_includes.init.avg+'</b></td><td>'+results_includes.init.min+'</td><td>'+results_includes.init.max+'</td></tr>'));

                    el_score__render.append($('<tr><td class="name"><b>'+engine.name+'</b></td><td><b>'+results.render.avg+'</b></td><td>'+results.render.min+'</td><td>'+results.render.max+'</td></tr>'));
                    el_score__render.append($('<tr><td class="name"><b>'+engine.name+' with includes</b></td><td><b>'+results_includes.render.avg+'</b></td><td>'+results_includes.render.min+'</td><td>'+results_includes.render.max+'</td></tr>'));

                    el_table__init.trigger("update");
                    el_table__render.trigger("update");
                }

                function on_finish() {
                    var sorting = [[1,0]];

                    el_table__init.tablesorter().trigger("sorton",[sorting]);
                    el_result__init.addClass('panel-warning');

                    el_table__render.tablesorter().trigger("sorton",[sorting]);
                    el_result__render.addClass('panel-warning');
                    el_start__button.text('Restart Benchmark!').removeAttr('disabled');
                }

                el_start__button.on('click', function(){
                    el_start__button.attr('disabled', 'disabled');
                    el_process.children().remove();
                    el_score__init.children().remove();
                    el_table__init.addClass('hidden');
                    el_result__init.addClass('hidden');
                    el_score__render.children().remove();
                    el_table__render.addClass('hidden');
                    el_result__render.addClass('hidden');

                    $.each(ENGINES, function(i, engine){
                        var engine_panel = $(
                            '<div id="panel_' + engine.id + '" class="panel panel-default">' +
                                '<div class="panel-heading">' +
                                    '<h3 class="panel-title">'+engine.name+' <span class="pull-right"><span class="point point-plain"></span> <a href="'+engine.url+'" target="_blank">Plain</a> <span class="point point-includes"></span> <a href="'+engine.url+'?include" target="_blank">Includes</a></span> </h3>' +
                                '</div>' +
                                '<div class="panel-body panel-chart">' +
                                    '<canvas id="chart_' + engine.id + '" width="524" height="77"></canvas>' +
                                    '<div class="progress active  progress-striped"><div id="bar_' + engine.id + '" class="progress-bar progress-bar-warning"></div></div>' +
                                '</div>' +
                            '</div>'
                        );
                        el_process.append(engine_panel);
                        el_result__init.removeClass('hidden').removeClass('panel-warning');
                        el_result__render.removeClass('hidden').removeClass('panel-warning');
                        el_sidebar.removeClass('hidden');
                    });
                    var benchmark = new Benchmark(ENGINES, {
                        'on_start': on_start,
                        'on_update': on_update,
                        'on_complete': on_complete,
                        'on_finish': on_finish
                    });
                    benchmark.start();
                });
            });
        </script>
    </body>
</html>
