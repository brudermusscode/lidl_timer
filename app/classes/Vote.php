<?php
# this file defines and initializes the Vote class which holds
# neccessary functions for the voting system

// initialize Vote class
$Vote = new Vote($pdo, $_SESSION, $_COOKIE);

// define Vote class
class Vote extends Main
{

  public function get_settings() {
    # get vote settings
    $q = "SELECT * FROM vote_settings ORDER BY id LIMIT 1";
    $p = [];
    $get_vote_settings = $this->select($q, $p, false);

    if(!$get_vote_settings->status) return NULL;

    return $get_vote_settings->fetch;
  }

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

  public function is_weekend() {
    if (in_array(date('l'), ['Saturday', 'Sunday'])) return true;

    return false;
  }

  public function voted() {
    # put some logic
  }

  public function voting_starts() {
    return $this->get_settings()->last_vote_date == date('Y-m-d') ? 'tomorrow' : 'today';
  }
}