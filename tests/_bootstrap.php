<?php
define('YII_ENV', 'test');

$kernel = AspectMock\Kernel::getInstance();
$kernel->init([
    'debug' => true,
    'includePaths' => [__DIR__.'/../common'],
]);
$kernel->loadFile(__DIR__ . '/../vendor/yiisoft/yii2/yii/Yii.php');

$config = yii\helpers\ArrayHelper::merge(
	require(__DIR__ . '/../frontend/config/main.php'),
	require(__DIR__ . '/../frontend/config/main-local.php')
);

$application = new yii\web\Application($config);