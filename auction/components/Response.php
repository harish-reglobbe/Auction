<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 11/9/15
 * Time: 4:28 PM
 */

namespace auction\components;


class Response extends \yii\web\Response{

    public function init(){
        $this->on(self::EVENT_BEFORE_SEND,[$this, 'beforeSend']);
        parent::init();
    }

    public function beforeSend($event){
       if($event->sender->statusCode == 500){
           //Todo Send mail on Internal Server Errors
       }

    }


}