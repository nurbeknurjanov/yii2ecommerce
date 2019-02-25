<?php

use yii\helpers\ArrayHelper;
use extended\application\Application;


if(in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'])){
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    defined('YII_ENV') or define('YII_ENV', 'dev');
}else{
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    defined('YII_ENV') or define('YII_ENV', 'prod');
}


require(__DIR__ . '/../../vendor/autoload.php');
require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../../common/config/bootstrap.php');
require(__DIR__ . '/../config/bootstrap.php');

$config = ArrayHelper::merge(
    require(__DIR__ . '/../../common/config/main.php'),
    require(__DIR__ . '/../../common/config/main-local.php'),
    require(__DIR__ . '/../config/main.php'),
    require(__DIR__ . '/../config/main-local.php')
);

$config = ArrayHelper::merge($config, require(__DIR__ . "/../../common/config/settings/cosmetic.php"));
$config = ArrayHelper::merge($config, require(__DIR__ . "/../../frontend/config/settings/cosmetic.php"));

$application = new Application($config);
$application->run();
