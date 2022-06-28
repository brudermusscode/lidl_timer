<?php

if (!$page) header(NOT_FOUND);

# set current body related to page
$body = 'main';

# set timer to false, and enable it, as soon as the timer page
# is entered
$timer = false;

# TODO: Feature | Timer | Different timer designs (K+K, Lidl, ...)
if (preg_match('/^home/', $page)) $timer = 'lidl';
if (preg_match('/^votes/', $page)) $body = 'votes';
if (preg_match('/^users/', $page)) $body = 'users';
if (preg_match('/^users\/login/', $page)) $body = 'users-login';
if (preg_match('/^errors/', $page)) $body = 'not-found';

?>

<!DOCTYPE HTML>
<html lang=en>

<head>
  <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />

  <title>Lidl-Timer</title>
  <link rel="shortcut icon" href="<?php echo $main->favicon; ?>" type="image/x-icon">

  <!-- styles -->
  <link rel="stylesheet" href="<?php echo STYLE . '/application.min.css'; ?>" />

  <!--- hacks --->
  <script src="<?php echo SCRIPT . "/jquery.min.js"; ?>"></script>
  <script src="<?php echo SCRIPT . "/Overlay.min.js"; ?>"></script>
  <script src="<?php echo SCRIPT . "/Responder.min.js"; ?>"></script>
  <script src="<?php echo SCRIPT . "/Countdown.min.js"; ?>"></script>
  <script src="<?php echo SCRIPT . "/application.min.js"; ?>"></script>
  <script src="<?php echo SCRIPT . "/users.min.js"; ?>"></script>
  <script src="<?php echo SCRIPT . "/votes.min.js"; ?>"></script>
  <script src="<?php echo SCRIPT . "/countdown.min.js"; ?>"></script>
</head>

<body class='<?php echo "$body"; ?>' <?php if ($timer) echo "timer=$timer"; ?>
  <?php if ($countdown->running) echo "countdown-running"; ?>>

  <app>

    <?php if (!$due_reached) { ?>
    <audio id="audio_mlg_horn" src='<?php echo SOUND . '/mlg_horn.mp3'; ?>'></audio>
    <?php } ?>