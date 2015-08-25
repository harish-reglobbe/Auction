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


class CompanyRegistration extends Model{

    public $name;
    public $domain;
    public $contact;
    public $mobile;
    public $description;
    public $image;
    public $login_name;
    public $email;
    public $password;
    public $last_visited;
    public $last_login_ip;

    public function init(){
        //Registering create_company Event
        $this->on(Events::CREATE_COMPANY, [EventHandler::className(), 'RegisterCompany']);
    }

    //Model Rules
    public function rules(){
        return [
            [['name','domain','contact','mobile','login_name','email','password','description'],'required'],
            [['name','domain','contact','login_name','email'], 'trim'],
            ['email','email'],
            ['login_name','unique','targetClass' => Users::className(), 'targetAttribute' => 'name']
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
     * Events Defined In frontened/components/Events
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
}