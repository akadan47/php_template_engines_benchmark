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
    this.data = [];
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
            $.ajax({
                type: 'GET',
                data: {'json':true},
                url: self.engines[0].url,
                dataType: 'json',
                async: 'false',
                success: function(json) {
                    var time = json['time'];
                    if (!self.is_first) {
                        self.data.push(time);
                        self.request_count -= 1;
                        self.options.on_step(self.engines[0], (time).toFixed(8), self.request_count);
                    } else {
                        self.is_first = false;
                        self.options.on_start(self.engines[0]);
                    }
                    bench();
                },
                error: bench
            });
        } else {
            var average_time = average(self.data) * 1000;
            var min_time = Math.min.apply({}, self.data) * 1000;
            var max_time = Math.max.apply({}, self.data) * 1000;
            self.options.on_end(self.engines[0], average_time.toFixed(2), min_time.toFixed(2), max_time.toFixed(2));

            self.engines.shift();
            self.data = [];
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
