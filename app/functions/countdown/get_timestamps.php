<?php
# just return the due date for newest voting

# require database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/init.php';

# prepare success return object
$return->message = "Due is " . $due;
$return->status = true;
$return->current_timestamp = $current_timestamp;
$return->opens_at_timestamp = $opens_at_timestamp;
$return->closes_at_timestamp = $closes_at_timestamp;
$return->due_timestamp = $due;

# exit outputting $return with $due
exit(json_encode($return));