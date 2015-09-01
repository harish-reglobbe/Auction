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
use yii\helpers\FileHelper;


class CompanyRegistration extends Model{

    public $name;
    public $domain;
    public $contact;
    public $mobile;
    public $description;
    public $profile_pic;
    public $email;
    public $password;
    public $last_visited;
    public $last_login_ip;
    public $address;

    private $_uploadDirectory;

    public function init(){
        //Registering create_company Event
        $this->on(Events::CREATE_COMPANY, [EventHandler::className(), 'RegisterCompany']);
        $this->on(Events::SAVE_UPLOAD_THUMB, [EventHandler::className(), 'UploadImageThumb']);
    }

    //Model Rules
    public function rules(){
        return [
            [['name','domain','mobile','email','password','description'],'required'],
            [['name','domain','contact','email'], 'trim'],
            ['address' , 'safe'],
            ['email','email'],
            [['mobile','contact'] ,'number'],
            ['profile_pic', 'image'],
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
        $this->trigger(Events::CREATE_COMPANY);
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
                $companyUser->company=$company->id;
                $companyUser->user=$user->id;

                if (!$companyUser->save(false)) {
                    return null;
                }

                $transaction->commit();
                return $user;

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
        $user->user_role=DatabaseHelper::COMPANY_ADMIN;
        $user->mobile=$this->mobile;
        $user->is_active=DatabaseHelper::IN_ACTIVE;

        $user->profile_pic = $this->profile_pic;

        if (!$user->save(false)) {
            return null;
        }

        return $user;
    }


    private function SaveUserCompany(){
        $company = new Companies();
        $company->name = $this->name;
        $company->contact = $this->contact;
        $company->domain=$this->domain;
        $company->description = $this->description;

        if(!$company->save(false)){
            return null;
        }

        return $company;
    }

    public function validate(){
        $this->profile_pic=UploadedFile::getInstance($this,'image');

        if(!parent::validate())
            return false;

        if($this->profile_pic instanceof UploadedFile){

            if(!getimagesize($this->image->tempName)){
                $this->addError('image','Please Upload a valid Image');
                return false;
            }

            $uploadDirectory= $this->UploadDirectory();

            if(!is_dir($uploadDirectory)){
                FileHelper::createDirectory($uploadDirectory);
            }

            $imageName=$this->image->baseName.time().'.'.$this->image->extension;

            $this->profile_pic->saveAs($uploadDirectory.$imageName);
            $this->profile_pic=$imageName;
            $this->trigger(Events::SAVE_UPLOAD_THUMB);

        }
        return true;

    }

    public function UploadDirectory(){

        if($this->_uploadDirectory === null){
            $this->_uploadDirectory = Auction::getAlias('@webroot').'/uploads/company/';
        }

        return $this->_uploadDirectory;

    }
}