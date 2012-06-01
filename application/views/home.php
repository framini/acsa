<?php 
	//var_dump(($cotizacion)); die(); 
?>
<div class="row">
	<div class="widget widget-nopad span6">
							
					<div class="widget-header" id="twitter_barra">
						<i class="icon-nav-home-logged-out"></i>
						<h3></h3>
					</div> <!-- /widget-header -->
					
					<div class="widget-content">
						
						<ul class="news-items">
							<?php 
								foreach ($tweets as $key => $tweet) {
									echo '<li>';
										echo '<div class="news-item-detail">';
											echo '<p class="news-item-preview">';
												echo $tweet->text;
											echo '</p>';
										echo '</div>';
										echo '<div class="news-item-month">';
										echo	'<span class="news-item-day">';
											$afecha = date_parse_from_format("D M d H:i:s O Y",$tweet->created_at);
											echo $afecha['hour'] . ':' . $afecha['minute'];
										echo 	'</span>';
										echo	'<span class="news-item-month">';
										echo 		$afecha['day'] . "/" . $afecha['month'] . "/" . $afecha['year'];
										echo 	'</span>';
										echo '</div>';
									echo '</li>';
								}
							 ?>
							<!--<li>
								
								<div class="news-item-detail">										
									<a href="javascript:;" class="news-item-title">Duis aute irure dolor in reprehenderit</a>
									<p class="news-item-preview">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore.</p>
								</div>
								
								<div class="news-item-date">
									<span class="news-item-day">08</span>
									<span class="news-item-month">Mar</span>
								</div>
							</li>
							<li>
								<div class="news-item-detail">										
									<a href="javascript:;" class="news-item-title">Duis aute irure dolor in reprehenderit</a>
									<p class="news-item-preview">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore.</p>
								</div>
								
								<div class="news-item-date">
									<span class="news-item-day">08</span>
									<span class="news-item-month">Mar</span>
								</div>
							</li>
							<li>
								<div class="news-item-detail">										
									<a href="javascript:;" class="news-item-title">Duis aute irure dolor in reprehenderit</a>
									<p class="news-item-preview">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore.</p>
								</div>
								
								<div class="news-item-date">
									<span class="news-item-day">08</span>
									<span class="news-item-month">Mar</span>
								</div>
							</li>-->
						</ul>
						
					</div> <!-- /widget-content -->
				
				</div>
				
				
				<div class="widget widget-table action-table span6 last">
						
					<div class="widget-header">
						<i class="icon-globe"></i>
						<h3>Cotizaciones</h3>
					</div> <!-- /widget-header -->
					
					<div class="widget-content">
						
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>Moneda</th>
									<th>Cotizacion</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($cotizacion as $key => $moneda) { $m = json_decode($moneda); ?>
								<tr>
									<td><?php echo $key; ?></td>
									<td><?php echo $m->rhs; ?></td>
								</tr>
								<?php } ?>
								
							</tbody>
						</table>
						
					</div> <!-- /widget-content -->
				
				</div>
				<script type="text/javascript">
					    $('#myTab a').click(function (e) {
					    	e.preventDefault();
					    	$(this).tab('show');
					    });
				</script>
				<ul class="nav nav-tabs" id="myTab">
		            <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
		            <li class=""><a data-toggle="tab" href="#profile">Profile</a></li>
		            <li class="dropdown">
		              <a data-toggle="dropdown" class="dropdown-toggle" href="#">Dropdown <b class="caret"></b></a>
		              <ul class="dropdown-menu">
		                <li class=""><a data-toggle="tab" href="#dropdown1">@fat</a></li>
		                <li class=""><a data-toggle="tab" href="#dropdown2">@mdo</a></li>
		              </ul>
		            </li>
		        </ul>
		        
		        <div class="tab-content" id="myTabContent">
		            <div id="home" class="tab-pane fade active in">
		              <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui.</p>
		            </div>
		            <div id="profile" class="tab-pane fade">
		              <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit. Keytar helvetica VHS salvia yr, vero magna velit sapiente labore stumptown. Vegan fanny pack odio cillum wes anderson 8-bit, sustainable jean shorts beard ut DIY ethical culpa terry richardson biodiesel. Art party scenester stumptown, tumblr butcher vero sint qui sapiente accusamus tattooed echo park.</p>
		            </div>
		            <div id="dropdown1" class="tab-pane fade">
		              <p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork. Williamsburg banh mi whatever gluten-free, carles pitchfork biodiesel fixie etsy retro mlkshk vice blog. Scenester cred you probably haven't heard of them, vinyl craft beer blog stumptown. Pitchfork sustainable tofu synth chambray yr.</p>
		            </div>
		            <div id="dropdown2" class="tab-pane fade">
		              <p>Trust fund seitan letterpress, keytar raw denim keffiyeh etsy art party before they sold out master cleanse gluten-free squid scenester freegan cosby sweater. Fanny pack portland seitan DIY, art party locavore wolf cliche high life echo park Austin. Cred vinyl keffiyeh DIY salvia PBR, banh mi before they sold out farm-to-table VHS viral locavore cosby sweater. Lomo wolf viral, mustache readymade thundercats keffiyeh craft beer marfa ethical. Wolf salvia freegan, sartorial keffiyeh echo park vegan.</p>
		            </div>
		        </div>
				
</div>