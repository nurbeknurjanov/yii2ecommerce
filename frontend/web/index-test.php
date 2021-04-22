<?php
use yii\helpers\ArrayHelper;

// NOTE: Make sure this file is not accessible when deployed to production
if (!in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'])) {
    die('You are not allowed to access this file.');
}

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');

require(__DIR__ . '/../../vendor/autoload.php');
require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../../common/config/bootstrap.php');
require(__DIR__ . '/../config/bootstrap.php');

$config = require(__DIR__ . '/../../tests/codeception/config/test-merged.php');

if(isset($_COOKIE['theme']) && $theme = $_COOKIE['theme']){
    //if(in_array($theme, ['cosmetic', 'filters']))
    //$config = ArrayHelper::merge($config, require(__DIR__ . "/../../common/config/other/$theme.php"));
    if(in_array($theme, ['bootstrap', 'sakura_light']))
        $config = ArrayHelper::merge($config, require(__DIR__ . "/../../frontend/config/other/$theme.php"));
}

(new yii\web\Application($config))->run();
