<?php

# require database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/init.php';

# set current page
$page = 'Index';

$get_content = file_get_contents(ROOT . "/time.json");
$json = json_decode($get_content, true);
$time = $json['time'];

$time = preg_replace('/:/', '<span blink>:</span>', $time);

$current_time = time();

include_once TEMPLATE . "/layout/head.php";
include_once TEMPLATE . "/layout/header.php";

?>

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

<?php include_once TEMPLATE . "/layout/header.php"; ?>