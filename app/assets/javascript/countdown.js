let loading_inveral;

jQuery(function () {
  let body = $("body");
  let $app = $(document).find('app');

  // load countdown into body
  if (body.attr("timer") !== "false") {
    init_countdown(
      "/get/home/countdown/_countdown",
      $(document).find('[data-react="countdown,load"]')
    );
  }
});

const init_countdown = (url, append) => {
  let $countdown_container;
  let data = { element_include: true };
  let status;

  // # use short hand ajax request more often please
  $.post(url, data, (data) => {
    let $app = $(document).find('app');

    // append countdown data to s-container
    append.append(data);

    // init countdown container
    $countdown_container = $(document).find("countdown");

    // setting it to active, lets it fade in at the beginnign
    $countdown_container.attr("active", "true");

    url = "/do/countdown/check_running";

    // set interval for checking on countdown startup
    let info_card_status = false;

    loading_inveral = setInterval(() => {
      console.log('CHECKING COUNTDOWN RUNNING...');

      // init status by calling function
      status = check_countdown_running(url, $countdown_container);

      // clear interval and start countdown if countdown
      // startup is ON
      if (status) {

        // start the countdown
        start_countdown();

        // show info card after 2 seconds
        setTimeout(() => info_card_exists($app), 2000);

        // clear interval
        clearInterval(loading_inveral);
      } else {
        if (!info_card_status) {

          // show info card
          info_card_exists($app);

          // tell script info card is visible
          info_card_status = true;
        }
      }
    }, 1000);
  });
};

const check_countdown_running = (url, append) => {
  let $app = $(document).find("app");
  let status = false;

  $.ajax({
    url: url,
    async: false,
    dataType: 'JSON',
    method: 'GET',
    success: (data) => {
      console.log(data.status);

      // show countdown when it's running (respone with true status)
      if (data.status) {
        // show the countdown by appending attr active to s-container
        append.attr("active", true);

        // clear the interval for checking countdown startup
        clearInterval(loading_inveral);

        // reload the info card
        setTimeout(() => info_card_exists($app), 2000);
      }

      status = data.status;
    },
    error: (data) => console.error(data)
  });

  return status;
};

const get_due_time = (url) => {
  let due = {};

  $.ajax({
    url: url,
    // TODO: dont use sync ajax request. Find a better way to
    // access ajax return data inside this function
    async: false,
    // ------
    dataType: "JSON",
    method: "POST",
    success: (data) => {
      due = data;
    },
    error: (data) => {
      console.error(data);
    },
  });

  return due;
};

const start_countdown = () => {
  let $pyro = $(document).find(".pyro");
  let $output_hours = document.getElementById("countdown_hours");
  let $output_minutes = document.getElementById("countdown_minutes");
  let $output_seconds = document.getElementById("countdown_seconds");
  let due = get_due_time("/do/countdown/get_timestamps");
  let exact_due = new Date(due.due_timestamp).getTime();

  let x = setInterval(() => {
    let now = new Date().getTime();

    let distance = exact_due - now;
    let days = Math.floor(distance / (1000 * 60 * 60 * 24));
    let hours = Math.floor(
      (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
    );
    let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    let seconds = Math.floor((distance % (1000 * 60)) / 1000);

    hours = hours < 10 ? "0" + hours : hours;
    minutes = minutes < 10 ? "0" + minutes : minutes;
    seconds = seconds < 10 ? "0" + seconds : seconds;

    $output_hours.innerHTML = hours;
    $output_minutes.innerHTML = minutes;
    $output_seconds.innerHTML = seconds;

    if (distance < 1) {
      // explosions
      $pyro.attr('active', true);

      // manipulate info card
      show_info_card("Countdown is done! Let's go to LIDL!");

      // get audio
      const audioContext = new AudioContext();
      const element = document.querySelector("audio");
      const source = audioContext.createMediaElementSource(element);

      source.connect(audioContext.destination);
      element.play();

      // manipulate the countdown output
      $output_hours.innerHTML = "LE";
      $output_minutes.innerHTML = "TS";
      $output_seconds.innerHTML = "GO";

      // clear the interval mate
      clearInterval(x);
    }
  }, 1000);

  setTimeout(() => {
    $(document).find("s").addClass("active");
  }, 1000);
};

const info_card_exists = (append) => {
  let $info_card = append.find("info-card-model");
  let url = "/get/home/countdown/_info_card.php";

  // if info card already exists, remove it first
  if ($info_card.length > 0) {
    $info_card.attr('active', false);
    setTimeout(() => {
      $info_card.remove();
      load_info_card(url, append);
    }, 400);
  } else {
    load_info_card(url, append);
  }
};

const load_info_card = (url, append) => {
  $.get(url, (data) => {
    if (data) append.append(data);
    setTimeout(() => {
      append.find("info-card-model").attr("active", true);
    }, 100);
  }).fail((data) => {
    console.error(data);
  });
};