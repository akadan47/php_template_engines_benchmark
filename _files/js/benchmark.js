function Benchmark(engines, options) {
    this.options = {
        "requests": 1000,
        "include": true,
        "on_start": function(){},
        "on_step": function(){},
        "on_end": function(){},
        "on_complete": function(){}
    };
    $.extend(this.options, options);

    this.engines = engines.slice(0);
    this.request_count = this.options.requests;
    this.init = [];
    this.render = [];
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

    function bench() {
        if (self.request_count > 0) {
            var params = {
                'json': true
            };
            if (self.is_first) {
                params['clear'] = true
            }
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
                        self.init.push(time_init);
                        self.render.push(time_render);
                        self.request_count -= 1;
                        self.options.on_step(self.engines[0], (time_init*1000).toFixed(4), (time_render*1000).toFixed(4), Math.round(((self.options.requests - self.request_count)*100)/self.options.requests));
                    } else {
                        self.is_first = false;
                        self.options.on_start(self.engines[0]);
                    }
                    bench();
                },
                error: bench
            });
        } else {
            var avg_init = average(self.init) * 1000;
            var avg_render = average(self.render) * 1000;
            var min_init = Math.min.apply({}, self.init) * 1000;
            var min_render = Math.min.apply({}, self.render) * 1000;
            var max_init = Math.max.apply({}, self.init) * 1000;
            var max_render = Math.max.apply({}, self.render) * 1000;
            self.options.on_end(self.engines[0],
                avg_init.toFixed(2),
                min_init.toFixed(2),
                max_init.toFixed(2),
                avg_render.toFixed(2),
                min_render.toFixed(2),
                max_render.toFixed(2)
            );

            self.engines.shift();
            self.init = [];
            self.render = [];
            self.is_first = true;
            if (self.engines.length) {
                self.request_count = self.options.requests;
                bench();
            } else {
                self.options.on_complete();
            }
        }
    }

    this.start = function () {
        bench();
    };

}
