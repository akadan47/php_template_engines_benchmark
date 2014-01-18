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
    this.request_count = this.options.requests;

    this.init = [];
    this.init_includes = [];
    this.render = [];
    this.render_includes = [];

    this.is_first = true;
    this.is_include = function(){return self.request_count % 2 === 0};

    var self = this;

    function average(arr) {
        var x, sum = 0;
        for (x = 0; x < arr.length; x++) {
            arr[x] = +arr[x];
            sum += arr[x];
        }
        return (sum / arr.length);
    }

    function get_results (init, render) {
        var result;
        result = {
            'init': {
                'avg': (average(init) * 1000).toFixed(2),
                'min': (Math.min.apply({}, init) * 1000).toFixed(2),
                'max': (Math.max.apply({}, init) * 1000).toFixed(2),
            },
            'render': {
                'avg': (average(render) * 1000).toFixed(2),
                'min': (Math.min.apply({}, render) * 1000).toFixed(2),
                'max': (Math.max.apply({}, render) * 1000).toFixed(2),
            }
        };
        return result;
    }

    function bench() {
        if (self.request_count > 0) {
            var params = {
                'json': true
            };
            if (self.is_first)
                params['clear'] = true;
            if (self.is_include())
                params['include'] = true;
            $.ajax({
                type: 'GET',
                data: params,
                url: self.engines[0].url,
                dataType: 'json',
                async: 'false',
                success: function(json) {
                    var time_init = json['time_init'];
                    var time_render = json['time_render'];
                    if (!self.is_first) {
                        if(self.is_include()){
                            self.init_includes.push(time_init);
                            self.render_includes.push(time_render);
                        } else {
                            self.init.push(time_init);
                            self.render.push(time_render);
                        }
                    } else {
                        self.is_first = false;
                        self.options.on_start(self.engines[0]);
                    }
                    var percent = Math.round(((self.options.requests - self.request_count)*100)/self.options.requests).toFixed(1)
                    self.options.on_update(
                        self.engines[0],
                        self.is_include(),
                        (time_init*1000).toFixed(4),
                        (time_render*1000).toFixed(4),
                        percent
                    );
                    self.request_count -= 1;
                    bench();
                },
                error: bench
            });
        } else {
            var results = get_results(self.init, self.render);
            var results_includes = get_results(self.init_includes, self.render_includes);
            self.options.on_complete(self.engines[0], results, results_includes);
            self.engines.shift();
            self.init = [];
            self.init_includes = [];
            self.render = [];
            self.render_includes = [];
            self.is_first = true;
            if (self.engines.length) {
                self.request_count = self.options.requests;
                bench();
            } else {
                self.options.on_finish();
            }
        }
    }

    this.start = function () {
        bench();
    };

}
