<?php
# this adds new times to vote pool which users can select from or
# add new ones

# require database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/init.php';

if(empty($_POST['hour']) || empty($_POST['minute']) || !LOGGED) exit(json_encode($return));
if(!is_numeric($_POST['hour']) || !is_numeric($_POST['minute'])) exit(json_encode($return));

# transform post values to integer
$hour = (int) $_POST['hour'];
$minute = (int) $_POST['minute'];
$today_date = date('Y-m-d');

# set valid hour values
if ($hour < 12 || $hour > 15) {
  $return->message = "Hour should be between <strong>12 - 15</strong> o'clock!";
  exit(json_encode($return));
}

# set valid minute values
if ($minute < 0 || $minute > 59) {
  $return->message = "Your <strong>minute</strong> value is invalid my friend";
  exit(json_encode($return));
}

# refactor hour and minute value from < 10 with 0 infront
if ($minute < 10) $minute = '0' . $minute;
if ($hour < 10) $hour = '0' . $hour;

# set valid time string
(string) $vote_time = $hour . ':' . $minute;

# start this motherfucking transactiokn bro why u forget
$pdo->beginTransaction();

# check if user voted already for today
$q = "SELECT id FROM votes WHERE date = ? AND user_id = ? LIMIT 1";
$p = [$today_date, $my->id];
$get_vote = $M->select($q, $p, true);

if(!$get_vote->status) exit(json_encode($return));
if($get_vote->stmt->rowCount() > 0) {
  $return->message = "You have voted already today. Come back tomorrow!";
  exit(json_encode($return));
}

# insert time to votes
$q = "INSERT INTO votes (user_id, time, date) VALUES (?, ?, CURRENT_DATE())";
$p = [$my->id, $vote_time];
$insert_votes = $M->insert($q, $p, true);

if(!$insert_votes->status) {
  $return->message = 'We could not process your vote, please try again';
  exit(json_encode($return));
}

$return->status = true;
$return->message = "Your vote has been saved!";

exit(json_encode($return));