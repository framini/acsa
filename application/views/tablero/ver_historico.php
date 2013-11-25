<script src="<?php echo base_url(); ?>js/highcharts.js"></script>
<script src="<?php echo base_url(); ?>js/export.js"></script>
<script type="text/javascript">
	$(function () {
        $('#container').highcharts({
            title: {
                text: '<?php echo $this->uri->segment(4); ?>',
                x: -20 //center
            },
            xAxis: {
                categories: [
                    <?php 
					$count = 0;
					foreach ($data as $key => $value) {
						echo "'" . $value->fecha . "'";
						$count++;
						if( $count < count($data)) {
							echo ",";
						}
					};?>
                ]
            },
            yAxis: {
                title: {
                    text: ''
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: ''
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: [{
                name: '<?php echo $this->uri->segment(4); ?>',
                data: [
                	 <?php 
					$count = 0;
					foreach ($data as $key => $value) {
						echo $value->valor;
						$count++;
						if( $count < count($data)) {
							echo ",";
						}
					};?>
                ]
            }]
        });
    });
    

</script>

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
