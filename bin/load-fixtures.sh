#!/usr/bin/env php
<?php

$app = require_once __DIR__ . '/../app.php';

use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;

$loader = new Loader();
$loader->loadFromDirectory(__DIR__ . '/../src/fixture');

$fixtures = $loader->getFixtures();

$em = $app['db.em'];
$purger = new ORMPurger();
$executor = new ORMExecutor($em, $purger);
$executor->execute($loader->getFixtures());