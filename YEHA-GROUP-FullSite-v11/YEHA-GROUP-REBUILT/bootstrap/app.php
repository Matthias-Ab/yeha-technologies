<?php
declare(strict_types=1);
require_once __DIR__.'/../app/Config/app.php';
if(session_status()!==PHP_SESSION_ACTIVE){session_name('YEHA_SESSION');session_start();}
require_once __DIR__.'/../app/Core/Database.php';
require_once __DIR__.'/../app/Core/helpers.php';
require_once __DIR__.'/../app/Core/Auth.php';
if(APP_DEBUG){ini_set('display_errors','1');error_reporting(E_ALL);}else{ini_set('display_errors','0');error_reporting(0);}
