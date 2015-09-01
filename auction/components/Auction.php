<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 10/8/15
 * Time: 12:37 PM
 *
 * Reglobe Class Extends Yii Class To use Yii::$app() in Own Define Class Name Format
 *
 * You can Application Object Via Auction::$app();
 * Any Where
 */

namespace auction\components;

use Yii;

class Auction extends Yii{

    public static function createUrl($url){
        return Yii::$app->urlManager->createAbsoluteUrl([$url]);
    }
}