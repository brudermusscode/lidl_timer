<?php
# script for logging users into the system (create a session)

# require database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/init.php';

if(empty($_POST['mail']) || LOGGED) exit(NULL);