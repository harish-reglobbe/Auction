<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 12/8/15
 * Time: 7:09 PM
 */

namespace frontend\components;


use yii\base\Component;

class EventHandler extends Component{

    public function RegisterDealer($event){
        $event->sender->last_login_ip=Reglobe::$app->request->userIP;
        $event->sender->last_visited=Reglobe::$app->formatter->asDatetime(strtotime('NOW'),'php:Y:m:d h-i-s');
    }

    public function RegisterCompany($event){
        $event->sender->last_login_ip=Reglobe::$app->request->userIP;
        $event->sender->last_visited=Reglobe::$app->formatter->asDatetime(strtotime('NOW'),'php:Y:m:d h-i-s');
    }
}