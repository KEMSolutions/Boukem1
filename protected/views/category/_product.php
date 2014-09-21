<?php
/**
 * @var $data Product
 */
error_reporting(E_ALL);
ini_set('display_errors', '1');



$this->renderPartial("application.views._product_card", array("product"=>$data, "style"=>"narrow"));


?>