<?php
/**
 * Created by PhpStorm.
 * User: Double H
 * Date: 05-09-2015
 * Time: 11:01 AM
 */

namespace auction\components\log;

use Yii;
use auction\components\Auction;

class FileTarget extends \yii\log\FileTarget
{

    public $categories = [Auction::LOGGER_FRONTEND_CATEGORY];

    public $logFile = '@app/runtime/logs/frontend/request.log';

    public $logVars = [];

    public $maxFileSize = 2048; // in KB

    public $maxLogFiles = 10;

    public function getMessagePrefix($message)
    {
        if ($this->prefix !== null) {
            return call_user_func($this->prefix, $message);
        }

        if (Yii::$app === null) {
            return '';
        }

        $request = Yii::$app->getRequest();
        $ip = $request instanceof Request ? $request->getUserIP() : '-';

        /* @var $user \yii\web\User */
        $user = Yii::$app->has('user', true) ? Yii::$app->get('user') : null;
        if ($user && ($identity = $user->getIdentity(false))) {
            $userID = $identity->getId();
        } else {
            $userID = '-';
        }

        /* @var $session \yii\web\Session */
        $session = Yii::$app->has('session', true) ? Yii::$app->get('session') : null;
        $sessionID = $session && $session->getIsActive() ? $session->get('user.name') : '-';

        return "[UserIp::$ip][UserID::$userID][UserName::$sessionID]";
    }

}