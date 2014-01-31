<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Typical page benchmark for PHP template engines</title>
        <link rel="stylesheet" href="/static/css/bootstrap.min.css">
        <link rel="stylesheet" href="/static/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="/static/css/style.css">

        <script type="text/javascript" src="/static/js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="/static/js/jquery.flot.js"></script>

        <script type="text/javascript" src="/static/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/static/js/jquery.slider.min.js"></script>

        <script type="text/javascript" src="/static/js/jquery.tablesorter.min.js"></script>
        <script type="text/javascript" src="/static/js/benchmark.js"></script>
        <?php
        error_reporting(0);
        $engines = array();
        if($handle = opendir('page'))
        {
            while(false !== ($file = readdir($handle)))
            {
                if(!in_array($file, array('.', '..', '.DS_Store', 'Thumbs.db')))
                {
                    $engine = array(
                        'id' => $file,
                        'name' => ucfirst(strpos($file, '_') ? substr($file, 0,
                                                strpos($file, '_')) : $file),
                        'version' => str_replace('-', '.',
                                substr(strstr($file, '_'), 1)),
                        'url' => '/page/'.$file.'/'
                    );
                    array_push($engines, $engine);
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
                        <?php
                        foreach($engines as $engine)
                        {
                            ?>
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

                        <div class="panel panel-default hidden" id="result_generation">
                            <div class="panel-heading"><h4 class="panel-title"><b>Page generation</b> <span class="pull-right unit">ms</span></h4></div>
                            <div class="panel-body">
                                <table class="table hidden" id="table_generation">
                                    <thead>
                                        <tr>
                                            <th class="name"><span>Engine</span></th>
                                            <th><span><b>Avg</b></span></th>
                                            <th><span>Min</span></th>
                                            <th><span>Max</span></th>
                                        </tr>
                                    </thead>
                                    <tbody id="score_generation">

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="panel panel-default hidden" id="result_init">
                            <div class="panel-heading"><h5 class="panel-title">Initialization <span class="pull-right unit">ms</span></h5></div>
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
                            <div class="panel-heading"><h5 class="panel-title">Render <span class="pull-right unit">ms</span></h5></div>
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

                        <div class="panel panel-default hidden" id="result_memory">
                            <div class="panel-heading"><h5 class="panel-title">Memory Usage <span class="pull-right unit">KB</span></h5></div>
                            <div class="panel-body">
                                <table class="table hidden" id="table_memory">
                                    <thead>
                                        <tr>
                                            <th class="name"><span>Engine</span></th>
                                            <th><span><b>Usage</b></span></th>
                                        </tr>
                                    </thead>
                                    <tbody id="score_memory">

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $(function() {
                var el_start__button = $('#start');
                var el_process = $('#process');
                var el_sidebar = $('#sidebar');
                var el_score__generation = $('#score_generation');
                var el_table__generation = $('#table_generation');
                var el_result__generation = $('#result_generation');
                var el_score__init = $('#score_init');
                var el_table__init = $('#table_init');
                var el_result__init = $('#result_init');

                var el_score__render = $('#score_render');
                var el_table__render = $('#table_render');
                var el_result__render = $('#result_render');

                var el_score__memory = $('#score_memory');
                var el_table__memory = $('#table_memory');
                var el_result__memory = $('#result_memory');

                var el_slider_wrap = $('#slider_wrap');
                var el_slider = $('#slider');
                var el_slider_value = $('#slider_value');
                var el_main_progress = $('#progress_bar_wrap');
                var el_main_progress_bar = $('#progress_bar');

                var btn_check_all = $('#check_all');
                var btn_uncheck_all = $('#uncheck_all');

                var list_checkboxes = $("#checkboxes input[type='checkbox']");

                el_table__generation.tablesorter();
                el_table__init.tablesorter();
                el_table__render.tablesorter();
                el_table__memory.tablesorter();

                // Functions
                function check_buttons() {
                    var checked = $("#checkboxes input[type='checkbox']:checked").length;
                    var all = list_checkboxes.length;
                    if (checked == all) {
                        btn_check_all.attr('disabled', 'disabled');
                    } else {
                        btn_check_all.removeAttr('disabled');
                    }
                    if (checked == 0) {
                        btn_uncheck_all.attr('disabled', 'disabled');
                        el_start__button.attr('disabled', 'disabled');
                    } else {
                        el_start__button.removeAttr('disabled');
                        btn_uncheck_all.removeAttr('disabled');
                    }
                }

                function on_start(engine) {
                    var container = $("#chart_" + engine.id);
                    engine.__generation = {
                        data: [],
                        lines: {
                            show: true,
                            fill: true,
                            lineWidth: 0,
                            fillColor: {colors: ["#00fa03", "#00fa03"]}
                        }
                    };
                    engine.__init = {
                        data: [],
                        lines: {
                            show: true,
                            fill: true,
                            lineWidth: 0,
                            fillColor: {colors: ["#0074ff", "#0074ff"]}
                        }
                    };
                    engine.series = [engine.__generation, engine.__init];
                    function tick_format(v, xaxis) {
                        return " "
                    }
                    engine.plot = $.plot(container, engine.series, {
                        grid: {
                            labelMargin: 0,
                            backgroundColor: "#fff",
                            borderColor: "#fff",
                            borderWidth: 0,
                            axisMargin: 0
                        },
                        xaxis: {
                            min: 0,
                            max: el_slider.val() - 1,
                            ticks: 50,
                            tickLength: 0,
                            minTickSize: 1,
                            autoscaleMargin: 1,
                            tickColor: '#ccc',
                            tickFormatter: tick_format
                        },
                        yaxis: {
                            min: 0,
                            max: 100
                        }
                    });
                }

                function on_update(engine, data, global_percent) {
                    engine.__generation.data = data['generation'];
                    engine.__init.data = data['init'];
                    engine.plot.setData(engine.series);
                    engine.plot.draw();
                    el_main_progress_bar.css('width', global_percent + "%");
                }

                function on_complete(engine, results) {
                    if (el_score__generation.children())
                        el_table__generation.removeClass('hidden');
                    if (el_score__init.children())
                        el_table__init.removeClass('hidden');
                    if (el_score__render.children())
                        el_table__render.removeClass('hidden');
                    if (el_score__memory.children())
                        el_table__memory.removeClass('hidden');
                    $('.panel-warning').removeClass('panel-warning');

                    el_score__generation.append($('<tr><td class="name"><b>' + engine.name + '</b> ' + engine.version + '</td><td><b>' + results.generation.avg + '</b></td><td>' + results.generation.min + '</td><td>' + results.generation.max + '</td></tr>'));
                    el_score__init.append($('<tr><td class="name"><b>' + engine.name + '</b> ' + engine.version + '</td><td><b>' + results.init.avg + '</b></td><td>' + results.init.min + '</td><td>' + results.init.max + '</td></tr>'));
                    el_score__render.append($('<tr><td class="name"><b>' + engine.name + '</b> ' + engine.version + '</td><td><b>' + results.render.avg + '</b></td><td>' + results.render.min + '</td><td>' + results.render.max + '</td></tr>'));
                    el_score__memory.append($('<tr><td class="name"><b>' + engine.name + '</b> ' + engine.version + '</td><td><b>' + results.memory + '</b></td></tr>'));

                    el_table__generation.trigger('update').trigger("sorton", [[[1, 0]]]);
                    el_table__init.trigger('update').trigger("sorton", [[[1, 0]]]);
                    el_table__render.trigger('update').trigger("sorton", [[[1, 0]]]);
                    el_table__memory.trigger('update').trigger("sorton", [[[1, 0]]]);
                }

                function on_finish() {
                    el_result__generation.addClass('panel-warning');
                    el_result__init.addClass('panel-warning');
                    el_result__render.addClass('panel-warning');
                    el_result__memory.addClass('panel-warning');

                    $('#toolbar').removeClass('hidden');
                    $('#checkboxes').removeClass('hidden');

                    el_main_progress_bar.css('width', '0%');
                    el_main_progress.addClass('hidden');
                    el_slider_wrap.removeClass('hidden');
                    el_start__button.text('Restart Benchmark!').removeAttr('disabled');
                }

                // Handlers
                btn_check_all.on('click', function() {
                    list_checkboxes.prop('checked', 'checked');
                    check_buttons();
                });

                btn_uncheck_all.on('click', function() {
                    list_checkboxes.removeAttr('checked');
                    check_buttons();
                });

                list_checkboxes.on('click', function() {
                    check_buttons();
                });

                el_slider.on("slider:ready slider:changed", function(event, data) {
                    el_slider_value.html(data.value + ' requests');
                });
                el_slider.simpleSlider({'range': [50, 1000], 'step': 50, 'snap': true, 'highlight': true, 'theme': 'volume'});

                el_start__button.on('click', function() {
                    el_start__button.attr('disabled', 'disabled');
                    el_process.children().remove();
                    el_score__generation.children().remove();
                    el_table__generation.addClass('hidden');
                    el_result__generation.addClass('hidden');
                    el_score__init.children().remove();
                    el_table__init.addClass('hidden');
                    el_result__init.addClass('hidden');
                    el_score__render.children().remove();
                    el_table__render.addClass('hidden');
                    el_result__render.addClass('hidden');
                    el_score__memory.children().remove();
                    el_table__memory.addClass('hidden');
                    el_result__memory.addClass('hidden');
                    el_slider_wrap.addClass('hidden');
                    el_main_progress.removeClass('hidden');
                    $.tablesorter.clearTableBody(el_table__generation);
                    $.tablesorter.clearTableBody(el_table__render);
                    $.tablesorter.clearTableBody(el_table__init);
                    $.tablesorter.clearTableBody(el_table__memory);
                    $('#toolbar').addClass('hidden');
                    $('#checkboxes').addClass('hidden');
                    $('.headerSortDown').removeClass('headerSortDown');
                    $('.headerSortUp').removeClass('headerSortUp');
                    var checked_engines = [];

                    $.each($("#checkboxes input[type='checkbox']:checked"), function(i, item) {
                        var item = $(item);
                        checked_engines.push({
                            'id': item.data('id'),
                            'name': item.data('name'),
                            'version': item.data('version'),
                            'url': item.data('url')
                        });
                    });

                    $.each(checked_engines, function(i, engine) {
                        var engine_panel = $(
                                '<div id="panel_' + engine.id + '" class="panel panel-default">' +
                                '<div class="panel-heading">' +
                                '<h3 class="panel-title"><b>' + engine.name + '</b> ' + engine.version + ' <span class="pull-right label label-default"><a target="_blank" href="' + engine.url + '">HTML</a></span> <span class="pull-right legend"><span class="point point-init"></span>initialization <span class="point point-render"></span>render</span> </h3>' +
                                '</div>' +
                                '<div class="panel-body panel-chart">' +
                                '<div id="chart_' + engine.id + '" style="width: 605px; height: 100px"></div>' +
                                '</div>' +
                                '</div>'
                                );
                        el_process.append(engine_panel);
                        el_result__generation.removeClass('hidden').removeClass('panel-warning');
                        el_result__init.removeClass('hidden').removeClass('panel-warning');
                        el_result__render.removeClass('hidden').removeClass('panel-warning');
                        el_result__memory.removeClass('hidden').removeClass('panel-warning');
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

                check_buttons();
            });
        </script>
    </body>
</html>
