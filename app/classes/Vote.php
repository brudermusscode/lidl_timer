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

    # if its weekend, keep voting closed
    if (in_array(date('l'), ['Saturday', 'Sunday'])) return false;

    # if current time is bigger than closing timestamp from database,
    # keep votings closed
    if ($current_timestamp >= $closing_timestamp) return false;

    # otherwise open votings
    return true;
  }
}
