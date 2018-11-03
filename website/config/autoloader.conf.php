<?php

require_once __DIR__.'/global.conf.php';
require_once __DIR__.'/asset.conf.php';
require_once __DIR__.'/../lib/extends/autoloader.php';
require_once __DIR__.'/../orm/EntityCore.php';
require_once __DIR__.'/../orm/EntityManager.php';
require_once __DIR__.'/../build/DomParser.build.php';
require_once __DIR__.'/../build/Controller.build.php';
require_once __DIR__.'/../build/Helper.class.php';
require_once __DIR__.'/../build/Router.build.php';
$router = new Router();