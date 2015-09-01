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
use auction\models\Dealers;
use yii\base\Exception;
use yii\base\Model;
use auction\models\Users;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class DealerRegistration extends Model{

    public $name;
    public $city;
    public $mobile;
    public $email;
    public $password;
    public $last_visited;
    public $last_login_ip;
    public $image;
    public $address;

    private $_uploadDirectory;

    public function init(){
        $this->on(Events::CREATE_DEALER, [EventHandler::className(), 'RegisterDealer']);
        $this->on(Events::SAVE_UPLOAD_THUMB, [EventHandler::className(), 'UploadImageThumb']);
    }

    //Model Rules
    public function rules(){
        return [
            [['name','city','mobile','email','password'],'required'],
            [['name','city','mobile','email'], 'trim'],
            ['email','email'],
            ['image', 'image'],
            ['address' , 'safe'],
            ['email','unique','targetClass' => Users::className(), 'targetAttribute' => 'email']
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
        $this->trigger(Events::CREATE_DEALER);
        return parent::afterValidate();
    }

    /**
     * Save Dealer INfO
     * 2 Models Inserted in Dealer Save
     * User,Dealer Table Inserted
     * @note User is inserted with dealer role
     */

    public function SaveDealer(){

        if($this->validate()) {
            $transaction = Auction::$app->db->beginTransaction();
            try {
                $user=$this->SaveUser();
//
                if(!$user){
                    return null;
                }

                $dealer = new Dealers();
                $dealer->name = $this->city;
                $dealer->contact = $this->mobile;
                $dealer->city = $this->city;
                $dealer->user=$user->primaryKey;
                $dealer->address = $this->address;

                if (!$dealer->save(false)) {
                    return null;
                }

                $transaction->commit();

                return true;

            } catch (Exception $ex) {
                $transaction->rollBack();
            }
        }

        return null;
    }


    private function SaveUser(){
        $user = new Users();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->last_login_ip = $this->last_login_ip;
        $user->last_login = $this->last_visited;
        $user->user_role=DatabaseHelper::DEALER;
        $user->mobile=$this->mobile;

        $user->is_active=DatabaseHelper::IN_ACTIVE;
        $user->profile_pic = $this->image;

        if (!$user->save(false)) {
            return null;
        }

        return $user;
    }

    public function validate(){
        $this->image=UploadedFile::getInstance($this,'image');

        if(!parent::validate())
            return false;

        if($this->image instanceof UploadedFile){

            if(!getimagesize($this->image->tempName)){
                $this->addError('image','Please Upload a valid Image');
                return false;
            }

            $uploadDirectory= $this->UploadDirectory();

            if(!is_dir($uploadDirectory)){
                FileHelper::createDirectory($uploadDirectory);
            }

            $imageName=$this->image->baseName.time().'.'.$this->image->extension;

            $this->image->saveAs($uploadDirectory.$imageName);
            $this->image=$imageName;
            $this->trigger(Events::SAVE_UPLOAD_THUMB);

        }
        return true;

    }

    public function UploadDirectory(){

        if($this->_uploadDirectory === null){
            $this->_uploadDirectory = Auction::getAlias('@webroot').'/uploads/dealers/';
        }

        return $this->_uploadDirectory;

    }

}