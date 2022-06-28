<?php
# checking, if the countdown is running at the very moment

# require database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/init.php';

if ($countdown->running) $return->status = true;

exit(json_encode($return));