<?php
use yii\helpers\ArrayHelper;

if(in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'])
    ||
    strpos($_SERVER['REMOTE_ADDR'], '172.')!==false
){
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
    YII_ENV_PROD ? []:require(__DIR__ . '/../../common/config/main-local.php'),
    require(__DIR__ . '/../config/main.php'),
    require(__DIR__ . '/../config/main-local.php')
);

if(isset($_COOKIE['theme']) && $theme = $_COOKIE['theme']){
    if(in_array($theme, ['bootstrap', 'sakura_light']))
        $config = ArrayHelper::merge($config, require(__DIR__ . "/../../frontend/config/other/$theme.php"));
}

$application = new yii\web\Application($config);
$application->run();
