
<?php foreach ($rooms as $room) {
$status='ready';
if($room['status']==='2'){
    $status='notReady';
}else if($room['status']==='0'){
    $status='occupied';
}else if($room['status'] === '3'){
    $status = 'anomaly';
}
?>

<tr class="<?php echo $status?>">
    <td>
        <?php echo $room['id'];?>
    </td>
    <td>
        <?php echo $room['nbr_lits']; ?>
    </td>
    <td>
        2
    </td>
    <td>
        250
    </td>
    <td>
        250
    </td>
    <td>
        0
    </td>
    <td>
        0
    </td>
    <td>

    </td>
    <td>
        <button class="btn btn-success btn-xs action"
                onclick="window.location.href='<?php echo base_url('index.php/room/view/'. $room['id'] ); ?>'"><span
                class="fa fa-eye"></span></button>
    </td>
</tr>
<?php } ?>