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

?>

<!DOCTYPE HTML>
<html lang=en>

<head>
  <title>Lidl-Timer</title>
  <link rel="shortcut icon" href="<?php echo $main->favicon; ?>" type="image/x-icon">

  <!-- styles -->
  <link rel="stylesheet" href="<?php echo STYLE . '/styles.min.css'; ?>" />

  <!--- hacks --->
  <script src="<?php echo SCRIPT . "/jquery.min.js"; ?>"></script>
  <script src="<?php echo SCRIPT . "/classes/Overlay.min.js"; ?>"></script>
  <script src="<?php echo SCRIPT . "/classes/Responder.min.js"; ?>"></script>
  <script src="<?php echo SCRIPT . "/application.min.js"; ?>"></script>
  <script src="<?php echo SCRIPT . "/users/functions.min.js"; ?>"></script>
  <script src="<?php echo SCRIPT . "/votes/functions.min.js"; ?>"></script>
</head>

<body class='<?php echo "$body"; ?>' timer="<?php echo $timer ? $timer : 'false'; ?>">
  <audio id="audio_mlg_horn" src='<?php echo SOUND . '/mlg_horn.mp3'; ?>'></audio>