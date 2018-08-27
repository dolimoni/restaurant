<?php $this->load->view('admin/partials/admin_header.php'); ?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
				  <div class="row tile_count"> 
					<div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
						  <span class="count_top"><i class="glyphicon glyphicon-bed"></i> Nombre de famille </span>
						  <div class="count"><?php echo count($vehicles); ?></div>
					</div>
					<div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
						  <span class="count_top"><i class="glyphicon glyphicon-bed"></i> Nombre d'articles </span>
						  <div class="count"><?php echo count($employees); ?></div>
					</div>
					<div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
						  <span class="count_top"><i class="glyphicon glyphicon-bed"></i> Nombre de produits </span>
						  <div class="count"><?php echo count($customers); ?></div>
					</div>
					<div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
					  	<span class="count_top"><i class="glyphicon glyphicon-bed"></i> Total de vente</span>
					  	<div class="count">
					  		<?php $price = 0; ?>
					  		<?php foreach($vehicles as $vehicle) : ?>
					  			<?php $price += $vehicle['selling_price']; ?>
					  		<?php endforeach; ?>
					  		79.219 DH
					  	</div>
					</div>
				  </div>
            </div> <!-- /col --> 
        </div> <!-- /row -->

        <div class="row">
        	<div class="col-md-6 col-xs-12">
              	<div class="x_panel tile fixed_height_320">
                	<div class="x_title">
                  		<h2>Nombre de de familles vendus</h2>
	                  		<ul class="nav navbar-right panel_toolbox">
	                    	<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                  		</ul>
                  		<div class="clearfix"></div>
                	</div>
	                <div class="x_content">
						<?php $subtotal = 0; ?>
						<?php foreach ($manufacturers_group as $manufacturer) : ?>
							<?php $subtotal += $manufacturer['total']; ?>
						<?php endforeach; ?>

		                  	<div class="widget_summary">
			                    <div class="w_left w_25">
			                      <span>Pizza</span>
			                    </div>
			                    <div class="w_center w_55">
			                      	<div class="progress">
			                        	<div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style=width:65%;">
			                        </div>
			                      </div>
			                    </div>
			                    <div class="w_right w_20">
			                      	<span>10</span>
			                    </div>
			                    <div class="clearfix"></div>
		                  	</div>

                        <div class="widget_summary">
			                    <div class="w_left w_25">
			                      <span>Salade</span>
			                    </div>
			                    <div class="w_center w_55">
			                      	<div class="progress">
			                        	<div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 40%;">
			                        </div>
			                      </div>
			                    </div>
			                    <div class="w_right w_20">
			                      	<span>5</span>
			                    </div>
			                    <div class="clearfix"></div>
		                  	</div>

                        <div class="widget_summary">
			                    <div class="w_left w_25">
			                      <span>Boisson</span>
			                    </div>
			                    <div class="w_center w_55">
			                      	<div class="progress">
			                        	<div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
			                        </div>
			                      </div>
			                    </div>
			                    <div class="w_right w_20">
			                      	<span>50</span>
			                    </div>
			                    <div class="clearfix"></div>
		                  	</div>

	                </div> <!-- /content --> 
              	</div> <!-- /panel --> 
            </div> <!-- /col -->

            <div class="col-md-6 col-xs-12">
              	<div class="x_panel tile fixed_height_320">
                	<div class="x_title">
                  		<h2>Nombre d'articles vendus par famille</h2>
	                  		<ul class="nav navbar-right panel_toolbox">
	                    	<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                  		</ul>
                  		<div class="clearfix"></div>
                	</div>
	                <div class="x_content">
						<?php $subtotal = 0; ?>
						<?php foreach ($manufacturers_group_sold as $manufacturer) : ?>
							<?php $subtotal += $manufacturer['total']; ?>
						<?php endforeach; ?>

	                  	<?php foreach ($manufacturers_group_sold as $manufacturer) : ?>
		                  	<div class="widget_summary">
			                    <div class="w_left w_25">
			                      <span><?= $manufacturer['manufacturer_name']; ?></span>
			                    </div>
			                    <div class="w_center w_55">
			                      	<div class="progress">
			                        	<div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo ($manufacturer['total'] / $subtotal) * 100;?>%">
			                        </div>
			                      </div>
			                    </div>
			                    <div class="w_right w_20">
			                      	<span><?= $manufacturer['total']; ?></span>
			                    </div>
			                    <div class="clearfix"></div>
		                  	</div>
	                  	<?php endforeach; ?>

	                </div> <!-- /content --> 
              	</div> <!-- /panel --> 
            </div> <!-- /col --> 
        </div><!-- /row -->

        <div class="row">
        	<div class="col-md-6 col-xs-12">
        	  <div class="x_panel">
        	    <div class="x_title">
        	      	<h2>Graphe <small>Sessions</small></h2>
        	     	<ul class="nav navbar-right panel_toolbox">
        	        	<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
        	        	</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="#">Settings 1</a></li>
								<li><a href="#">Settings 2</a></li>
							</ul>
						</li>
						<li><a class="close-link"><i class="fa fa-close"></i></a></li>
        	      	</ul>
        	      	<div class="clearfix"></div>
        	    </div>
        	    <div class="x_content">
        	      	<canvas id="mybarChart"></canvas>
        	    </div>
        	  </div> <!-- /panel --> 
        	</div>
        </div><!-- /row --> 
    </div>
</div> <!-- /.col-right --> 
<!-- /page content -->

<?php $this->load->view('admin/partials/admin_footer'); ?>

<script>
	// Bar chart
	var ctx = document.getElementById("mybarChart");
	var mybarChart = new Chart(ctx, {
	  type: 'bar',
	  data: {
	    labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
	    datasets: [{
	      label: 'Dépenses DH',
	      backgroundColor: "#26B99A",
	      data: [0, 0, 0, 0, 0, 0, 0, 0, 0,0, 0,  34000500]
	    }, {
	      label: 'Revenus DH',
	      backgroundColor: "#03586A",
	      data: [0, 0, 0, 0, 0, 0, 0, 0, 0,0, 0,  25000200]
	    }]
	  },

	options: {
	    scales: {
	      yAxes: [{
	        ticks: {
	          beginAtZero: true
	        }
	      }]
	    }
	  }
	});

</script>