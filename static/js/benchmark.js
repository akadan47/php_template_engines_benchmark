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
    this.engines_count = engines.length;
    this.request_count = this.options.requests;
    this.all_request_count = (this.options.requests * this.engines_count);
    this.data = {
        'generation': [],
        'render': [],
        'init': []
    };
    this.is_clear_request = true;
    this.is_first_request = true;
    this.save = 0;

    var self = this;


    function get_values(filter) {
        return self.data[filter].map(function(item){return (item[1])})
    }

    function get_time_from_start() {
        var arr = self.data['generation'];
        return (arr[arr.length-1][0]/10).toFixed(2)
    }

    function average(arr) {
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
                'avg': average(generation_values).toFixed(2),
                'min': Math.min.apply({}, generation_values).toFixed(2),
                'max': Math.max.apply({}, generation_values).toFixed(2)
            },
            'init': {
                'avg': average(init_values).toFixed(2),
                'min': Math.min.apply({}, init_values).toFixed(2),
                'max': Math.max.apply({}, init_values).toFixed(2)
            },
            'render': {
                'avg': average(render_values).toFixed(2),
                'min': Math.min.apply({}, render_values).toFixed(2),
                'max': Math.max.apply({}, render_values).toFixed(2)
            },
            'time_from_start': get_time_from_start()
        };
    }

    function microtime(get_as_float) {
        var now = new Date().getTime() / 1000;
        var s = parseInt(now, 10);
        return (get_as_float) ? now : (Math.round((now - s) * 1000) / 1000) + ' ' + s;
    }

    function request() {
        if (self.request_count > 0) {
            var params = {
                'json': true
            };
            if (self.is_clear_request)
                params['clear'] = true;
            $.ajax({
                type: 'GET',
                data: params,
                url: self.engines[0].url,
                dataType: 'json',
                async: 'false',
                success: function(json) {
                    var generation = (json['generation'] * 1000);
                    var init = (json['init'] * 1000);
                    var render = (json['render'] * 1000);
                    var time = json['time'];

                    var time_from_start = 0.00;

                    var progress = Math.round(((self.options.requests - self.request_count)*100)/self.options.requests).toFixed(1);
                    var global_progress = Math.round((((self.options.requests * self.engines_count) - self.all_request_count)*100)/(self.options.requests * self.engines_count)).toFixed(1);

                    if (self.is_clear_request) {
                        self.is_clear_request = false;
                        self.options.on_start(self.engines[0]);
                    } else {
                        if (self.is_first_request) {
                            self.save = microtime(time);
                            self.is_first_request = false;
                        } else
                            time_from_start = ((microtime(time)-self.save)*10);
                        self.data['generation'].push([time_from_start, generation]);
                        self.data['init'].push([time_from_start, init]);
                        self.data['render'].push([time_from_start, render]);

                        setTimeout(function(){
                            self.options.on_update(self.engines[0], self.data, progress, global_progress);
                        }, 0);

                        self.request_count--;
                        self.all_request_count--;
                    }
                    request();
                },
                error: request
            });
        } else {
            var results = get_results();
            self.options.on_complete(self.engines[0], results);
            self.engines.shift();
            self.data = {
                'generation': [],
                'render': [],
                'init': []
            };
            self.is_first_request = true;
            self.is_clear_request = true;
            if (self.engines.length) {
                self.request_count = self.options.requests;
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
