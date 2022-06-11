<?php

# require database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/init.php';

$q = (string) "SELECT script_name FROM cron_jobs WHERE next_run <= CURRENT_TIMESTAMP";
$p = (array) [];
$get_cron_jobs = $M->select($q, $p, true);

$cron_jobs = (object) $get_cron_jobs->fetch;

exit(json_encode($cron_jobs));