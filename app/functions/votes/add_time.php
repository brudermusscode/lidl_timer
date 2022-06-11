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

# check if user voted already for today
$q =
  "SELECT uv.id
  FROM user_votes uv
  JOIN votes v ON v.id = uv.vote_id
  WHERE uv.user_id = ?
  AND v.date = ?
  LIMIT 1";
$p = [$my->id, $today_date];
$get_user_vote = $M->select($q, $p, true);

if(!$get_user_vote->status) exit(json_encode($return));
if($get_user_vote->stmt->rowCount() > 0) {
  $return->message = "You have voted already today. Come back tomorrow!";
  exit(json_encode($return));
}

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
(string) $vote_time = $hour . ':' . $minute . ':00';

# check if vote time exists
$q = "SELECT id FROM votes WHERE date = ? AND time = ? LIMIT 1";
$p = [$today_date, $vote_time];
$get_vote = $M->select($q, $p, false);

if(!$get_vote->status) exit(json_encode($return));

# start this motherfucking transactiokn bro why u forget
$pdo->beginTransaction();

# if time exists, increase vote count by 1, otherwise add new one
if($get_vote->stmt->rowCount() > 0) {

  # update it
  $q = "UPDATE votes SET count = count + 1 WHERE date = ? AND time = ?";
  $p = [$today_date, $vote_time];
  $update_vote = $M->update($q, $p, false);

  if(!$update_vote->status) {
    $return->message = 'We could not process your vote, please try again';
    exit(json_encode($return));
  }

  $vote_id = (int) $get_vote->fetch->id;
} else {

  # insert it
  $q = "INSERT INTO votes (user_id, time, date) VALUES (?, ?, CURRENT_DATE())";
  $p = [$my->id, $vote_time];
  $insert_vote = $M->insert($q, $p, false);

  if(!$insert_vote->status) {
    $return->message = 'We could not process your vote, please try again';
    exit(json_encode($return));
  }

  $vote_id = (int) $insert_vote->connection->lastInsertId();
}

# insert new user_vote
$q = "INSERT INTO user_votes (user_id, vote_id) VALUES (?, ?)";
$p = [$my->id, $vote_id];
$insert_user_vote = $M->insert($q, $p, true);

if(!$insert_user_vote->status) {
  $return->message = 'We could not process your vote, please try again';
  exit(json_encode($return));
}

# prepare return object
$return->status = true;
$return->message = "Your vote has been saved!";

# close database connection
$pdo = NULL;

# exit from script and return success
exit(json_encode($return));