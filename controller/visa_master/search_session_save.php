<?php
include_once('../../model/model.php');
include_once('../../model/visa_master/b2c_operations.php');

$b2c_operations = new b2c_operations;
$b2c_operations->search_session_save();
?>