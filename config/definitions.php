<?php

define("PREROOT", dirname(dirname(__DIR__)));
define("ROOT", dirname(__DIR__));
define("CONFIG", ROOT . '/config');
define("TEMPLATE", ROOT . '/app/templates');
define("FUNCTION", ROOT . '/app/functions');
define("JSON_RESPONSE_FORMAT", 'Content-type: application/json');
define("NOT_FOUND", 'location: /404');
define(false, 0);
define(true, 1);