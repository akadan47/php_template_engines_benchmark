<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Typical page benchmark for PHP template engines</title>
        <link rel="stylesheet" href="/static/css/bootstrap.min.css">
        <link rel="stylesheet" href="/static/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="/static/css/style.css">

        <script type="text/javascript" src="/static/js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="/static/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/static/js/simple-slider.min.js"></script>
        <script type="text/javascript" src="/static/js/smoothie.js"></script>
        <script type="text/javascript" src="/static/js/jquery.tablesorter.js"></script>
        <script type="text/javascript" src="/static/js/benchmark.js"></script>

            <?php
                error_reporting(0);
                $engines = array();
                if ($handle = opendir('page')) {
                    while (false !== ($file = readdir($handle)))
                    {
                        if (!in_array($file, array('.', '..', '.DS_Store', 'Thumbs.db')))
                        {
                            $engine = array(
                                'id' => str_replace(' ', '_', strtolower(explode('_', $file)[0])).str_replace('-','', explode('_', $file)[1]),
                                'name' => ucfirst(explode('_', $file)[0]),
                                'version' => str_replace('-','.', explode('_', $file)[1]),
                                'url' => '/page/'.$file.'/'
                            );
                            array_push($engines, $engine);
//                            $cache_dir = './page/'.$file.'/tpl/cache/'.'<br>';
//                            chmod($cache_dir, 0644);
                        }
                    }
                    closedir($handle);
                }
            ?>

    </head>
    <body>
        <div class="container">
            <div class="row header">
                <h2>Typical Page Benchmark for PHP template engines</h2>
            </div>
            <hr/>
            <div class="row">
                <div id="choose" class="well well-sm">

                    <div class="progress active progress-striped hidden" id="progress_bar_wrap"><div id="progress_bar" class="progress-bar progress-bar-primary"></div></div>

                    <div style="text-align: center" id="toolbar">
                        <div class="btn-group">
                            <button id="check_all" type="button" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-check"></span> Check All</button>
                            <button id="uncheck_all" type="button" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-unchecked"></span> Uncheck All</button>
                        </div>
                    </div>

                    <div class="checkboxes" id="checkboxes">
                        <?php foreach ($engines as $engine) { ?>
                            <span class="checkbox"><label><input type="checkbox" checked="checked" id="engine_<?php echo $engine["id"] ?>" data-id="<?php echo $engine["id"] ?>" data-name="<?php echo $engine["name"] ?>" data-version="<?php echo $engine["version"] ?>" data-url="<?php echo $engine["url"] ?>"> <b><?php echo $engine["name"] ?></b> <?php echo $engine["version"] ?></label></span>
                        <?php } ?>
                    </div>
                    <div id="slider_wrap">
                        <span id="slider_value"></span>
                        <input id="slider" type="text" value="500">
                    </div>

                    <div style="text-align: center">
                        <button class="btn btn-lg btn-warning" id="start">Start benchmark!</button>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div id="process"></div>
                </div>
                <div id="sidebar" class="col-xs-4 hidden">
                    <div class="bs-sidebar hidden-print affix-top">
                        <div class="panel panel-default hidden" id="result_time">
                            <div class="panel-heading"><h4 class="panel-title"><b>Total generation time</b> <span class="pull-right unit">ms</span></h4></div>
                            <div class="panel-body">
                                <table class="table hidden" id="table_time">
                                    <thead>
                                        <tr>
                                            <th class="name"><span>Engine</span></th>
                                            <th><span><b>Avg</b></span></th>
                                            <th><span>Min</span></th>
                                            <th><span>Max</span></th>
                                        </tr>
                                    </thead>
                                    <tbody id="score_time">

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="panel panel-default hidden" id="result_init">
                            <div class="panel-heading"><h5 class="panel-title">Initialization time <span class="pull-right unit">ms</span></h5></div>
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
                            <div class="panel-heading"><h5 class="panel-title">Render time <span class="pull-right unit">ms</span></h5></div>
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

                var el_score__time = $('#score_time');
                var el_table__time = $('#table_time');
                var el_result__time = $('#result_time');

                var el_score__init = $('#score_init');
                var el_table__init = $('#table_init');
                var el_result__init = $('#result_init');

                var el_score__render = $('#score_render');
                var el_table__render = $('#table_render');
                var el_result__render = $('#result_render');

                var el_slider_wrap = $('#slider_wrap');
                var el_slider = $('#slider');
                var el_slider_value = $('#slider_value');

                el_table__time.tablesorter();
                el_table__init.tablesorter();
                el_table__render.tablesorter();

                var el_main_progress = $('#progress_bar_wrap');
                var el_main_progress_bar = $('#progress_bar');

                $("#checkboxes input[type='checkbox']").on('click', function(){
                    check_buttons();
                });

                el_slider.on("slider:ready slider:changed", function (event, data) {
                    el_slider_value.html(data.value + ' requests');
                });

                el_slider.simpleSlider({
                    'range': [50,1000],
                    'step': 50,
                    'snap': true,
                    'highlight': true,
                    'theme': 'volume'
                });

                $('#check_all').on('click', function() {
                    $("#checkboxes input[type='checkbox']").prop('checked', 'checked');
                    check_buttons();
                });

                $('#uncheck_all').on('click', function() {
                    $("#checkboxes input[type='checkbox']").removeAttr('checked');
                    check_buttons();
                });

                function on_start(engine){
                    engine.line_time = new TimeSeries();
                    engine.line_init = new TimeSeries();
                    engine.chart = new SmoothieChart({millisPerPixel:50,maxValueScale:2,minValue:0, maxValue:100,grid:{fillStyle:'#ffffff',strokeStyle:'rgba(119,119,119,0.11)',sharpLines:true,borderVisible:false},labels:{fillStyle:'#777777'}});
                    engine.chart.addTimeSeries(engine.line_time, {lineWidth:0.25, strokeStyle:'#58fa46', fillStyle:'#58fa46'});
                    engine.chart.addTimeSeries(engine.line_init, {lineWidth:0.25, strokeStyle:'#00acff', fillStyle:'#00acff'});

                    engine.chart.streamTo(document.getElementById("chart_"+engine.id), 100);
                    engine.chart.start();
                    $('#panel_'+engine.id).addClass('panel-warning');

                }

                function on_update(engine, time, time_init, time_render, percent, main_percent) {
                    engine.line_init.append(new Date().getTime(), time_init);
                    engine.line_time.append(new Date().getTime(), time);
                    $('#bar_'+engine.id).css('width', percent+"%");
                    el_main_progress_bar.css('width', main_percent+"%");
                }

                function on_complete(engine, results) {
                    engine.chart.stop();

                    if (el_score__time.children())
                        el_table__time.removeClass('hidden');
                    if (el_score__init.children())
                        el_table__init.removeClass('hidden');
                    if (el_score__render.children())
                        el_table__render.removeClass('hidden');
                    $('#bar_'+engine.id).css('width', "100%").css('opacity', '0.15');
                    $('.panel-warning').removeClass('panel-warning');
                    el_score__time.append($('<tr><td class="name"><b>'+engine.name+'</b> '+ engine.version +'</td><td><b>'+results.time.avg+'</b></td><td>'+results.time.min+'</td><td>'+results.time.max+'</td></tr>'));
                    el_score__init.append($('<tr><td class="name"><b>'+engine.name+'</b> '+ engine.version +'</td><td><b>'+results.init.avg+'</b></td><td>'+results.init.min+'</td><td>'+results.init.max+'</td></tr>'));
                    el_score__render.append($('<tr><td class="name"><b>'+engine.name+'</b> '+ engine.version +'</td><td><b>'+results.render.avg+'</b></td><td>'+results.render.min+'</td><td>'+results.render.max+'</td></tr>'));

                    var sorting = [[1,0]];
                    el_table__time.trigger('update').trigger("sorton", [sorting]);
                    el_table__init.trigger('update').trigger("sorton", [sorting]);
                    el_table__render.trigger('update').trigger("sorton", [sorting]);
                }

                function on_finish() {

                    el_result__time.addClass('panel-warning');
                    el_result__init.addClass('panel-warning');
                    el_result__render.addClass('panel-warning');

                    $('#toolbar').removeClass('hidden');
                    $('#checkboxes').removeClass('hidden');

                    el_main_progress_bar.css('width', '0%');
                    el_main_progress.addClass('hidden');
                    el_slider_wrap.removeClass('hidden');
                    el_start__button.text('Restart Benchmark!').removeAttr('disabled');
                }

                function check_buttons() {
                    var checked = $("#checkboxes input[type='checkbox']:checked").length;
                    var all = $("#checkboxes input[type='checkbox']").length
                    if (checked == all) {
                        $('#check_all').attr('disabled', 'disabled');
                    } else {
                        $('#check_all').removeAttr('disabled');
                    }
                    if (checked == 0) {
                        $('#uncheck_all').attr('disabled', 'disabled');
                        el_start__button.attr('disabled', 'disabled');
                    } else {
                        el_start__button.removeAttr('disabled');
                        $('#uncheck_all').removeAttr('disabled');
                    }
                }

                check_buttons();

                el_start__button.on('click', function(){
                    el_start__button.attr('disabled', 'disabled');
                    el_process.children().remove();

                    el_score__time.children().remove();
                    el_table__time.addClass('hidden');
                    el_result__time.addClass('hidden');

                    el_score__init.children().remove();
                    el_table__init.addClass('hidden');
                    el_result__init.addClass('hidden');

                    el_score__render.children().remove();
                    el_table__render.addClass('hidden');
                    el_result__render.addClass('hidden');

                    el_slider_wrap.addClass('hidden');

                    $.tablesorter.clearTableBody(el_table__time);
                    $.tablesorter.clearTableBody(el_table__render);
                    $.tablesorter.clearTableBody(el_table__init);

                    el_main_progress.removeClass('hidden');

                    $('#toolbar').addClass('hidden');
                    $('#checkboxes').addClass('hidden');

                    $('.headerSortDown').removeClass('headerSortDown');
                    $('.headerSortUp').removeClass('headerSortUp');
                    var checked_engines = [];
                    $.each($("#checkboxes input[type='checkbox']:checked"), function(i, item){
                        var item = $(item);
                           checked_engines.push(
                               {
                                    "id": item.data('id'),
                                    "name": item.data('name'),
                                    "version": item.data('version'),
                                    "url": item.data('url')
                               }
                           )
                    });
                    $.each(checked_engines, function(i, engine){
                        var engine_panel = $(
                            '<div id="panel_' + engine.id + '" class="panel panel-default">' +
                                '<div class="panel-heading">' +
                                    '<h3 class="panel-title"><b>'+engine.name+'</b> '+ engine.version +' <span class="pull-right label label-default"><a target="_blank" href="'+engine.url+'">HTML</a></span> <span class="pull-right legend"><span class="point point-init"></span>initialization <span class="point point-render"></span>render</span> </h3>' +
                                '</div>' +
                                '<div class="panel-body panel-chart">' +
                                    '<canvas id="chart_' + engine.id + '" width="605" height="77"></canvas>' +
                                    '<div class="progress active  progress-striped"><div id="bar_' + engine.id + '" class="progress-bar progress-bar-primary"></div></div>' +
                                '</div>' +
                            '</div>'
                        );
                        el_process.append(engine_panel);
                        el_result__time.removeClass('hidden').removeClass('panel-warning');
                        el_result__init.removeClass('hidden').removeClass('panel-warning');
                        el_result__render.removeClass('hidden').removeClass('panel-warning');

                        el_sidebar.removeClass('hidden');
                    });

                    var benchmark = new Benchmark(checked_engines, {
                        'on_start': on_start,
                        'on_update': on_update,
                        'on_complete': on_complete,
                        'on_finish': on_finish,
                        'requests': el_slider.val()
                    });
                    benchmark.start();
                });

            });
        </script>
    </body>
</html>
