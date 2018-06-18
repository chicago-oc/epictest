<?php
define('YII_ENV', 'test');
defined('YII_DEBUG') or define('YII_DEBUG', true);

require_once __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
require __DIR__ .'/../vendor/autoload.php';

$params = require __DIR__ . '/../config/params.php';

(new yii\web\Application([
    'id' => 'test',
    'basePath' => dirname(__DIR__ . '/../../'),
    'params' => $params,
]));