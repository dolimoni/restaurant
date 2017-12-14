<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style>
	.ui-autocomplete-loading {
		background: white url("images/ui-anim_basic_16x16.gif") right center no-repeat;
	}
	.emailText {
		border: 1px solid #C1C1C1;
		border-radius: 5px;
		padding: 5px;
		margin: 5px;
		background-color: #D1D1D1;
    	display: inline-block;
	}
	.cancelBtn {
		font-size: 8px;
        cursor: pointer;
	}
</style>
<?php $this->load->view('admin/partials/admin_header.php'); ?>
	<!-- page content -->
	<div class="right_col" role="main">
		<?php echo validation_errors(); ?>

		<?php echo form_open_multipart('admin/reports/create'); ?>
			<input type="hidden" id="emails_to" name="emails" value="" />
            <div class="page-title">
                <div class="title_left">
                    <h3>Ajouter un Rapport</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <hr>
			<div class="row">
				<div class="form-group col-md-12">
					<label>Titre</label>
					<input type="text" class="form-control" name="title" placeholder="Ajouter titre" />
				</div>
				<div class="form-group col-md-11">
					<label>Envoyer à </label>
					<input id="email_to" type="email" class="form-control" name="email" placeholder="Ajouter l'adresse e-mail" />
				</div>
				<div class="form-group col-md-1">
					<a id="add_email" href="#" class="btn btn-primary">Ajouter</a>
				</div>
				<div class="form-group col-md-12" id="display_emails"></div>
				<div class="form-group col-md-12">
					<label>Message</label>
					<textarea id="editor1" class="form-control" name="message" placeholder="Ajouter Rapport" /></textarea>
				</div>
				<div class="form-group col-md-12">
					<button type="submit" class="btn btn-primary">Créer</button>
					<a href="<?php echo base_url('/admin/reports'); ?>" class="btn btn-primary">Annuler</a>
				</div>
			</div>
		</form>
	</div>

	<!-- /page content -->
	<script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script type="text/javascript">
		CKEDITOR.replace( 'editor1' );
        function addBulle( email ) {
            $("#display_emails").append('<span data-email="'+email+'" class="emailText">'+email+' <a class="cancelBtn">&#x2716;</a></span>');
        }
        function addEmail( email ) {
            $('#emails_to').val($('#emails_to').val()+email+';');
            addBulle(email);
            setTimeout(function(){ $('#email_to').val(''); }, 200);
        }
        function isEmail(email) {
			var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			return regex.test(email);
		}

		$( "#email_to" ).autocomplete({
			source: function( request, response ) {
				$.ajax({
					url: './getReportByName',
                	type: "POST",
					dataType: "json",
					data: {
						"q": request.term
					},
					success: function( data ) {
						console.log(data);
						response( data );
					}
				});
			},
			minLength: 3,
			select: function( event, ui ) {
				/*log( ui.item ?
				"Selected: " + ui.item.label :
				"Nothing selected, input was " + this.value);*/
				console.log(ui.item.label);addEmail( ui.item.label );
			},
			open: function() {
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			},
			close: function() {
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			}
		});
			// Add event listener for opening and closing details
		$('#display_emails').on('click', '.cancelBtn', function () {
			var email = $(this).closest('span').data('email');
			$(this).closest('span').remove();
			var emails = $('#emails_to').val();
			emails = emails.replace(email+";",'');
			$('#emails_to').val(emails);
		});
			// Add event listener for opening and closing details
		$('BODY').on('click', '#add_email', function (e) {
			// alert("juste clicked me");
			e.preventDefault();
			console.log($("#email_to").val());
			if(isEmail($("#email_to").val())){
				addEmail($("#email_to").val());
			}else{
				alert("Ajouter une adresse e-mail valide");
			}
		});
	</script>
<?php $this->load->view('admin/partials/admin_footer'); ?>