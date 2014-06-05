<?php
/**
 * @var $data Product
 */
?>
<li>
    <?php echo $data->id?>
    <br>
    <?php echo $data->productLocalization->name;?>
    <br>
    <?php echo $data->productLocalization->short_description;?>
    <br>
</li>