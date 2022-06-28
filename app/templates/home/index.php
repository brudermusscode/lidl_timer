<?php

# require database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/init.php';

# set current page
$page = 'home/index';

include_once TEMPLATE . "/layout/head.php";
include_once TEMPLATE . "/layout/header.php";
include_once TEMPLATE . "/layout/footer.php";

?>