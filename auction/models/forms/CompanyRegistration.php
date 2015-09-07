<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 13/8/15
 * Time: 10:07 AM
 */

namespace auction\models\forms;

use auction\components\Auction;
use auction\components\helpers\DatabaseHelper;
use auction\models\Companies;
use auction\models\CompanyUsers;
use auction\models\Users;
use yii\base\Model;
use auction\components\Events;
use auction\components\EventHandler;
use yii\web\UploadedFile;
use auction\models\AuctionEmails;

class CompanyRegistration extends Model{

    const AFTER_SAVE = 'afterSave';

    public $name;
    public $domain;
    public $contact;
    public $mobile;
    public $description;
    public $image;
    public $email;
    public $password;
    public $last_login;
    public $last_login_ip;
    public $address;

    private $_uploadDirectory;

    public function init(){
        //Registering create_company Event
        $this->on(Events::CREATE_COMPANY, [EventHandler::className(), 'Registration']);
        $this->on(Events::UPLOAD_IMAGE, [EventHandler::className(), 'UploadImage']);
        $this->on(self::AFTER_SAVE, [$this, 'afterSave']);
    }

    //Model Rules
    public function rules(){
        return [
            [['name','domain','mobile','email','password','description'],'required'],
            [['name','domain','contact','email'], 'trim'],
            ['address' , 'safe'],
            ['email','email'],
            [['mobile','contact'] ,'number'],
            ['image', 'image'],
            ['email','unique','targetClass' => Users::className(), 'targetAttribute' => 'email']
        ];
    }

    //Model Attributes
    public function attributeLabels(){
        return [
            'name' => 'Company Name',
            'domain' => 'Domain',
            'contact' => 'Contact Number',
            'description' => 'Description',
            'login_name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'mobile' => 'Mobile Number'
        ];
    }


    /**
     * trigger Event Assigned on Events::CREATE_Company
     * Events Defined In auction/components/Events
     */
    public function afterValidate(){
        $this->trigger(Events::REGISTRATION);
        $message = Auction::loggerMessageFormat('Company is Successfully Validated',$this->attributes);

        Auction::info($message);
        return parent::afterValidate();
    }

    /**
     * Save Company INfO
     * 3 Models Inserted in Dealer Save
     * User,Company,UserCompany Table Inserted
     * @note User is inserted with company role
     */
    public function SaveCompany(){

        if($this->validate()) {
            $transaction = Auction::$app->db->beginTransaction();
            try {
                $user=$this->SaveUser();
                $company=$this->SaveUserCompany();

                if(!$user || !$company) {
                    return null;
                }

                $companyUser=new CompanyUsers();
                $companyUser->company=$company;
                $companyUser->user=$user;

                if (!$companyUser->save(false)) {
                    return null;
                }

                $transaction->commit();
                $this->trigger(self::AFTER_SAVE);
                Auction::info('Company Registration Success');
                return true;

            } catch (Exception $ex) {
                $transaction->rollBack();
                $_message = Auction::loggerMessageFormat('Company Registration Failed with Following Errors',$this->getErrors());
                Auction::error($_message);
            }
        }

        return null;
    }

    private function SaveUser(){
        $user = new Users();
        $user->setAttributes($this->getAttributes());
        $user->setPassword($this->password);
        $user->user_role=DatabaseHelper::COMPANY_ADMIN;
        $user->is_active=DatabaseHelper::IN_ACTIVE;

        $user->profile_pic = $this->image;

        Auction::info('User Info Saved');
        return $user->save(false) ? $user->id : false;
    }


    private function SaveUserCompany(){
        $company = new Companies();
        $company->setAttributes($this->getAttributes());
        $company->logo_image = $this->image;

        Auction::info('Company Info Saved');
        return $company->save(false) ? $company->id : false;
    }

    public function validate($attributeNames = null, $clearErrors= true){
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
            $this->_uploadDirectory = Auction::getAlias('@webroot').'/uploads/company/';
        }

        return $this->_uploadDirectory;

    }

    public function afterSave(){
        $_model = new AuctionEmails();
        $_model->message = strtr(MessageTemplate::MessageTemplate(DatabaseHelper::DEALER_REGISTRATION_TEMPLATE),['{name}' => $this->name]);
        $_model->to = $this->email;
        $_model->subject = 'Auction :: Company Registration';
        $_model->from = 'Auction';
        $_model->status = DatabaseHelper::SEND_MAIL;

        if($_model->save()){
            Auction::info('Company Registration Email registered');
        }
        else {
            $message= Auction::loggerMessageFormat('Email is not send to user due to following errors',$_model->getErrors());
            Auction::error($message);
        }
    }
}