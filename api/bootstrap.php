<?php


require __DIR__ . "/vendor/autoload.php";

set_error_handler(("ErrorHandler::handleError"));
set_exception_handler("ErrorHandler::handleException");

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);

$dotenv->load();


header("Content-type: application/json; charset=UTF-8");
