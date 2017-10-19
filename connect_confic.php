<?php

$serverName = "localhost";
$userName = "root";
$userPassword = "";

// for security gate //
$gateUrl = "http://192.168.3.57:3000/";
$gateToken = "token=TraceonToken";

// for self check SCT10001 //
$scUrl = "192.168.3.137";
$scStation = "SCT10001";

$path_selfcheck_img = "http://localhost/admin-module/selfcheck_media/image/";
$path_selfcheck_img_borrow = "borrow/";
$path_selfcheck_img_renew = "renew/";
$path_selfcheck_img_return = "return/";
$path_selfcheck_img_recommended = "http://localhost/admin-module/media_content/recommended_book/";

$path_selfcheck_present = "http://localhost/admin-module/media_content/presentation/";

$path_book_atm_img = "http://localhost/admin-module/book_atm_media/";

$path_api = "http://opac.hong-khai.com/_api/api.php?wsdl";
$path_api_image = "http://www.hong-khai.com/opac/admin/book/";
$path_image = "http://localhost/admin-module/book_atm_media/cover_book/";
?>