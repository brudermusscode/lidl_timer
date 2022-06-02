<?php

# require database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/init.php';

# set current page
$page = 'Index';

$get_content = file_get_contents(ROOT . "/time.json");
$json = json_decode($get_content, true);
$time = $json['time'];

$time = preg_replace('/:/', '<span class=blink>:</span>', $time);

$current_time = time();

include_once TEMPLATE . "/layout/head.php";
include_once TEMPLATE . "/layout/header.php";

?>

<s>
  <div class="lidl-text">
    <logo>
      <p>
        L
        <span class="the-i">i</span>
        <span class="logo-spacer">DL</span>
      </p>
    </logo>
  </div>
  <div class="mover-1"></div>
  <div class="time">
    <p><?php echo $time; ?></p>
  </div>

  <div id="countdown">
    Countdown coming soon
  </div>
</s>

<?php include_once TEMPLATE . "/layout/header.php"; ?>