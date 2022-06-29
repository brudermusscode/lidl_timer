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

# check if voting is open
if(!$voting_open) {
  $return->message = "Voting is closed. Come back tomorrow!";
  exit(json_encode($return));
}

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

# convert time values into string
$hour = (string) $hour;
$minute = (string) $minute;

# set valid time string
(string) $vote_time = $hour . ':' . $minute . ':00';

# check if vote time exists
$q = "SELECT id, count FROM votes WHERE date = ? AND time = ? LIMIT 1";
$p = [$today_date, $vote_time];
$get_vote = $M->select($q, $p, false);

if(!$get_vote->status) exit(json_encode($return));

# start this motherfucking transactiokn bro why u forget
$pdo->beginTransaction();

# checker if time existed or was added
$new_vote = false;

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

  # save vote id for later output
  $vote_id = (int) $get_vote->fetch->id;
  $vote_count = (int) $get_vote->fetch->count + 1;
} else {

  # insert it
  $q = "INSERT INTO votes (user_id, time, date) VALUES (?, ?, CURRENT_DATE())";
  $p = [$my->id, $vote_time];
  $insert_vote = $M->insert($q, $p, false);

  if(!$insert_vote->status) {
    $return->message = 'We could not process your vote, please try again';
    exit(json_encode($return));
  }

  # set new vote to true
  $new_vote = true;

  # save vote id for later output
  $vote_id = (int) $insert_vote->connection->lastInsertId();
  $vote_count = (int) 1;
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
$return->data = [
  "new_vote" => $new_vote,
  "hour" => $hour,
  "minute" => $minute,
  "vote_id" => $vote_id,
  "vote_count" => $vote_count
];

# close database connection
$pdo = NULL;

# exit from script and return success
exit(json_encode($return));