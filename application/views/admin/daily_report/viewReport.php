<?php $this->load->view('admin/partials/admin_header.php'); ?>
<?php  $id = $report['id_report']; ?>
	<!-- page content -->
	<div class="right_col" role="main">
        <div class="page-title">
            <div class="title_left">
                <h3><?php echo $report['title'] ?></h3>
                <h4>Par :  <?php echo $report['first_name'].' '.$report['last_name']?>, le <?php echo $report['createdAt_report'] ?> </h4>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="row">
        	<div class="col-md-8 col-md-offset-2">
        		<?php echo $report['message'] ?>
        	</div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <?php
        if (($this->session->userdata('id') == $report['user_id']) && $report['sent'] == 0) {
        ?>
        <a href="<?php echo base_url("/admin/reports/send/$id"); ?>" class="btn btn-primary">Envoyer</a>
        <?php
        }
        ?>
        <a href="<?php echo base_url('/admin/reports'); ?>" class="btn btn-default">Retour</a>
	</div>

	<!-- /page content -->
<?php $this->load->view('admin/partials/admin_footer'); ?>