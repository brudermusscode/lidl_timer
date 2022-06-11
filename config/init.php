<?php

# define function for checking voting open state
function voting_open_(string $current_time, string $closing_time) {

}

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

# get system settings
# TODO: outsource into class and just call a function
$stmt = $pdo->prepare("SELECT * FROM main_settings, main_urls");
$stmt->execute();
$systemInformation = $stmt->fetch();

# get main settings
$main = (object) [
  "name" => $systemInformation->name,
  "favicon" => $systemInformation->favicon,
  "is_main" => $systemInformation->is_main,
  "show_errors" => $systemInformation->show_errors,
  "today" => (object) [
    "date" => date('Y-m-d'),
    "time" => date('H:i:s'),
    "timestamp" => date('Y-m-d H:i:s')
  ]
];

# include required classes
include_once ROOT . "/app/classes/Main.php";
include_once ROOT . "/app/classes/Sign.php";
include_once ROOT . "/app/classes/Vote.php";

# define things
define("GITHUB", $systemInformation->github);
define("IMAGE", $systemInformation->images);
define("SCRIPT", $systemInformation->scripts);
define("STYLE", $systemInformation->styles);
define("ICON", $systemInformation->icons);
define("FONT", $systemInformation->fonts);
define("SOUND", $systemInformation->sounds);

# get vote settings
$vote_settings = $Vote->get_settings();
$voting_open = $Vote->is_open();
# TODO: remove for $main->today->date
$today_date = $main->today->date;

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

// define
define("LOGGED", $Sign->isAuthed());

// user object
$my = (object) [
  "uid" => 0
];

if (LOGGED) {
  # reset session and get new settings
  $my = $Sign->resetSession();

  # objectifcy $_SESSION and put into $my for shoter use
  $my = (object) $_SESSION;
}