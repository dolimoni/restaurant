<?php $this->load->view('admin/partials/admin_header.php'); ?>
<style>
    .validate{
        background: #26b99a !important;
        color: white;
    }
    .mealModel div{
        text-transform: uppercase;
    }
</style>
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Synchronisation manuelle</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <hr>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Ajouter les produits vendu aujoud'hui</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>


                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Article</th>
                                    <th>Quantité totale</th>
                                    <th>Prix total</th>
                                </tr>
                            </thead>
                            <tbody id="productBody">
                                <tr class="mealModel" hidden>
                                    <td hidden>
                                        <div data-type="id"></div>
                                    </td>
                                    <td>
                                        <div data-type="code"></div>
                                    </td>
                                    <td>
                                        <div data-type="meal" contenteditable></div>
                                    </td>
                                    <td>
                                        <div data-type="quantity" contenteditable></div>
                                    </td>
                                    <td>
                                        <div data-type="amount" contenteditable></div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div>
                            <button type="button" class="btn btn-success newMeal" name="newMeal">+</button>
                        </div>
                        <div class="text-right">
                            <button type="button" class="btn btn-success " name="validate">
                                Valider
                            </button>
                        </div>
                    </div><!-- /x-panel -->
                </div> <!-- /col -->
            </div> <!-- /row -->
        </div>
    </div> <!-- /.col-right -->
    <!-- /page content -->

<?php $this->load->view('admin/partials/admin_footer'); ?>
<script src="<?php echo base_url('assets/vendors/moment/min/moment.min.js'); ?>"></script>
<script>

    $(document).ready(function () {
        $(".newMeal").on("click", addNewMealEvent);
        function addNewMealEvent(){
            var mealModel=$(".mealModel").clone().removeAttr("hidden");
            mealModel.removeClass("mealModel");
            $("#productBody").append(mealModel);
            $(mealModel.find("div[data-type=meal]")).focus();

        }

        $(document).on("blur","div[data-type=meal]",searchMealEvent);
        function searchMealEvent() {
            var tr= $(this).closest("tr");
            var mealName=$(this).html();
            var myData={
                "mealName": mealName
            };
            $.ajax({
                url: "<?php echo base_url('admin/main/searchMeal'); ?>",
                type: "POST",
                dataType: "json",
                data: myData,
                success: function (data) {
                    if(data.status==="success"){
                        if(data.meal.length){
                            tr.addClass("validate");
                            tr.find("div[data-type=code]").html(data.meal[0].externalCode);
                            tr.find("div[data-type=id]").html(data.meal[0].id);
                        }
                    }
                },
                error: function (data) {
                    swal({
                        title: "Erreur",
                        text: "Une erreur s'est produite",
                        type: "warning",
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            })
        }

    });

</script>




<script>
    $(document).ready(function () {
        $('button[name="validate"]').on('click', function () {
            var report_date = moment().format('YYYY-MM-DD') + "T10";
            var mealsList = [];
            $('tr.validate').each(function (i, obj) {
                var tr = $(this);
                var id = tr.find('td div[data-type="id"]').text();
                var externalCode = tr.find('td div[data-type="externalCode"]').text();
                var quantity = parseFloat(tr.find('td div[data-type="quantity"]').text());
                var amount = parseFloat(tr.find('td div[data-type="amount"]').text());
                var name = tr.find('td div[data-type="name"]').text();
                if(isNaN(quantity)){
                    quantity=0;
                }
                if(isNaN(amount)){
                    amount=0;
                }
                var meal = {
                    'id': id,
                    'externalCode': externalCode,
                    'quantity': quantity,
                    'amount': amount,
                    'name': name,
                    'date': report_date.split('T')
                };

                if (id > 0 && amount>0 && quantity>0) {
                    mealsList.push(meal);
                }
            });

            var myData = {'mealsList': mealsList};
            console.log(myData);
            $('#loading').show();
            if(mealsList.length){
                $.ajax({
                    url: "<?php echo base_url(); ?>admin/meal/apiConsumption",
                    type: "POST",
                    dataType: "json",
                    data: myData,
                    success: function (data) {
                        $('#loading').hide();
                        if (data.status === 'success') {
                            swal({
                                title: "Success",
                                text: "L'opératon a été effectuée avec success",
                                type: "success",
                                timer: 1500,
                                showConfirmButton: false
                            });
                        }
                        else {
                            var content = '';
                            $.each(data.productsList, function (key, product) {
                                content += product['name'] + ",";
                            });
                            swal({
                                title: "La quantité de certain produits est insuffisante",
                                type: "error",
                                showCloseButton: true,
                                html: true
                            });
                        }
                    },
                    error: function (data) {
                        $('#loading').hide();
                        swal({
                            title: "Erreur",
                            text: "Une erreur s\'est produite",
                            type: "error",
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                });
            }

        })
    });
</script>

