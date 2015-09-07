<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 4/9/15
 * Time: 3:42 PM
 */

namespace auction\models\forms;


use auction\components\Auction;
use auction\models\ProdConfName;
use auction\models\ProductConfig;
use yii\base\Exception;
use yii\base\Model;

class CreateProductConfig extends Model{

    public $typeName;

    public $name;

    public $cat_id;

    public function rules(){
        return [
            [['name','typeName','cat_id'] , 'required'],
        ];
    }


    public function attributeLabels(){
        return[
            'type' => 'Configuration Type Name',
            'name' => 'Configuration Name',
            'cat_id' => 'Category Name',
        ];
    }


    public function save(){

       if(!$this->validate()) {
           return false;
       }

        $transaction = Auction::$app->db->beginTransaction();
        try{
            $pro_conf_id = $this->saveProductConfig();

            if(!$pro_conf_id){
                return false;
            }

            if(!$this->saveProductConfName($pro_conf_id)){
                return false;
            }

            $transaction->commit();
            Auction::info('Product Config By User'.Auction::$app->user->id.' Successfully Created');
            return true;

        }catch (Exception $ex){
            $transaction->rollBack();
        }

    }

    public function saveProductConfig(){
        $model = new ProductConfig();
        $model->name = $this->typeName;
        $model->cat_id = $this->cat_id;
        $model->company = Auction::$app->session->get('user.company',0);

        if($model->save()){
            Auction::info('Product Config Save');
            return $model->primaryKey;
        }else{
            Auction::error('Product Config not saved due to following errors');
            return false;
        }
    }

    public function saveProductConfName($pro_conf_id){
        $model = new ProdConfName();
        $model->name = $this->name;
        $model->pro_conf_id = $pro_conf_id;


        if($model->save()){
            Auction::info('Product Config Name Saved');
            return $model->primaryKey;
        }else{
            Auction::error('Product Config Name not saved due to following errors');
            return true;
        }

    }

}