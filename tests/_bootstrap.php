<?php
// This is global bootstrap for autoloading 
// defined('YII_DEBUG') or define('YII_DEBUG', true);

require(__DIR__ . '/../vendor/yiisoft/yii2/yii/Yii.php');
require(__DIR__ . '/../vendor/autoload.php');
Yii::importNamespaces(require(__DIR__ . '/../vendor/composer/autoload_namespaces.php'));

$config = yii\helpers\ArrayHelper::merge(
	require(__DIR__ . '/../frontend/config/main.php'),
	require(__DIR__ . '/../frontend/config/main-local.php')
);

class YiiAspectKernel extends \AspectMock\Kernel {

    protected function getApplicationLoaderPath()
    {
        return realpath(__DIR__.'/../vendor/yiisoft/yii2/yii/YiiBase.php');
    }	
}

ini_set('xdebug.max_nesting_level', 500);
$kernel = YiiAspectKernel::getInstance();
$kernel->init([
    'debug' => true,
    // 'appDir'    => __DIR__ . '/../',
    // 'cacheDir' => __DIR__.'/_data/cache',
    'includePaths' => [__DIR__.'/../common'],
    // 'cacheDir' => 'tests/_data/cache',
    // 'includePaths' => ['common'],
    'excludePaths' => [__DIR__.'/../vendor']
]);
?>