<?php

if(gethostname()=='sakuracommerce.com')
    defined('YII_ENV_TEST_PROD') or define('YII_ENV_TEST_PROD', true);
else
    defined('YII_ENV_TEST_PROD') or define('YII_ENV_TEST_PROD', false);

return yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../../../common/config/main.php',
    YII_ENV_TEST_PROD ? []:require __DIR__ . '/../../../common/config/main-local.php',
    require __DIR__ . '/../../../frontend/config/main.php',
    require __DIR__ . '/../../../frontend/config/main-local.php',
    require __DIR__ . '/test.php',
    [
    ]
);
