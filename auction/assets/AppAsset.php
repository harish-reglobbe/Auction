<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace auction\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
      //  'css/site.css',
        'css/metisMenu.min.css',
        'css/bootstrap.min.css',
      //  'css/morris.css',
        'css/sb-admin-2.css',
        'css/font-awesome.min.css'
    ];

    public $js = [
        'js/metisMenu.js',
        'js/sb-admin-2.js',
        'js/bootstrap.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
       // 'yii\bootstrap\BootstrapAsset',
    ];
}
