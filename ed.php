<?php
session_start();

require "function.php";



$id = $_POST['id'];
$name = $_POST['name'];
$work = $_POST['work'];
$phone = $_POST['phone'];
$address = $_POST['address'];

// $user = check_user_by_email($email);
edit($id, $name, $work, $phone, $address);


set_flash_message("success", "Отредактированно успешно!");

redirect_to("users.php");


/* ============================= */


