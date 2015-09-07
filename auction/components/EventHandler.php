<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 12/8/15
 * Time: 7:09 PM
 */

namespace auction\components;

use auction\components\helpers\DatabaseHelper;
use auction\models\AuctionEmails;
use auction\models\MessageTemplate;
use auction\models\OptHistory;
use yii\base\Component;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use yii\web\HttpException;

class EventHandler extends Component{

    /**
     * @param $event Register Dealer Event Triggered Before Register Dealer
     *
     * Will set $event->sender |$user object last_login_ip,last_visited
     */
    public static function Registration($event){

        $event->sender->last_login_ip=Auction::$app->request->userIP;
        $event->sender->last_login=Auction::$app->formatter->asDatetime(strtotime('NOW'),'php:Y:m:d h-i-s');

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

        Auction::info('Image Thumb Saved In :: '. $thumbDirectory);
        Image::thumbnail($uploadDirectory .$event->sender->image, 50, 50)
            ->save($thumbDirectory . $event->sender->image, ['quality' => 50]);
    }

    /** Upload Image **/

    public static function UploadImage($event){

        $uploadDirectory= $event->sender->UploadDirectory();

        if(!is_dir($uploadDirectory)){
            FileHelper::createDirectory($uploadDirectory);
        }

        $imageName=$event->sender->image->baseName.time().'.'.$event->sender->image->extension;

        $event->sender->image->saveAs($uploadDirectory.$imageName);
        $event->sender->image=$imageName;

        Auction::info('Image Saved in :: '.$uploadDirectory);
        self::UploadImageThumb($event);
    }

    /** Token Invalid */

    public static function TokenInvalid($event){

        Auction::$app->db->createCommand()->update($event->sender->tableName(),[
            'status' => DatabaseHelper::IN_ACTIVE
        ],'user=:user and status=:status',[
            ':user' => $event->sender->userObject->id,
            ':status' => DatabaseHelper::ACTIVE
        ])->execute();
    }

    /** Send Reset Token */
    public static function SendResetToken($event){
        $message = '';
        switch ($event->sender->mode){

            case DatabaseHelper::TOKEN_SEND_MODE_WEB:
                $message = MessageTemplate::MessageTemplate(DatabaseHelper::FORGOT_PASSWORD_MAIL_TEMPLATE);
                $_model = new AuctionEmails();
                $_model->to = $event->sender->userObject->email;
                $_model->subject = 'Auction :: Reset Password Email';
                $_model->status = 0 ;
                $_model->from = 'Auction';
                break;

            case DatabaseHelper::TOKEN_SEND_MODE_MOBILE:
                $message = MessageTemplate::MessageTemplate(DatabaseHelper::FORGOT_PASSWORD_SMS_TEMPLATE);
                $_model = new OptHistory();
                $_model->mobile = $event->sender->userObject->mobile;
                break;
        }
        if($message == ''){
            Auction::error('No Valid Msg Template Found For ' .$event->sender->mode.' in database');
            throw new HttpException(400 , 'No Template Found');
        }

        $_model->message = $message;

        if($_model->save()){
            Auction::info('User Token successfully Created');
        }else {
            $_message = Auction::loggerMessageFormat('User reset token template invalid ',$_model->getErrors());
            Auction::error($_message);
        }
    }
}