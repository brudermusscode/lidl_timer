<?php

// = hello man
// START TRANSACTION GOD DAMN
// * remove by time/merge
// ! fix this, this is a bug!
// ? wtf is this shit
// # cool story

# start new session
session_start();

# set default timezone
date_default_timezone_set('Europe/Berlin');

# require definitions
// # should had been using __DIR__  more often before lmao
include __DIR__ . "/definitions.php";

# auto load composer libs
include ROOT . "/vendor/autoload.php";

# require new database connection
include ROOT . "/config/db/connect.php";

# set up constant for considering development environment
(bool) $dev_env = false;
if ($db->getEnvironment() == 'dev') $dev_env = true;
define('DEV', $dev_env);

# create dynamic return for xhr requests to manage
# output responsively
$return = (object) [
  "status" => false,
  "message" => "A wild error appeared, fight it!",
  "init" => [
    "request" => $_REQUEST,
    "session" => $_SESSION
  ]
];

# user object
$my = (object) [
  "id" => 0
];

# include required classes
include ROOT . "/app/classes/Main.php";
include ROOT . "/app/classes/Sign.php";
include ROOT . "/app/classes/Vote.php";

$main = $M->get_main_settings();
$main->today = (object) [
  "date" => date('Y-m-d'),
  "time" => date('H:i:s'),
  "timestamp" => date('Y-m-d H:i:s')
];

# define things
define("GITHUB", $main->github);
define("IMAGE", $main->images);
define("SCRIPT", $main->scripts);
define("STYLE", $main->styles);
define("ICON", $main->icons);
define("FONT", $main->fonts);
define("SOUND", $main->sounds);
define("JOB", $main->jobs);
define("CURRENT_DATE", $main->today->date);
define("CURRENT_TIME", $main->today->time);
define("CURRENT_TIMESTAMP", $main->today->timestamp);
define("LOGGED", $Sign->isAuthed());

# get vote settings
$vote_settings = $Vote->get_settings();
$voting_open = $Vote->is_open();
$weekend = $Vote->is_weekend();
$voting_starts_text = $Vote->voting_starts();

// TODO: remove $today_date for $main->today->date
$today_date = $main->today->date;
$due = false;
$due_reached = false;
$countdown_running = false;

$current_timestamp = $main->today->timestamp;
$closes_at_timestamp = date('Y-m-d ' . $vote_settings->closes_at);
$opens_at_timestamp = date('Y-m-d ' . $vote_settings->opens_at);

if(
  !$weekend
  && !$voting_open
  && $current_timestamp >= $closes_at_timestamp
) {

  # fetch the vote time that won the voting
  $countdown_fetch = $Vote->get_countdown_time();

  # some extra checking here. Check if the countdown fetch returns
  # an object, otherwise there is no vote submitted today
  if (is_object($countdown_fetch)) {

    # countdown is running OMG!
    $countdown_running = true;

    # set the due timestamp from fetched vote time
    $due = date($countdown_fetch->date . ' ' . $countdown_fetch->time);
  }

  # set due reached to true if due is reached
  if ($due && $main->today->timestamp >= $due) {

    # countdown is done, running must be false!
    $countdown_running = false;

    # the due is reached, so tell the variable true (do I need this still?)
    $due_reached = true;
  }
}

if (LOGGED) {
  # reset session and get new settings
  $my = $Sign->resetSession();

  # objectify php session object and add to user object for shoter use
  $my = (object) $_SESSION;

  define('ADMIN', $my->admin);
}