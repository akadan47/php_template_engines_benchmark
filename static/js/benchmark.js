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
    //this.on_every = function(x){return self.request_count % x === 0};

    this.data_generation = [];
    this.data_init = [];
    this.data_render = [];

    this.is_first = true;

    var self = this;

    function average(arr) {
        var x, sum = 0;
        for (x = 0; x < arr.length; x++) {
            arr[x] = +arr[x];
            sum += arr[x];
        }
        return (sum / arr.length);
    }

    function get_results (time, init, render) {
        var result;
        result = {
            'generation': {
                'avg': (average(time) * 1000).toFixed(2),
                'min': (Math.min.apply({}, time) * 1000).toFixed(2),
                'max': (Math.max.apply({}, time) * 1000).toFixed(2)
            },
            'init': {
                'avg': (average(init) * 1000).toFixed(2),
                'min': (Math.min.apply({}, init) * 1000).toFixed(2),
                'max': (Math.max.apply({}, init) * 1000).toFixed(2)
            },
            'render': {
                'avg': (average(render) * 1000).toFixed(2),
                'min': (Math.min.apply({}, render) * 1000).toFixed(2),
                'max': (Math.max.apply({}, render) * 1000).toFixed(2)
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
            $.ajax({
                type: 'GET',
                data: params,
                url: self.engines[0].url,
                dataType: 'json',
                async: 'false',
                success: function(json) {
                    var generation = json['generation'];
                    var init = json['init'];
                    var render = json['render'];
                    if (!self.is_first) {
                        self.data_generation.push(generation);
                        self.data_init.push(init);
                        self.data_render.push(render);
                    } else {
                        self.is_first = false;
                        self.options.on_start(self.engines[0]);
                    }
                    var percent = Math.round(((self.options.requests - self.request_count)*100)/self.options.requests).toFixed(1);
                    var main_percent = Math.round((((self.options.requests * self.engines_count) - self.all_request_count)*100)/(self.options.requests * self.engines_count)).toFixed(1);

                    self.options.on_update(
                        self.engines[0],
                        (generation * 1000).toFixed(4),
                        (init * 1000).toFixed(4),
                        (render*1000).toFixed(4),
                        percent,
                        main_percent
                    );


                    self.request_count -= 1;
                    self.all_request_count -= 1;
                    bench();
                },
                error: bench
            });
        } else {
            var results = get_results(self.data_generation, self.data_init, self.data_render);
            self.options.on_complete(self.engines[0], results);
            self.engines.shift();
            self.data_generation = [];
            self.data_init = [];
            self.data_init = [];
            self.is_first = true;
            if (self.engines.length) {
                self.request_count = self.options.requests;
                bench();
            } else {
                self.options.on_finish();
                self.engines = [];
            }
        }
    }

    this.start = function () {
        bench();
    };

}
