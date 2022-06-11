<?php

# start new session
session_start();

# set default timezone
date_default_timezone_set('Europe/Berlin');

# auto load composer libs
include $_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php";

# require new database connection
require_once $_SERVER['DOCUMENT_ROOT'] . "/config/db/connect.php";

# set dev_env to true, if current environment is development
(bool) $dev_env = false;
if ($db->getEnvironment() == 'dev') $dev_env = true;

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

// user object
$my = (object) [
  "uid" => 0
];

# include required classes
include_once ROOT . "/app/classes/Main.php";
include_once ROOT . "/app/classes/Sign.php";
include_once ROOT . "/app/classes/Vote.php";

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
define("LOGGED", $Sign->isAuthed());

# get vote settings
$vote_settings = $Vote->get_settings();
$voting_open = $Vote->is_open();
# TODO: remove for $main->today->date
$today_date = $main->today->date;
$weekend = false;

if (in_array(date('l'), ['Saturday', 'Sunday'])) $weekend = true;

if (LOGGED) {
  # reset session and get new settings
  $my = $Sign->resetSession();

  # objectifcy $_SESSION and put into $my for shoter use
  $my = (object) $_SESSION;
}
