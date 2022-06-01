<?php

  $get_content = file_get_contents("time.json");
  $json = json_decode($get_content, true);
  $time = $json['time'];

  $time = preg_replace('/:/', '<span blink>:</span>', $time);

  $current_time = time();



?>

<!DOCTYPE HTML>
<html>
  <head>
    <title>Lidl-Timer</title>
    <link rel="stylesheet" href="assets/stylesheets/compiled/styles.min.css" />
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
  </head>
  <body>

    <s>
      <div class="lidl-text">
        <p>L<span class="the-i">i</span>&nbsp;DL</p>
      </div>
      <div class="mover-1"></div>
      <div class="time">
        <p><?php echo $time; ?></p>
      </div>

      <div id="countdown">
        Countdown coming soon
      </div>
    </s>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
      // implement countdown
  </script>
  </body>
</html>
