<?php

echo '<pre>';
var_dump($_FILES);
echo '</pre>';


require "function.php";
$id = $_POST['id'];

upload_avatar($id);
exit;
redirect_to("media.php?id=3");



/* ============================= */


