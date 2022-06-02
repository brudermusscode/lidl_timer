<?php
# this file defines and initializes the Sign class which will hold all
# essential methods for signing users in, out and up

// initialize Sign class
$Sign = new Sign($pdo, $_SESSION, $_COOKIE);

// define Sign class
class Sign extends Main
{

    // check login state for user
    public function isAuthed()
    {

        if (!isset($this->cookies->TOK, $this->cookies->SER, $this->session->token, $this->session->serial)) return false;

        $cookie_token = $this->cookies->TOK;
        $cookie_serial = $this->cookies->SER;
        $session_token = $this->session->token;
        $session_serial = $this->session->serial;
        $session_id = $this->session->id;

        // check if cookies and serial are same
        if ($cookie_token != $session_token || $cookie_serial != $session_serial) {
            $this->logout();
            return false;
        }

        // get session from database
        $query = "SELECT * FROM user_sessions WHERE user_id = ? AND token = ? AND serial = ?";
        $get_session_data = $this->select($query, [$session_id, $session_token, $session_serial]);

        if (!$get_session_data->stmt->rowCount() > 0) {
            $this->logout();
            return false;
        }

        return true;
    }

    // validating email addresses
    public function validateMail(string $mail)
    {

        if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {

            $mail_explode = explode('@', $mail);

            if($mail_explode[1] !== 'deltacity.net') {
                return false;
            }

            return true;
        }

        return false;
    }

    // create numeric code with custom length
    public function createCode(string $length)
    {

        $string = "0123456789";
        return substr(str_shuffle($string), 0, $length);
    }

    // create string custom length
    public function createString(string $len)
    {
        $s = bin2hex(random_bytes($len));
        return $s;
    }

    // create a session to keep user logged in
    public function createSession(object $fetch, object $serial, bool $reset = false, bool $commit = false)
    {

        (object) $fetch;
        (object) $serial;
        (bool) $reset;
        (bool) $commit;

        # if underneath conditions mathc, jus5t reset the current session
        if (!isset($serial->token, $serial->serial, $serial->user_id) || $reset) {
            // pass serial and token keys to fetch object
            $fetch->serial = $serial->serial;
            $fetch->token = $serial->token;

            // loop through fetch object and pass all keys + values to $SESSION
            foreach ($fetch as $f => $k) $_SESSION[$f] = $k;
            return $_SESSION;
        }

        # start a new transaction
        # $this->pdo->beginTransaction();

        # try to create a new session with serial-data
        $q = "INSERT INTO user_sessions (user_id, token, serial) VALUES (?, ?, ?)";
        $p = (array) [$serial->user_id, $serial->token, $serial->serial];
        $insert = $this->insert($q, $p, $commit);

        if (!$insert->status) return false;

        // pass serial and token keys to fetch object
        $fetch->serial = $serial->serial;
        $fetch->token = $serial->token;

        // loop through fetch object and pass all keys + values
        // to $_SESSION
        foreach ($fetch as $f => $k) {
            $_SESSION[$f] = $k;
        }

        // set cookies to compare session serials
        setcookie('TOK', $serial->token, time() + (86400) * 30, "/");
        setcookie('SER', $serial->serial, time() + (86400) * 30, "/");

        // return objectified $SESSION
        return true;
    }

    // reset sesson and get new settings
    public function resetSession()
    {

        # return false if user is not logged in
        if (!$this->isAuthed()) return false;

        // get user data and compare to current session data
        $q = "SELECT * FROM users WHERE id = ? LIMIT 1";
        $p = (array) [$this->session->id];
        $stmt = $this->select($q, $p, false);

        # return false if statement fails
        if (!$stmt->status) return false;

        # objectify cookie-session data
        $serial = (object) [
            "serial" => $this->cookies->SER,
            "token" => $this->cookies->TOK
        ];

        // fetch user information
        $user = $stmt->fetch;

        // return new createSession with user-object
        return $this->createSession($user, $serial, true);
    }

    // logout
    public function logout()
    {

        setcookie('TOK', '', time() - 1, "/");
        setcookie('SER', '', time() - 1, "/");

        session_unset();
        session_destroy();
    }

    # return real estate client ip
    public static function getRemoteAddress()
    {
        if (!isset($_SERVER['REMOTE_ADDR'])) {
            return NULL;
        }

        $proxy_header = "HTTP_X_FORWARDED_FOR";
        $trusted_proxies = ["2001:db8::1", "192.168.50.1"];

        if (in_array($_SERVER['REMOTE_ADDR'], $trusted_proxies)) {

            if (array_key_exists($proxy_header, $_SERVER)) {

                $proxy_list = explode(",", $_SERVER[$proxy_header]);
                $client_ip = trim(end($proxy_list));

                if (filter_var($client_ip, FILTER_VALIDATE_IP)) {
                    return $client_ip;
                } else {
                    // Validation failed - beat the guy who configured the proxy or
                    // the guy who created the trusted proxy list?
                    // TODO: some error handling to notify about the need of punishment
                }
            }
        }

        return $_SERVER['REMOTE_ADDR'];
    }
}