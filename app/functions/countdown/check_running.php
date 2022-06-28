<?php
// = checking, if the countdown is running at this very moment

# require database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/init.php';

if ($countdown->running) $return->status = true;

$return->due_reached = false;
if ($due_reached) $return->due_reached = true;

exit(json_encode($return));