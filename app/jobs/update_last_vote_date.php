<?php

# require database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/init.php';

# start mysql transaction
$pdo->beginTransaction();

# update last vote date
$q = (string) "UPDATE vote_settings SET last_vote_date = CURRENT_DATE";
$p = (array) [];
$update = $M->update($q, $p, true);

# update cron job only in dev env
if (DEVENV && 'a' == 'b') {
  if (!$update->status) {
    $return->message = "Error: update_last_vote_date";
    exit(json_encode($return->message));
  }

  $q = (string) "UPDATE cron_jobs SET last_run = NOW(), next_run = NOW() + INTERVAL 30 SECOND, updated_at = NOW()";
  $p = (array) [];
  $update = $M->update($q, $p, true);

  if (!$update->status) {
    $return->message = "Error: update_last_vote_date";
    exit(json_encode($return));
  }

  $return->status = true;
  $return->message = "Success: update_last_vote_date";

  exit(json_encode($return));
}

if (!$update->status) exit("Cronjob Error: update_last_vote_date.php");

exit('Successfully updated last_vote_date!');