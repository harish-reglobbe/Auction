<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 12/8/15
 * Time: 7:09 PM
 */

namespace auction\components;

use yii\base\Component;

class EventHandler extends Component{

    public static function RegisterDealer($event){
        $event->sender->last_login_ip=Auction::$app->request->userIP;
        $event->sender->last_visited=Auction::$app->formatter->asDatetime(strtotime('NOW'),'php:Y:m:d h-i-s');
    }

    public static function RegisterCompany($event){
        $event->sender->last_login_ip=Auction::$app->request->userIP;
        $event->sender->last_visited=Auction::$app->formatter->asDatetime(strtotime('NOW'),'php:Y:m:d h-i-s');
    }
}