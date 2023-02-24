<?php
include "../../../../../model/model.php";
$hotel_id = $_GET['hotel_id'];

$row_query = mysqli_fetch_assoc(mysqlQuery("select hotel_name,city_id,mobile_no,email_id from hotel_master where hotel_id='$hotel_id'"));
$sq_city = mysqli_fetch_assoc(mysqlQuery("select city_name from city_master where city_id='$row_query[city_name]'"));
$mobile_no = $encrypt_decrypt->fnDecrypt($row_query['mobile_no'], $secret_key);
$email_id = $encrypt_decrypt->fnDecrypt($row_query['email_id'], $secret_key);
echo $mobile_no.'//'.$email_id;
?>