<?php

# require database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/init.php';

if (empty($_POST['element_include'])) exit(NULL);

?>

<countdown active="false">
  <div data-structure="countdown,pyro" class="pyro">
    <div class="before"></div>
    <div class="after"></div>
  </div>

  <s>
    <pulse color="orange"></pulse>
    <div class="s__inr">
      <div class="headline-text">
        <logo>
          <p>Next Break</p>
        </logo>
      </div>

      <div id="countdown" class="time">
        <div id="countdown_hours" class="time-container"></div>
        <p><span class=blink>:</span></p>
        <div id="countdown_minutes" class="time-container"></div>
        <p><span class=blink>:</span></p>
        <div id="countdown_seconds" class="time-container"></div>
      </div>
    </div>
  </s>
</countdown>