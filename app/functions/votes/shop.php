<?php
# this adds new times to vote pool which users can select from or
# add new ones

# require database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/init.php';

if (empty($_GET['shop_id']) || !LOGGED) exit(json_encode($return));

$shop_id = (int) htmlspecialchars($_GET['shop_id']);

// * voting for shops should be open from the "closing" of the countdown
// * till the new "opening" of the new countdown coming up the next day
// * Basically they are always open, except when countdown is running
// *! what about weekends?

// = Votings open?
if ($countdown->running) {
  $return->message = "Shop votings are closed, come back later!";
  exit(json_encode($return));
}

// = Shop exists?
$q = "SELECT * FROM shops WHERE id = ?";
$p = [$shop_id];
$stmt = $M->select($q, $p, false);

if (!$stmt->status || $stmt->stmt->rowCount() < 1) {
  $return->message = 'Error fetching shop!';
  if (!$stmt->status) $return->query = $stmt;
  exit(json_encode($return));
}

# fetch shop information for later output
$shop = $stmt->fetch;

# init date last vote date
$voting_closes_date = $voting->settings->last_vote_date;

# init old voting closes as timestamp
$voting_closes_timestamp = $voting->settings->last_vote_date . ' ' . $voting->settings->closes_at;

# add one to the old voting closes date
$voting_closes_date_modified = new DateTime($voting_closes_date);
$voting_closes_date_modified = $voting_closes_date_modified->modify('+1 day');

# init next voting opens as timestamp
$next_voting_opens_timestamp = $voting_closes_date_modified->format('Y-m-d') . ' ' . $voting->settings->opens_at;

# exit("created_at >= $voting_closes_timestamp AND created_at <= $next_voting_opens_timestamp");

// = Voted already?
$q =
  "SELECT id, shop_id
  FROM user_vote_shops
  WHERE user_id = ?
  AND (created_at BETWEEN ? AND ?)
  LIMIT 1";
$p = [$my->id, $voting_closes_timestamp, $next_voting_opens_timestamp];
$stmt = $M->select($q, $p, false);

if (!$stmt->status) {
  $return->message = 'Error fetching vote!';
  $return->query = $stmt;
  exit(json_encode($return));
}

// = vote!
// START TRANSACTION you bitch
$pdo->beginTransaction();

if ($stmt->stmt->rowCount() > 0) {
  $vote = $stmt->fetch;
  // ? Vote contains same shop_id
  $vote_is_same_shop = false;
  if ($vote->shop_id === $shop_id) $vote_is_same_shop = true;

  # return empty object, if shop is the same
  if ($vote_is_same_shop) {
    $return = (object) [];
    exit(json_encode($return));
  }

  // # update user_shop_votes
  $q = (string)
    "UPDATE user_vote_shops
    SET shop_id = ?
    WHERE id = ?
    AND user_id = ?";
  $p = (array) [$shop_id, $vote->id, $my->id];
  $stmt = $M->update($q, $p, true);

  if (!$stmt->status) {
    $return->message = "Could not update shop vote!";
    $return->query = $stmt;
    exit(json_encode($return));
  }
} else {

  // # insert into user_shop_votes
  $q = (string) "INSERT INTO user_vote_shops (user_id, shop_id, date, time) VALUES (?, ?, CURRENT_DATE, CURRENT_TIME)";
  $p = (array) [$my->id, $shop_id];
  $stmt = $M->insert($q, $p, true);

  if (!$stmt->status) {
    $return->message = "Could not insert shop vote!";
    $return->query = $stmt;
    exit(json_encode($return));
  }
}

// # prepare return object
$return->status = true;
$return->message = 'You voted for ' . $shop->name . '!';

exit(json_encode($return));