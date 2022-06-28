let loading_interval;

class Countdown {
  init(url, append) {
    let $app = append;
    let $countdown_container;
    let data = { element_include: true };
    let status;

    $.post(url, data, (data) => {
      // append countdown data to s-container
      append.append(data);

      // init countdown container
      setTimeout(() => {
        $countdown_container = $(document).find("countdown");

        // setting it to active, lets it fade in at the beginnign
        setTimeout(() => $countdown_container.attr("active", "true"), 100);

        url = "/do/countdown/check_running";

        // set interval for checking on countdown startup
        let info_card_status = false;

        let due_reached = this.check_countdown_due_reached();

        console.log("COUNTDOWN DUE REACHED:", due_reached);

        if (!due_reached) {
          loading_interval = setInterval(() => {
            console.log("CHECKING COUNTDOWN RUNNING...");

            // init status by calling function
            status = this.check_countdown_running(url, $countdown_container);

            // clear interval and start countdown if countdown
            // startup is ON
            if (status) {
              console.log("COUNTDOWN RUNNING:", status);

              // start the countdown
              this.start_countdown();

              // show info card after 2 seconds
              setTimeout(() => info_card_exists($app), 2000);

              // clear interval
              clearInterval(loading_interval);
            } else {
              console.log("COUNTDOWN RUNNING:", status);

              if (!info_card_status) {
                // show info card
                info_card_exists($app);

                // tell script info card is visible
                info_card_status = true;
              }
            }
          }, 1000);
        } else {
          setTimeout(() => info_card_exists($app), 2000);
        }
      }, 10);
    });
  }

  check_countdown_running = (url, append) => {
    let status = false;

    $.ajax({
      url: url,
      async: false,
      dataType: "JSON",
      method: "GET",
      success: (data) => {
        // show countdown when it's running (respone with true status)
        if (data.status) {
          // show the countdown by appending attr active to s-container
          append.attr("active", true);

          // clear the interval for checking countdown startup
          clearInterval(loading_interval);
        }

        status = data.status;
      },
      error: (data) => console.error(data),
    });

    return status;
  };

  check_countdown_due_reached = () => {
    let url = "/do/countdown/check_due_reached";
    let status = false;

    $.ajax({
      url: url,
      method: "POST",
      async: false,
      success: (data) => {
        if (data) status = true;
      },
    });

    return status;
  };

  get_due_time = () => {
    let url = "/do/countdown/get_timestamps";
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

  start_countdown = () => {
    let $app = $(document).find("app");
    let $pyro = $(document).find(".pyro");
    let $output_hours = document.getElementById("countdown_hours");
    let $output_minutes = document.getElementById("countdown_minutes");
    let $output_seconds = document.getElementById("countdown_seconds");
    let due = this.get_due_time();
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
        $pyro.attr("active", true);

        // manipulate info card
        info_card_exists($app, "Countdown is done! Let's go to LIDL!");

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
}

// init new responder for public use
let countdown = new Countdown();
