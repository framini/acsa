<?php //echo $data; die(); ?>

<style>

body {
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  margin: auto;
  position: relative;
  width: 1000px;
}

text {
  font: 10px sans-serif;
}

.axis path,
.axis line {
  fill: none;
  stroke: #000;
  shape-rendering: crispEdges;
}

</style>
<form>
  <label><input type="radio" name="mode" value="grouped" checked> Grouped</label>
  <label><input type="radio" name="mode" value="stacked" > Stacked</label>
</form>
<script src="http://d3js.org/d3.v3.min.js"></script>
<script>
$(function() {
  var n = 12, // number of layers
    m = 7, // number of samples per layer
    stack = d3.layout.stack(),
    // datos = d3.range(n).map(function() { return bumpLayer(m, .1); }),
    // datos = [
    //   [
    //     {
    //       x: 0,
    //       y: 1
    //     },
    //     {
    //       x: 1,
    //       y: 2
    //     }
    //     ,
    //     {
    //       x: 2,
    //       y: 2
    //     },
    //     {
    //       x: 3,
    //       y: 2
    //     },
    //     {
    //       x: 4,
    //       y: 3
    //     },
    //     {
    //       x: 5,
    //       y: 1.232
    //     },
    //     {
    //       x: 6,
    //       y: 5.233
    //     }
    //   ],
    //   [
    //     {
    //       x: 0,
    //       y: 2
    //     },
    //     {
    //       x: 1,
    //       y: 4
    //     }
    //     ,
    //     {
    //       x: 2,
    //       y: 3
    //     },
    //     {
    //       x: 3,
    //       y: 3
    //     },
    //     {
    //       x: 4,
    //       y: 4
    //     },
    //     {
    //       x: 5,
    //       y: 3.232
    //     },
    //     {
    //       x: 6,
    //       y: 7.233
    //     }
    //   ],
    //   [
    //     {
    //       x: 0,
    //       y: 4
    //     },
    //     {
    //       x: 1,
    //       y: 4
    //     }
    //     ,
    //     {
    //       x: 2,
    //       y: 6
    //     },
    //     {
    //       x: 3,
    //       y: 3
    //     },
    //     {
    //       x: 4,
    //       y: 8
    //     },
    //     {
    //       x: 5,
    //       y: 5.232
    //     },
    //     {
    //       x: 6,
    //       y: 7.233
    //     }
    //   ],
    //   [
    //     {
    //       x: 0,
    //       y: 4
    //     },
    //     {
    //       x: 1,
    //       y: 4
    //     }
    //     ,
    //     {
    //       x: 2,
    //       y: 6
    //     },
    //     {
    //       x: 3,
    //       y: 3
    //     },
    //     {
    //       x: 4,
    //       y: 8
    //     },
    //     {
    //       x: 5,
    //       y: 5.232
    //     },
    //     {
    //       x: 6,
    //       y: 7.233
    //     }
    //   ],
    //   [
    //     {
    //       x: 0,
    //       y: 4
    //     },
    //     {
    //       x: 1,
    //       y: 4
    //     }
    //     ,
    //     {
    //       x: 2,
    //       y: 6
    //     },
    //     {
    //       x: 3,
    //       y: 3
    //     },
    //     {
    //       x: 4,
    //       y: 8
    //     },
    //     {
    //       x: 5,
    //       y: 5.232
    //     },
    //     {
    //       x: 6,
    //       y: 7.233
    //     }
    //   ],
    //   [
    //     {
    //       x: 0,
    //       y: 4
    //     },
    //     {
    //       x: 1,
    //       y: 4
    //     }
    //     ,
    //     {
    //       x: 2,
    //       y: 6
    //     },
    //     {
    //       x: 3,
    //       y: 3
    //     },
    //     {
    //       x: 4,
    //       y: 8
    //     },
    //     {
    //       x: 5,
    //       y: 5.232
    //     },
    //     {
    //       x: 6,
    //       y: 7.233
    //     }
    //   ],
    //   [
    //     {
    //       x: 0,
    //       y: 4
    //     },
    //     {
    //       x: 1,
    //       y: 4
    //     }
    //     ,
    //     {
    //       x: 2,
    //       y: 6
    //     },
    //     {
    //       x: 3,
    //       y: 3
    //     },
    //     {
    //       x: 4,
    //       y: 8
    //     },
    //     {
    //       x: 5,
    //       y: 5.232
    //     },
    //     {
    //       x: 6,
    //       y: 7.233
    //     }
    //   ],
    //   [
    //     {
    //       x: 0,
    //       y: 4
    //     },
    //     {
    //       x: 1,
    //       y: 4
    //     }
    //     ,
    //     {
    //       x: 2,
    //       y: 6
    //     },
    //     {
    //       x: 3,
    //       y: 3
    //     },
    //     {
    //       x: 4,
    //       y: 8
    //     },
    //     {
    //       x: 5,
    //       y: 5.232
    //     },
    //     {
    //       x: 6,
    //       y: 7.233
    //     }
    //   ],
    //   [
    //     {
    //       x: 0,
    //       y: 4
    //     },
    //     {
    //       x: 1,
    //       y: 4
    //     }
    //     ,
    //     {
    //       x: 2,
    //       y: 6
    //     },
    //     {
    //       x: 3,
    //       y: 3
    //     },
    //     {
    //       x: 4,
    //       y: 8
    //     },
    //     {
    //       x: 5,
    //       y: 5.232
    //     },
    //     {
    //       x: 6,
    //       y: 7.233
    //     }
    //   ],
    //   [
    //     {
    //       x: 0,
    //       y: 4
    //     },
    //     {
    //       x: 1,
    //       y: 4
    //     }
    //     ,
    //     {
    //       x: 2,
    //       y: 6
    //     },
    //     {
    //       x: 3,
    //       y: 3
    //     },
    //     {
    //       x: 4,
    //       y: 8
    //     },
    //     {
    //       x: 5,
    //       y: 5.232
    //     },
    //     {
    //       x: 6,
    //       y: 7.233
    //     }
    //   ],
    //   [
    //     {
    //       x: 0,
    //       y: 4
    //     },
    //     {
    //       x: 1,
    //       y: 4
    //     }
    //     ,
    //     {
    //       x: 2,
    //       y: 6
    //     },
    //     {
    //       x: 3,
    //       y: 3
    //     },
    //     {
    //       x: 4,
    //       y: 8
    //     },
    //     {
    //       x: 5,
    //       y: 5.232
    //     },
    //     {
    //       x: 6,
    //       y: 7.233
    //     }
    //   ],
    //   [
    //     {
    //       x: 0,
    //       y: 4
    //     },
    //     {
    //       x: 1,
    //       y: 4
    //     }
    //     ,
    //     {
    //       x: 2,
    //       y: 6
    //     },
    //     {
    //       x: 3,
    //       y: 3
    //     },
    //     {
    //       x: 4,
    //       y: 8
    //     },
    //     {
    //       x: 5,
    //       y: 5.232
    //     },
    //     {
    //       x: 6,
    //       y: 19.000000
    //     }
    //   ]
    // ],
    datos = <?php echo $data; ?>,
    layers = stack(datos),
    yGroupMax = d3.max(layers, function(layer) { return d3.max(layer, function(d) { return d.y; }); }),
    yStackMax = d3.max(layers, function(layer) { return d3.max(layer, function(d) { return d.y0 + d.y; }); });

  console.log(layers);
  var margin = {top: 40, right: 10, bottom: 20, left: 10},
      width = 1000 - margin.left - margin.right,
      height = 500 - margin.top - margin.bottom;

  var x = d3.scale.ordinal()
      .domain(d3.range(m))
      .rangeRoundBands([0, width], .08);

  var y = d3.scale.linear()
      .domain([0, yStackMax])
      .range([height, 0]);

  var color = d3.scale.linear()
      .domain([0, 11])
      .range(["#aad", "#556"]);
  function formato(d) {
    return 2000 + d;
}
  var xAxis = d3.svg.axis()
      .scale(x)
      .tickSize(1)
      .tickPadding(6)
      .orient("bottom")
      .tickFormat(function(d) { return formato(d); });

  var svg = d3.select("body").append("svg")
      .attr("width", width + margin.left + margin.right)
      .attr("height", height + margin.top + margin.bottom)
    .append("g")
      .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

  var layer = svg.selectAll(".layer")
      .data(layers)
    .enter().append("g")
      .attr("class", "layer")
      .style("fill", function(d, i) { return color(i); });

  var rect = layer.selectAll("rect")
      .data(function(d) { return d; })
    .enter().append("rect")
      .attr("x", function(d) { return x(d.x); })
      .attr("y", height)
      .attr("width", x.rangeBand())
      .attr("height", 0);

  rect.transition()
      .delay(function(d, i) { return i * 10; })
      .attr("y", function(d) { return y(d.y0 + d.y); })
      .attr("height", function(d) { return y(d.y0) - y(d.y0 + d.y); });

  svg.append("g")
      .attr("class", "x axis")
      .attr("transform", "translate(0," + height + ")")
      .call(xAxis)
      // .selectAll("text")  
      //       .style("text-anchor", "end")
      //       .attr("dx", "-.8em")
      //       .attr("dy", ".15em")
      //       .attr("transform", function(d) {
      //           return "rotate(-65)" 
      //           });

  d3.selectAll("input").on("change", change);

  var timeout = setTimeout(function() {
    d3.select("input[value=\"grouped\"]").property("checked", true).each(change);
  }, 2000);

  function change() {
    clearTimeout(timeout);
    if (this.value === "grouped") transitionGrouped();
    else transitionStacked();
  }

  function transitionGrouped() {
    y.domain([0, yGroupMax]);

    rect.transition()
        .duration(500)
        .delay(function(d, i) { return i * 10; })
        .attr("x", function(d, i, j) { return x(d.x) + x.rangeBand() / n * j; })
        .attr("width", x.rangeBand() / n)
      .transition()
        .attr("y", function(d) { return y(d.y); })
        .attr("height", function(d) { return height - y(d.y); });
  }

  function transitionStacked() {
    y.domain([0, yStackMax]);

    rect.transition()
        .duration(500)
        .delay(function(d, i) { return i * 10; })
        .attr("y", function(d) { return y(d.y0 + d.y); })
        .attr("height", function(d) { return y(d.y0) - y(d.y0 + d.y); })
      .transition()
        .attr("x", function(d) { return x(d.x); })
        .attr("width", x.rangeBand());
  }

  // Inspired by Lee Byron's test data generator.
  function bumpLayer(n, o) {
    // console.log("ASDASD")
    function bump(a) {
      var x = 1 / (.1 + Math.random()),
          y = 2 * Math.random() - .5,
          z = 10 / (.1 + Math.random());
      for (var i = 0; i < n; i++) {
        var w = (i / n - y) * z;
        a[i] += x * Math.exp(-w * w);
      }
    }

    var a = [], i;
    for (i = 0; i < n; ++i) a[i] = o + o * Math.random();
    for (i = 0; i < 5; ++i) bump(a);

      // console.log(a.map(function(d, i) { return {x: i, y: Math.max(0, d)}; }));

    return a.map(function(d, i) { return {x: i, y: Math.max(0, d)}; });
  }
})


</script>