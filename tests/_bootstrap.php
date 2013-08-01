<?php
define('YII_ENV', 'test');
// This is global bootstrap for autoloading 
// defined('YII_DEBUG') or define('YII_DEBUG', true);

//require(__DIR__ . '/../vendor/yiisoft/yii2/yii/Yii.php');


$kernel = AspectMock\Kernel::getInstance();
$kernel->init([
    'debug' => true,
    'cacheDir' => __DIR__.'/_data/cache',
    'includePaths' => [__DIR__.'/../common'],
//    'excludePaths' => [__DIR__.'/../vendor'],
]);
//$kernel->loadFile(__DIR__ . '/../vendor/yiisoft/yii2/yii/Yii.php');
require __DIR__ . '/../vendor/yiisoft/yii2/yii/Yii.php';
$kernel->loadPhpFiles(__DIR__.'/../common');

$config = yii\helpers\ArrayHelper::merge(
	require(__DIR__ . '/../frontend/config/main.php'),
	require(__DIR__ . '/../frontend/config/main-local.php')
);

//new \common\models\LoginForm();vj;t
$application = new yii\web\Application($config);