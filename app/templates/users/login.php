<?php

# require database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/init.php';

if (LOGGED) header('location: /');

# init page
$page = 'users/login';

include_once TEMPLATE . '/layout/head.php';
include_once TEMPLATE . '/layout/header.php'; ?>

<div class="posabs alignmiddle p24" w600c>
  <logo class="tac mb42">
    <p>
      L
      <span class="the-i">i</span>
      <span class="logo-spacer">DL</span>
    </p>
  </logo>

  <?php include_once TEMPLATE . "/users/session/_login_container.php"; ?>
  <p class="tac mt32"><?php echo date('Y'); ?> &copy; Deltacity</p>
</div>

<?php include_once TEMPLATE . '/layout/footer.php'; ?>