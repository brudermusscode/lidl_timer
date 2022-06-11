<?php

# require database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/init.php';

# if (LOGGED) header('location: /');

# init page
$page = 'users/login';

include_once TEMPLATE . '/layout/head.php';
include_once TEMPLATE . '/layout/header.php'; ?>

<login-header style="background:url(/app/assets/images/5674509.jpg) center no-repeat;background-size:cover;">
</login-header>

<div data-structure="header,after,spacing"></div>

<main class="single centered posrel" style="margin-bottom:4em;z-index:2;">
  <?php include_once TEMPLATE . "/users/session/_login_container.php"; ?>
  <p class="tac mt32"><?php echo date('Y'); ?> &copy; Deltacity</p>
</main>

<?php include_once TEMPLATE . '/layout/footer.php'; ?>