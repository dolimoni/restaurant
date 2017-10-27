<?php
//Columns must be a factor of 12 (1,2,3,4,6,12)
$numOfCols = 6;
$rowCount = 0;
$bootstrapColWidth = 12 / $numOfCols;
?>
<div class="row">
    <?php
    foreach ($groups as $group) {
        ?>
        <div class="col-md-<?php echo $bootstrapColWidth; ?>">
            <div class="well" data-id="<?php echo $group['g_id'] ?>">
                <img src="<?php echo base_url(); ?>assets/images/<?php echo $group['image'] ?>" alt=""
                     class="img-responsive">
                <h4 class="brief text-center"><?php echo $group['g_name'] ?></h4>
            </div>
        </div>
        <?php
        $rowCount++;
        if ($rowCount % $numOfCols == 0) echo '</div><div class="row">';
    }
    ?>
</div>
