function Benchmark(engines, options) {
    this.options = {
        "requests": 1000,
        "include": true,
        "on_start": function(){},
        "on_update": function(){},
        "on_complete": function(){},
        "on_finish": function(){}
    };
    $.extend(this.options, options);
    this.engines = engines.slice(0);
    this.total_request_counter = 0;
    this.request_counter = 0;
    this.is_clear_request = true;
    this.is_first_request = true;
    this.data = init_storage();
    var self = this;

    function init_storage() {
        return {
            'generation': [],
            'render': [],
            'init': []
        };
    }

    function get_values(filter) {
        return self.data[filter].map(function(item){return (item[1])})
    }

    function get_average(arr) {
        var x, sum = 0;
        for (x = 0; x < arr.length; x++) {
            arr[x] = +arr[x];
            sum += arr[x];
        }
        return (sum / arr.length);
    }

    function get_results() {
        var generation_values = get_values('generation');
        var init_values = get_values('init');
        var render_values = get_values('render');
        return {
            'generation': {
                'avg': get_average(generation_values).toFixed(2),
                'min': Math.min.apply({}, generation_values).toFixed(2),
                'max': Math.max.apply({}, generation_values).toFixed(2)
            },
            'init': {
                'avg': get_average(init_values).toFixed(2),
                'min': Math.min.apply({}, init_values).toFixed(2),
                'max': Math.max.apply({}, init_values).toFixed(2)
            },
            'render': {
                'avg': get_average(render_values).toFixed(2),
                'min': Math.min.apply({}, render_values).toFixed(2),
                'max': Math.max.apply({}, render_values).toFixed(2)
            },
            'memory': (self.data['memory']).toFixed(2)
        };
    }

    function request() {
        var cur_engine = self.engines[0];

        if (self.request_counter < self.options.requests) {
            var params = {'json': true};
            if (self.is_clear_request)
                params['clear'] = true;
            $.ajax({
                type: 'GET',
                data: params,
                url: cur_engine.url,
                dataType: 'json',
                async: 'false',
                success: function(json) {
                    var generation = (json['generation'] * 1000);
                    var init = (json['init'] * 1000);
                    var render = (json['render'] * 1000);
                    var memory = (json['memory'] / 1024);
                    if (self.is_clear_request) {
                        self.is_clear_request = false;
                        self.options.on_start(cur_engine);
                    } else {
                        if (self.is_first_request) {
                            self.is_first_request = false;
                            self.data['memory'] = memory;
                        }
                        var global_progress = Math.round((self.total_request_counter*100)/(self.options.requests * engines.length)).toFixed(1);
                        self.data['generation'].push([self.request_counter, generation]);
                        self.data['init'].push([self.request_counter, init]);
                        self.data['render'].push([self.request_counter, render]);
                        self.options.on_update(cur_engine, self.data, global_progress);
                        self.total_request_counter++;
                        self.request_counter++;
                    }
                    request();
                },
                error: request
            });
        } else {
            var results = get_results();
            self.options.on_complete(cur_engine, results);
            self.engines.shift();
            self.data = init_storage();
            self.is_clear_request = true;
            self.is_first_request = true;
            if (self.engines.length) {
                self.request_counter = 0;
                request();
            } else {
                self.options.on_finish();
                self.engines = [];
            }
        }
    }

    this.start = function () {
        request();
    };
}
