<?php

# require database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/init.php';

if(DEV) header(NOT_FOUND);

# init page
$page = 'jobs/index';

include_once TEMPLATE . '/layout/head.php';

?>

<div style="position:fixed;top:50%;left:50%;transform:translate(-50%, -50%);
background:white;border-radius:24px;" class="mshd">
  <div style="padding:3.2em 3.8em;" class="tac">
    <p class="mb8 mt12"><i class="ri-play-circle-line mid"></i></p>
    <p>Jobs are running</p>
    <p class="mt24"><strong>Time setting</strong></p>
    <p>
      <?php

        $stmt = $pdo->prepare('SELECT CURRENT_TIMESTAMP, @@global.time_zone global_timezone');
        $stmt->execute();
        $stmt = $stmt->fetch();

        echo $stmt->CURRENT_TIMESTAMP;

      ?>
    </p>
    <p>
      <?php echo $stmt->global_timezone; ?>
    </p>
  </div>
</div>

<script>
jQuery(function() {

  // every 4 seconds check for new cron jobs to be run
  setInterval(() => {

    $.ajax({
      method: 'POST',
      url: '/job/check_jobs',
      dataType: 'JSON',
      success: (data) => {

        console.log(data);

        $.each(data, function(index, element) {
          $.ajax({
            url: '/job/' + element.script_name,
            dataType: 'JSON',
            success: (data) => {
              console.log(data);
            },
            error: (data) => {
              console.error(data);
            }
          });
        });

      },
      error: (data) => {
        console.error(data);
      }
    });

  }, 4000);

});
</script>

<?php include_once TEMPLATE . '/layout/footer.php'; ?>