<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 12/8/15
 * Time: 6:06 PM
 */
namespace frontend\models\forms;

use frontend\components\EventHandler;
use frontend\components\Events;
use frontend\components\Reglobe;
use frontend\models\Dealers;
use yii\base\Exception;
use yii\base\Model;
use frontend\models\Users;

class DealerRegistrationForm extends Model{

    const DEALER_ROLE='DEALER_ROLE';

    public $name;
    public $city;
    public $contact;
    public $login_name;
    public $email;
    public $password;
    public $last_visited;
    public $last_login_ip;

    public function init(){
        $this->on(Events::CREATE_DEALER, [EventHandler::className(), 'RegisterDealer']);
    }

    //Model Rules
    public function rules(){
        return [
            [['name','city','contact','login_name','email','password'],'required'],
            [['name','city','contact','login_name','email'], 'trim'],
            ['email','email'],
            //['city','string','min' => 2,'message' => 'City Is Too Short',],
            ['login_name','unique','targetClass' => Users::className(), 'targetAttribute' => 'name']
        ];
    }

    //Model Attributes
    public function attributeLabels(){
        return [
            'name' => 'Dealer Name',
            'city' => 'City',
            'contact' => 'Contact Number',
            'login_name' => 'Username',
            'email' => 'Email',
            'password' => 'Password'
        ];
    }


    /**
     * trigger Event Assigned on Events::CREATE_DEALER
     * Events Defined In frontened/components/Events
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
            $transaction = Reglobe::$app->db->beginTransaction();
            try {
                $user=$this->SaveUser();

                if(!$user){
                    return null;
                }

                $dealer = new Dealers();
                $dealer->name = $this->city;
                $dealer->contact = $this->contact;
                $dealer->city = $this->city;
                $dealer->user=$user->primaryKey;

                if (!$dealer->save(false)) {
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


    // <editor-fold desc="Save User">

    private function SaveUser(){
        $user = new Users();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->last_login_ip = $this->last_login_ip;
        $user->last_login = $this->last_visited;
        $user->user_role=self::DEALER_ROLE;
        $user->contact=$this->contact;

        if (!$user->save(false)) {
            return null;
        }

        return $user;
    }
    // </editor-fold>

}