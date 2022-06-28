<?php

# require database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/init.php';

if (empty($_POST['element_include'])) exit(NULL);

?>

<!-- PYRO MAN -->
<div data-structure="countdown,pyro" class="pyro">
  <div class="before"></div>
  <div class="after"></div>
</div>

<!-- the countdown -->
<s>
  <div class="headline-text">
    <logo>
      <p>
        L
        <span class=the-i>i</span>
        <span class=logo-spacer>DL</span>
      </p>
    </logo>
  </div>

  <div class="mover-1"></div>

  <div id="countdown" class="time">
    <div id="countdown_hours" class="time-container"></div>
    <p><span class=blink>:</span></p>
    <div id="countdown_minutes" class="time-container"></div>
    <p><span class=blink>:</span></p>
    <div id="countdown_seconds" class="time-container"></div>
  </div>
</s>