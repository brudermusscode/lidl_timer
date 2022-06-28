<?php
# this file defines and initializes the Vote class which holds
# neccessary functions for the voting system

// initialize Vote class
$Vote = new Vote($pdo, $_SESSION, $_COOKIE);

// define Vote class
class Vote extends Main
{

  # get voting settings
  public function get_settings() {
    # get vote settings
    $q = "SELECT * FROM vote_settings ORDER BY id LIMIT 1";
    $p = [];
    $get_vote_settings = $this->select($q, $p, false);

    if(!$get_vote_settings->status) return NULL;

    return $get_vote_settings->fetch;
  }

  # check, if voting pool is open
  public function is_open() {
    $current_timestamp = (string) date('Y-m-d H:i:s');
    $closing_timestamp = (string) date('Y-m-d ' . $this->get_settings()->closes_at);
    $opening_timestamp = (string) date('Y-m-d ' . $this->get_settings()->opens_at);

    # if its weekend, keep voting closed
    if (in_array(date('l'), ['Saturday', 'Sunday'])) return false;

    # if current time is bigger than closing timestamp from database,
    # keep votings closed as well as if its smaller than opening timestamp
    if (
      $this->is_weekend()
      || $current_timestamp >= $closing_timestamp
      || $current_timestamp < $opening_timestamp
      ) return false;

    # otherwise open votings
    return true;
  }

  # fetch votes for current date
  public function get_countdown_time() {
    # get vote settings
    $q =
      "SELECT v.*
      FROM votes v
      WHERE v.date = CURRENT_DATE
      AND v.count = (
        SELECT max(v_sub.count)
        FROM votes v_sub
        WHERE v_sub.date = CURRENT_DATE
      )
      LIMIT 1";
    $p = [];
    $get_vote = $this->select($q, $p, false);

    if(!$get_vote->status) return NULL;

    return $get_vote->fetch;
  }

  # check, if it is weelend
  public function is_weekend() {
    if (in_array(date('l'), ['Saturday', 'Sunday'])) return true;

    return false;
  }

  # check, if logged in user has voted already today
  public function voted() {
    $q =
      "SELECT uv.id, v.id vote_id, v.time time
      FROM user_votes uv
      JOIN votes v ON v.id = uv.vote_id
      WHERE uv.user_id = ?
      AND v.date = ?
      LIMIT 1";
    $p = [$_SESSION['id'], date('Y-m-d')];
    $get_user_vote = $this->select($q, $p, false);

    if(!$get_user_vote->status) return false;
    if($get_user_vote->stmt->rowCount() > 0) return true;

    return false;
  }

  # get text for next voting (today or tomorrow)
  public function voting_starts() {
    return $this->get_settings()->last_vote_date == date('Y-m-d') ? 'tomorrow' : 'today';
  }
}