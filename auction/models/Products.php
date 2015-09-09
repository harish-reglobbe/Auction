<?php

namespace auction\models;

use auction\components\Auction;
use auction\components\helpers\DatabaseHelper;
use auction\components\JAPI;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\helpers\ArrayHelper;
use yii\web\HttpException;
use yii\web\UploadedFile;
use Yii;
use yii\helpers\Json;
use auction\components\Events;
use auction\components\EventHandler;

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


    private $_categoryList;
    private $_brandList;
    private $_request;
    private $_response;
    private $_uploadDirectory;

    public function init(){
        $this->on(Events::UPLOAD_IMAGE, [EventHandler::className(), 'UploadImage']);
    }
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
            'category',
            'company',
            'sum',
            'brand',
            'summary',
            'quantity',
            'c_id'
        ];
    }

    //{"pi":"WVlATED","pn":"Product1","img":"Image path1","bi":1,"bn":"bn1""ci":1,"cn":"cn1","pri":22.02,"c":"Flawless",
    //"ec":"key1:value1||key2:value2", "pq":20,"cid":"cid1","company":"company1","sum":"sum1"}
    static $APIMask=['pn', 'img', 'pri', 'c', 'sum' , 'pq', 'bn' , 'bi' , 'cn' , 'cid' ,'company' , 'cid' , 'ec'];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'brand_id', 'cat_id', 'prize','condition' ,'summary','quantity'], 'required'],
            [['prize','quantity'] , 'integer', 'min' => 1],
            ['image', 'image'],
            ['productCSV', 'file', 'extensions' => ['csv'], 'maxSize' => 1024*1024 ],
            [[ 'extra_cond', 'brand' , 'category'], 'safe']
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
            'prize' => 'Prize',
            'condition' => 'Condition',
            'extra_cond' => 'Extra Condition',
        ];
    }


    /**  Save Product Model**/
    public function save($runValidation = true, $attributeNames = null){

        $this->image=UploadedFile::getInstance($this,'image');

        if(!parent::validate()){
            return false;
        }

        if($this->image instanceof UploadedFile){

            if(!getimagesize($this->image->tempName)){
                $this->addError('image','Please Upload a valid Image');
                Yii::error('Not a Valid Image Format For Product');
                return false;
            }

            $this->trigger(Events::UPLOAD_IMAGE);
            Yii::info('Trigger Upload Image Event for Products Photo');

        }

        $this->doMasking();


        $request = new JAPI();
        $response = $request->process(DatabaseHelper::JAVA_API_PRODUCT_URL,JAPI::HTTP_METHOD_POST,[],$this->_request,'application/json');



    }

    /**  Delete Models **/
    public static function deleteAll($condition = [], $options = []){

        //new HttpGet(API_URL+"/users/otp.json?pid=Xi32jNW0&pid=jl2S7dLp&pid=ycQOmNA3");
        $url='?';

        if(is_array($condition)){

            foreach($condition as $pId){
                $url.='pid='.$pId.'&';
            }

            $url=substr($url,0,-1);
        }

        $request = new JAPI();
        $response=$request->process(DatabaseHelper::JAVA_API_PRODUCT_URL.$url,JAPI::HTTP_METHOD_DELETE,[]);

        return Json::decode($response);

    }


    /**
     * Upload CSV File
     */
    public function uploadCsvFile($data){

        $products=[];

        foreach($data as $product){

            if($this->validate($product)){
                $products[] = $this->doMasking();

            }else{
               dump($this->getErrors());
            }

        }

        if(count($products) > 0){
            $this->_request=Json::encode($products);

            $client = new JAPI();
            $response=  $client->process(DatabaseHelper::JAVA_API_PRODUCT_URL,JAPI::HTTP_METHOD_POST,[],$this->_request,'application/json');
            return $this->parseResponse($response);

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
        $_request=[];

        $_request['pn']=$this->name;
        $_request['img']=$this->image;
        $_request['bi']=$this->brand_id;
        $_request['ci']=$this->cat_id;
        $_request['pri']=$this->prize;
        $_request['c']=$this->condition;
        $_request['ec']=$this->extra_cond;
        $_request['cid'] = Auction::company();
        $_request['company']=Auction::username();
        $_request['bn'] =$this->brand;
        $_request['cn'] = $this->category;
        $_request['sum'] = $this->summary;
        $_request['pq'] = $this->quantity;

        return $_request;

//        $this->_request=Json::encode($_data);

    }

    public function UploadDirectory(){

        if($this->_uploadDirectory === null){
            $this->_uploadDirectory = Auction::getAlias('@webroot').'/uploads/products/';
        }

        return $this->_uploadDirectory;

    }


    public function validate($data = null){

        $this->name=$data['Name'];
        $this->image=$data['Image'];
        $this->prize=$data['Price'];
        $this->condition=$data['Condition'];
        $this->summary=$data['Summary'];
        $this->quantity=$data['Quantity'];
        $this->brand=implode(array_slice($data, 7, 1),'');
        $this->brand_id = array_search($this->brand , $this->BrandList());
        $this->category=implode(array_slice($data, 6, 1),'');
        $this->cat_id = array_search($this->category , $this->CategoryList());
        $this->company= Auction::username();
        $this->c_id = Auction::company();

        $extraCondition = array_slice($data, 8 , count($data));

        $extraCond= '';

        foreach($extraCondition as $key=>$value){;
            $extraCond.=$key.':'.$value.'||';
        }

        $this->extra_cond = substr($extraCond, 0, -2);

        return parent::validate();
    }


    public function CategoryList(){
        if($this->_categoryList == null){
            $this->_categoryList = ArrayHelper::map(Categories::find()->asArray()->all(),'id','name');
        }

        return $this->_categoryList;
    }

    public function BrandList(){
        if($this->_brandList == null){
            $this->_brandList = Auction::dropDownList('auction\models\Brands' , 'id' ,'name');
        }

        return $this->_brandList;
    }

    private function parseResponse($response){
        try{
            $this->_response= Json::decode($response ,true);
        }catch (InvalidParamException $ex){
            throw new HttpException(400, 'Java Server Error');
        }

        if(array_key_exists('s' ,$this->_response)){
            return true;
        }else {
            return false;
        }
    }

}
