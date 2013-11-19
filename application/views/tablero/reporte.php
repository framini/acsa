
<?php echo form_open($this->uri->uri_string()); ?>
<select name="id">
<?php 
if(count($indicadores) > 0) {
  echo "<option value='todos'>Todos</option>";
  foreach ($indicadores as $key => $value) {
    echo "<option value='" . $value['id'] . "'>";
    echo $value['id'];
    echo "</option>";
  }
}
?>
</select>
<input type="text" name="fecha_inicio" id="from" required />
<input type="text" name="fecha_fin" id="to" required />
<button type="submit" class="DTTT_button ui-button ui-state-default DTTT_button_print" style="margin-top: -9px;" id="pasaje_historico">Filtrar</button>
</form>
<?php //echo $data; die(); ?>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script type="text/javascript">
  $(function(){
    $('#datepicker').datepicker();

    $( "#from" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 3,
      onClose: function( selectedDate ) {
        $( "#to" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#to" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 3,
      onClose: function( selectedDate ) {
        $( "#from" ).datepicker( "option", "maxDate", selectedDate );
      }
    });

    $('#from').datepicker('option', 'dateFormat', 'yymmdd');
    $('#to').datepicker('option', 'dateFormat', 'yymmdd');
  })
</script>
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
<form style="display: none;">
  <label><input type="radio" name="mode" value="grouped" checked> Grouped</label>
  <label><input type="radio" name="mode" value="stacked" > Stacked</label>
</form>
<div id="vis"></div>
<script src="http://d3js.org/d3.v3.min.js"></script>
<script>
$(function() {
  console.log(<?php echo $data; ?>);
  var n = 12, // number of layers
    m = 7, // number of samples per layer
    stack = d3.layout.stack(),
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

  //d3.selectAll("input").on("change", change);

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


// function main() {
//   // This is a reimplementation of the Grouped Bar Chart by Mike Bostock
//   // (http://bl.ocks.org/882152). Although useful, I found the original's
//   // minimal comments and inverted axes hard to follow, so I created the
//   // version you see here.

//   // First, we define sizes and colours...
//   var outerW = 800; // outer width
//   var outerH = 680; // outer height
//   var padding = { t: 0, r: 0, b: 0, l: 0 };
//   var w = outerW - padding.l - padding.r; // inner width
//   var h = outerH - padding.t - padding.b; // inner height
//   var c = [ "#E41A1C", "#377EB8", "#4DAF4A", "#98abc5", "#8a89a6", "#7b6888", "#6b486b", "#a05d56", "#d0743c", "#ff8c00" ]; // ColorBrewer Set 1

//   // Second, we define our data...
//   // Create a two-dimensional array.
//   // The first dimension has as many Array elements as there are series.
//   // The second dimension has as many Number elements as there are groups.
//   // It looks something like this...
//   //  var data = [
//   //    [ 0.10, 0.09, 0.08, 0.07, 0.06, ... ], // series 1
//   //    [ 0.10, 0.09, 0.08, 0.07, 0.06, ... ], // series 2
//   //    [ 0.10, 0.09, 0.08, 0.07, 0.06, ... ]  // series 3
//   //  ];
//   var numberGroups = 7; // groups
//   var numberSeries = 12;  // series in each group
//   console.log(d3.range(numberSeries).map(function () { return d3.range(numberGroups).map(Math.random); }))
//   //var data = d3.range(numberSeries).map(function () { return d3.range(numberGroups).map(Math.random); });
//   var data = <?php echo $data; ?>;
//   //console.log("EL DE PHP");
//   console.log(<?php echo $data; ?>);
//   //console.log( [[58.0,424.0,110.0,318.0,225.0,630.0,7.0],[0.10,0.09,0.08,0.07,0.06, 0.02, 0.02],[0.10,0.09,0.08,0.07,0.06, 0.02, 0.02]])

//   // Third, we define our scales...
//   // Groups scale, x axis
//   var x0 = d3.scale.ordinal()
//       .domain(d3.range(numberGroups))
//       .rangeBands([0, w], 0.4);

//   // Series scale, x axis
//   // It might help to think of the series scale as a child of the groups scale
//   var x1 = d3.scale.ordinal()
//       .domain(d3.range(numberSeries))
//       .rangeBands([0, x0.rangeBand()]);

//   // Values scale, y axis
//   var y = d3.scale.linear()
//       .domain([0, 1]) // Because Math.random returns numbers between 0 and 1
//       .range([0, h]);

//   // Visualisation selection
//   var vis = d3.select("#vis")
//       .append("svg:svg")
//       .attr("width", outerW)
//       .attr("height", outerH);

//   // Series selection
//   // We place each series into its own SVG group element. In other words,
//   // each SVG group element contains one series (i.e. bars of the same colour).
//   // It might be helpful to think of each SVG group element as containing one bar chart.
//   var series = vis.selectAll("g.series")
//       .data(data)
//     .enter().append("svg:g")
//       .attr("class", "series") // Not strictly necessary, but helpful when inspecting the DOM
//       .attr("fill", function (d, i) { return c[i]; })
//       .attr("transform", function (d, i) { return "translate(" + x1(i) + ")"; });

//   // Groups selection
//   var groups = series.selectAll("rect")
//       .data(Object) // The second dimension in the two-dimensional data array
//     .enter().append("svg:rect")
//         .attr("x", 0)
//         .attr("y", function (d) { return h - y(d); })
//         .attr("width", x1.rangeBand())
//         .attr("height", y)
//         .attr("transform", function (d, i) { return "translate(" + x0(i) + ")"; });
// }


// $(document).ready(function () {
//   main();
// });



</script>