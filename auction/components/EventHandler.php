<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 12/8/15
 * Time: 7:09 PM
 */

namespace auction\components;

use yii\base\Component;
use yii\helpers\FileHelper;
use yii\imagine\Image;

class EventHandler extends Component{

    /**
     * @param $event Register Dealer Event Triggered Before Register Dealer
     *
     * Will set $event->sender |$user object last_login_ip,last_visited
     */
    public static function RegisterDealer($event){

        $event->sender->last_login_ip=Auction::$app->request->userIP;
        $event->sender->last_visited=Auction::$app->formatter->asDatetime(strtotime('NOW'),'php:Y:m:d h-i-s');

    }

    /**
     * @param $event Register Company Event Triggered Before Register Dealer
     *
     * Will set $event->sender |$user object last_login_ip,last_visited
     */
    public static function RegisterCompany($event){

        $event->sender->last_login_ip=Auction::$app->request->userIP;
        $event->sender->last_visited=Auction::$app->formatter->asDatetime(strtotime('NOW'),'php:Y:m:d h-i-s');

    }

    /**
     * @param $event User Login Event
     *
     *Will set login ip of user and save to Users Model
     *
     */
    public static function UserLogin($event){


        $event->sender->last_login_ip=Auction::$app->request->userIP;
        $event->sender->last_login=Auction::$app->formatter->asDatetime(strtotime('NOW'));

        $event->sender->save();

    }

    /** Upload Image Thumb */
    public static function UploadImageThumb($event){

        $uploadDirectory= $event->sender->UploadDirectory();
        $thumbDirectory = $uploadDirectory.'thumbs/';

        if(!is_dir($thumbDirectory)){
            FileHelper::createDirectory($thumbDirectory);
        }

        Image::thumbnail($uploadDirectory .$event->sender->image, 50, 50)
            ->save($thumbDirectory . $event->sender->image, ['quality' => 50]);

    }
}