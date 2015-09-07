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
use yii\helpers\VarDumper;
use Yii;

class Auction extends Yii{

    const LOGGER_FRONTEND_CATEGORY = 'frontend';

    public static function createUrl($url){
        return Yii::$app->urlManager->createAbsoluteUrl([$url]);
    }

    public static function info($message,$category = self::LOGGER_FRONTEND_CATEGORY){
        parent::info($message,$category);
    }

    public static function trace($message,$category = self::LOGGER_FRONTEND_CATEGORY){
        parent::trace($message,$category);
    }

    public static function warning($message,$category = self::LOGGER_FRONTEND_CATEGORY){
        parent::warning($message,$category);
    }

    public static function error($message,$category = self::LOGGER_FRONTEND_CATEGORY){
        parent::error($message,$category);
    }

    public static function loggerMessageFormat($message,$logVars){
        $context[] = "{Params Details} = " . VarDumper::dumpAsString($logVars);
        return $message.' :: '.implode("\n\n", $context);
    }

    public static function infoLog($message,$logVars){
        $_message = self::loggerMessageFormat($message,$logVars);

        self::info($_message);
    }

    public static function errorLog($message,$logVars){
        $_message = self::loggerMessageFormat($message,$logVars);

        self::error($_message);
    }
}