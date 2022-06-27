let __responder_close_timeout;

class Responder {
  add(append, message) {
    let $append = append,
      $responder,
      array;

    // check if responder is active already and return manipulation function
    if ($append.find("responder:not([deleted])").length) {

      // clear timeout for closing and hiding current responder
      clearTimeout(__responder_close_timeout);

      // start manipulating current responder...
      $responder = $append.find('responder:not(.deleted)');

      // return manipulation function
      return this.manipulate($responder, message);
    } else {

      // append the responder to the append object
      // and pass message to it
      $append.prepend(
        "<responder><r-inr>" + message + "</r-inr></responder > "
      );

      // initialize return array
      array = {
        responder: null,
        append: $append,
      };

      // find responder element
      $responder = $append.find("responder:not([deleted])");

      // add active class to responder to make it visible
      setTimeout(() => {
        $responder.addClass("active");
      }, 100);

      // set close timeout
      __responder_close_timeout = setTimeout(() => {
        this.close($responder);
      }, 6000);

      // add repsonder element to array
      array.responder = $responder;

      // return the responder element in array
      return array;
    }
  }

  manipulate(responder, message) {
    // set responder var to current responder
    let $responder = responder;

    // manipulate responder
    $responder.removeClass("active");

    // show responder after timeout
    setTimeout(() => {
     $responder.find("r-inr").html(message);
      $responder.addClass("active");
    }, 300);

    // set close timeout
    __responder_close_timeout = setTimeout(() => {
      this.close($responder);
    }, 6000);

    // dunno
    return true;
  }

  close(responder) {
    let $responder = responder,
      array;

    // init return array with responder and append
    array = {
      responder: $responder
    };

    // hide responder
    array.responder.addClass('deleted');
    array.responder.removeClass('active');

    // remove responder after time
    setTimeout(() => {
      array.responder.remove();
    }, 600);

    return array;
  }
}

// init new responder for public use
let responder = new Responder();
