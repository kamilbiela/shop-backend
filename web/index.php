<?php
putenv('APP_ENV=dev');

$app = require_once '../app.php';
$app->run();