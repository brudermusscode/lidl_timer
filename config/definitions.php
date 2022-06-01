<?php

define("PREROOT", dirname($_SERVER["DOCUMENT_ROOT"]));
define("ROOT", $_SERVER["DOCUMENT_ROOT"]);
define("CONFIG", ROOT . '/config');
define("TEMPLATE", $_SERVER["DOCUMENT_ROOT"] . '/app/templates');
define("FUNCTION", $_SERVER["DOCUMENT_ROOT"] . '/app/functions');
define("JSON_RESPONSE_FORMAT", 'Content-type: application/json');
define("NOT_FOUND", 'location: /404');
define(false, 0);
define(true, 1);
