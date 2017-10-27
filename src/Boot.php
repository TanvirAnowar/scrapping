<?php

/*
* Initialize auto-loading and other global settings.
*
* */
ini_set('display_errors', 1);
error_reporting(-1);

require_once __DIR__.'/../vendor/autoload.php';


$dotenv = new \Dotenv\Dotenv(__DIR__."/../");
$dotenv->load();