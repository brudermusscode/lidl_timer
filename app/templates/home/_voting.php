<?php

# require database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/init.php';

if (empty($_POST['element_include'])) exit(NULL);

# init date last vote date
$voting_closes_date = $voting->settings->last_vote_date;

# init old voting closes as timestamp
$voting_closes_timestamp = $voting->settings->last_vote_date . ' ' . $voting->settings->closes_at;

# add one to the old voting closes date
$voting_closes_date_modified = new DateTime($voting_closes_date);
$voting_closes_date_modified = $voting_closes_date_modified->modify('+1 day');

# init next voting opens as timestamp
$next_voting_opens_timestamp = $voting_closes_date_modified->format('Y-m-d') . ' ' . $voting->settings->opens_at;

# check if voted already
$voted_shop = false;
$voted_shop_id = 0;
$q =
  "SELECT id, shop_id
  FROM user_vote_shops
  WHERE user_id = ?
  AND (created_at BETWEEN ? AND ?)
  LIMIT 1";
$p = [$my->id, $voting_closes_timestamp, $next_voting_opens_timestamp];
$stmt = $M->select($q, $p, false);

if ($stmt->stmt->rowCount() > 0) {
   $voted_shop = true;
   $voted_shop_id = $stmt->fetch->shop_id;
}

?>

<main centered size="smol" no-header class="pt62">
  <label dark no-indent big centered>
    <div flexer>
      <div class="icon">
        <p><i class="ri-store-2-line"></i></p>
      </div>
      <div class="text">
        <p>Which store for tomorrow?</p>
      </div>
    </div>
  </label>

  <form data-form="votes,shops">
    <div class="shops">
      <?php

      $q = "SELECT * FROM shops ORDER BY name ASC";
      $stmt = $M->select($q, [], true);

      foreach ($stmt->fetch as $shop) {

    ?>

      <box-model class="shop__box" shadowed="std" light="" white="" rounded="wide" class="mb12 "
        data-shop-id="<?php echo $shop->id; ?>" casted="<?php echo $voted_shop_id === $shop->id ? 'true' : 'false'; ?>">
        <bm-inr class="shop__box_inr" size="mid">
          <div class="shop__box_logo">
            <img src="<?php echo IMAGE . '/stores/' . $shop->logo; ?>" />
          </div>
          <div class="shop__box_info">
            <div class="shop__box_info__title">
              <p><?php echo $shop->name; ?></p>
            </div>
            <div class="shop__box_info__slogan">
              <p><?php echo $shop->slogan; ?></p>
            </div>
          </div>
          <div class="checker">
            <p>
              <i class="ri-check-line"></i>
            </p>
          </div>
        </bm-inr>
      </box-model>

      <?php } ?>
    </div>
  </form>
</main>

<script>
jQuery(function() {

  $(document)

    .on('click', 'form[data-form="votes,shops"] box-model', function() {
      let $t = $(this);
      let shop_id = $t.data('shop-id');
      let data = {
        shop_id: shop_id
      };

      $.get("/do/votes/shop", data, (data) => {
        if (Object.entries(data).length > 0) {
          if (data.status) {
            $t.closest('form').find('box-model').attr('casted', false);
            $t.attr('casted', true);
          }

          responder.add($(document).find('app'), data.message);
        }
      }, "JSON");
    });

});
</script>