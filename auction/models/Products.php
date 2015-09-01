<?php

namespace auction\models;

use auction\components\helpers\DatabaseHelper;
use common\components\JAPI;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * This is the model class for collection "products".
 *
 * @property \MongoId|string $_id
 * @property mixed $id
 * @property mixed $product_id
 * @property mixed $name
 * @property mixed $image
 * @property mixed $brand_id
 * @property mixed $cat_id
 * @property mixed $lot_id
 * @property mixed $prize
 * @property mixed $condition
 * @property mixed $extra_cond
 * @property mixed $create_date
 */
class Products extends \yii\mongodb\ActiveRecord
{
    public $productCSV=null;
    private $_request;

    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return ['auction', 'products'];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'id',
            'product_id',
            'name',
            'image',
            'brand_id',
            'cat_id',
            'lot_id',
            'prize',
            'condition',
            'extra_cond',
            'create_date',
        ];
    }

    //"pn":"Product","img":"Image path","bi":Brand Id,"ci":CategoryId,"pri":Price,"c":"Condition","ec":"ExtraCondition"
    static $APIMask=['pn', 'img', 'bi', 'ci', 'pri', 'c', 'ec'];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'brand_id', 'cat_id', 'lot_id', 'prize',], 'required'],
            //['image' , 'file' ,'skipOnEmpty' => false],
            ['productCSV', 'file', 'extensions' => ['csv'], 'maxSize' => 1024*1024 ],
            [[ 'condition', 'extra_cond'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Id',
            'name' => 'Name',
            'image' => 'Image',
            'brand_id' => 'Brand',
            'cat_id' => 'Category',
            'lot_id' => 'Lot',
            'prize' => 'Prize',
            'condition' => 'Condition',
            'extra_cond' => 'Extra Condition',
        ];
    }


    /**  Save Product Model**/
    public function save($runValidation = true, $attributeNames = null){

        $this->doMasking();

        $request = new \HttpRequest(DatabaseHelper::JAVA_API_PRODUCT_URL, HTTP_METH_POST);
        $request->setRawPostData($this->_request);
        $request->send();
        $response = $request->getResponseBody();

        dump($response);

    }

    /**  Delete Models **/
    public static function deleteAll($condition = [], $options = []){

        //new HttpGet(API_URL+"/users/otp.json?pid=Xi32jNW0&pid=jl2S7dLp&pid=ycQOmNA3");
        $url=DatabaseHelper::JAVA_API_PRODUCT_URL;

        if(is_string($condition)){
            $url.='pid='.$condition;
        }
        elseif(is_array($condition)){
            foreach($condition as $pId){
                $url.='pid='.$pId.'&';
            }

            $url=substr($url,0,-1);
        }

        $client = new JAPI();
        $response=$client->process($url,JAPI::HTTP_METHOD_DELETE);
        dump($response);

    }


    /**
     * Upload CSV File
     */
    public function uploadCsvFile($data){

        $model = new Products();
        $products=[];

        foreach($data as $product){
            $model->setAttributes($product);

            if($model->validate()){
                $products=array_combine(self::$APIMask,$product);
            }
        }

        if(count($products) > 0){
            $client = new JAPI();
            $response=$client->process('http://http://192.168.1.42:8080/api',JAPI::HTTP_METHOD_GET,$products);
            dump($response);
        }
    }

    public function getCategory0(){
        return $this->hasOne(Categories::className(),['id' => 'cat_id']);
    }

    public function getBrand0(){
        return $this->hasOne(Brands::className(),['id' => 'brand_id']);
    }

    public function getLot0(){
        return $this->hasOne(Lots::className(),['id' => 'lot_id']);
    }

    public function beforeSave($insert){
        $this->doMasking();
        return parent::beforeSave($insert);
    }

    private function doMasking(){
        //'pn', 'img', 'bi', 'ci', 'pri', 'c', 'ec'
        $_request=$_data=[];

        $_request['pn']=$this->name;
        $_request['bi']=$this->brand_id;
        $_request['ci']=$this->cat_id;
        $_request['lot_id'] = $this->lot_id;
        $_request['pri']=$this->prize;
        $_request['c']=$this->condition;
        $_request['ec']=$this->extra_cond;

        $_data[] = $_request;

        $this->_request=Json::encode($_data);

    }


}
