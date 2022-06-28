<?php

# require database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/init.php';

# set current page
$page = 'home/main';

if ($due_reached)
  include_once TEMPLATE . "/home/_voting.php";
else
  include_once TEMPLATE . "/home/countdown/_countdown.php";