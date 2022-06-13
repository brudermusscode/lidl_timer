<?php

# require database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/init.php';

# init page
$page = "errors/404";

# include page elements
include_once TEMPLATE . '/layout/head.php';
include_once TEMPLATE . '/layout/header.php';

?>

<div class="container">
  <div class="girl-down"
    style="background:url(<?php echo IMAGE . '/not-found.jpg'; ?>) center no-repeat;background-size:cover;">
  </div>

  <div class="error-text">
    <div class="headline">
      <div>H</div>
      <div class="eyes">
        <div class="the"></div>u
      </div>
      <div class="eyes">
        <div class="the"></div>u
      </div>
      <div>h?</div>
    </div>
    <p class="description">Nothing here</p>

    <button-model onclick="history.back();" size="std" style="background:#F28786;" dark rounded="wide" hover-shadowed
      class="mt32">
      <span style="color:white;">GET BACK</span>
    </button-model>
  </div>

  <div class="bubble-container">
    <div class="bubble bubble-1"></div>
    <div class="bubble bubble-2"></div>
    <div class="bubble bubble-3"></div>
    <div class="bubble bubble-4"></div>
    <div class="bubble bubble-5"></div>
  </div>
</div>

<?php include_once TEMPLATE . '/layout/footer.php'; ?>