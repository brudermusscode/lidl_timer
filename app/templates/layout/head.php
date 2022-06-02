<?php

if (!$page) header(NOT_FOUND);

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
</head>

<body>