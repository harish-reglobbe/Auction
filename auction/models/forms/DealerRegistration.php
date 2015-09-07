<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 12/8/15
 * Time: 6:06 PM
 */
namespace auction\models\forms;

use auction\components\Auction;
use auction\components\EventHandler;
use auction\components\Events;
use auction\components\helpers\DatabaseHelper;
use auction\models\AuctionEmails;
use auction\models\Dealers;
use auction\models\MessageTemplate;
use yii\base\Exception;
use yii\base\Model;
use auction\models\Users;
use yii\web\UploadedFile;

class DealerRegistration extends Model{

    const AFTER_SAVE = 'afterSave';

    public $name;
    public $city;
    public $mobile;
    public $email;
    public $password;
    public $last_login;
    public $last_login_ip;
    public $image;
    public $address;

    private $_uploadDirectory;

    public function init(){
        $this->on(Events::REGISTRATION, [EventHandler::className(), 'Registration']);
        $this->on(Events::UPLOAD_IMAGE, [EventHandler::className(), 'UploadImage']);
        $this->on(self::AFTER_SAVE, [$this, 'afterSave']);
    }

    //Model Rules
    public function rules(){
        return [
            [['name','city','mobile','email','password'],'required'],
            [['name','city','mobile','email'], 'trim'],
            ['email','email'],
            ['image', 'image'],
            ['address' , 'safe'],
          //  ['email','unique','targetClass' => Users::className(), 'targetAttribute' => 'email']
        ];
    }

    //Model Attributes
    public function attributeLabels(){
        return [
            'name' => 'Dealer Name',
            'city' => 'City',
            'mobile' => 'Contact Number',
            'login_name' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'address' => 'Address'
        ];
    }


    /**
     * trigger Event Assigned on Events::CREATE_DEALER
     * Events Defined In auction/components/Events
     */
    public function afterValidate(){
        $this->trigger(Events::REGISTRATION);
        $message = Auction::loggerMessageFormat('Dealer is Successfully Validated',$this->attributes);

        Auction::info($message);
        return parent::afterValidate();
    }

    /**
     * Save Dealer INfO
     * 2 Models Inserted in Dealer Save
     * User,Dealer Table Inserted
     * @note User is inserted with dealer role
     */

    public function save(){
        if($this->validate()) {
            $transaction = Auction::$app->db->beginTransaction();
            try {
                $user=$this->SaveUser();
                if(!$user || !$this->SaveDealer($user)){
                    return null;
                }

                $transaction->commit();
                $this->trigger(self::AFTER_SAVE);
                Auction::info('Dealer Registration Success');

                return true;
            } catch (Exception $ex) {
                $transaction->rollBack();
                $_message = Auction::loggerMessageFormat('Dealer Registration Failed with Following Errors',$this->getErrors());
                Auction::error($_message);
            }
        }

        return null;
    }


    private function SaveUser(){
        $user = new Users();
        $user->setAttributes($this->getAttributes());

        $user->setPassword($this->password);
        $user->user_role=DatabaseHelper::DEALER;
        $user->is_active=DatabaseHelper::IN_ACTIVE;
        $user->profile_pic = $this->image;

        Auction::info('User Info Saved');
        return $user->save(false) ? $user->id : false;
    }

    private function SaveDealer($user){

        $dealer = new Dealers();
        $dealer->setAttributes($this->getAttributes());
        $dealer->contact = $this->mobile;
        $dealer->user=$user;

        Auction::info('Dealer Info Saved');
        return $dealer->save(false) ? $dealer->id : false;
    }

    public function validate($attributeNames = null, $clearErrors = true){
        $this->image=UploadedFile::getInstance($this,'image');

        if(!parent::validate($attributeNames, $clearErrors)){
            $_message = Auction::loggerMessageFormat('Dealer Registration not validated with following Param',$this->attributes());

            Auction::error($_message);
            return false;
        }

        if($this->image instanceof UploadedFile){

            if(!getimagesize($this->image->tempName)){
                $this->addError('image','Please Upload a valid Image');
                return false;
            }

            $this->trigger(Events::UPLOAD_IMAGE);
        }
        return true;
    }

    public function UploadDirectory(){

        if($this->_uploadDirectory === null){
            $this->_uploadDirectory = Auction::getAlias('@webroot').'/uploads/dealers/';
        }

        return $this->_uploadDirectory;

    }

    public function afterSave(){
        $_model = new AuctionEmails();
        $_model->message = strtr(MessageTemplate::MessageTemplate(DatabaseHelper::DEALER_REGISTRATION_TEMPLATE),['{name}' => $this->name]);
        $_model->to = $this->email;
        $_model->subject = 'Auction :: Dealer Registration';
        $_model->from = 'Auction';
        $_model->status = DatabaseHelper::SEND_MAIL;

        if($_model->save()){
            Auction::info('Dealer Registration Email registered');
        }
        else {
            $message= Auction::loggerMessageFormat('Email is not send to user due to following errors',$_model->getErrors());
            Auction::error($message);
        }
    }
}