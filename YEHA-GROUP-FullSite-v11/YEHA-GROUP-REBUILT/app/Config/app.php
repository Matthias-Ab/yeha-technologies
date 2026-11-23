<?php
declare(strict_types=1);
define('APP_NAME','YEHA GROUP'); define('APP_ENV','development'); define('APP_DEBUG',APP_ENV==='development');
$__pub=str_replace('\\','/',(string)realpath(__DIR__.'/../../public'));$__doc=rtrim(str_replace('\\','/',(string)realpath((string)($_SERVER['DOCUMENT_ROOT']??''))),'/');
define('BASE_URL',($__pub&&$__doc&&stripos($__pub,$__doc)===0)?substr($__pub,strlen($__doc)):'/YEHA-GROUP/public'); date_default_timezone_set('Africa/Addis_Ababa');
