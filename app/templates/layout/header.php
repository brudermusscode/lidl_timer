<?php if (!isset($page)) exit(NULL); ?>

<main-header>
  <mh-inr>
    <div class="disfl fldirrow flBetween">
      <div class="disfl fldirrow">
        <a href="<?php echo GITHUB; ?>" target="_blank">
          <div class="menu-dot">
            <p><i class="ri-github-line menu"></i></p>
          </div>
        </a>
      </div>

      <div class="disfl fldirrow gap-smol">
        <?php if(LOGGED) { ?>

        <a href="/vote">
          <div class="menu-dot" <?php if ($page == "votes/index") echo 'active="true"'; ?>>
            <p><i class="ri-chat-poll-line menu"></i></p>
          </div>
        </a>
        <?php } else { ?>
        <a href="/u/login">
          <div class="menu-dot" <?php if ($page == "users/login") echo 'active="true"'; ?>>
            <p><i class="ri-login-circle-line menu"></i></p>
          </div>
        </a>
        <?php } ?>
      </div>
    </div>

    <?php if ($page !== "home/index") { ?>
    <div class="timer-dot">
      <a href="/">
        <div class="menu-dot">
          <p><i class="ri-timer-line menu"></i></p>
        </div>
      </a>
    </div>
    <?php } ?>
  </mh-inr>
</main-header>