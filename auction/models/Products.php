<?php

namespace auction\models;

use auction\components\Auction;
use auction\components\helpers\DatabaseHelper;
use auction\components\JAPI;
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

    private $_request;
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
            [['name', 'brand_id', 'cat_id', 'prize','condition'], 'required'],
            ['prize' , 'integer', 'min' => 1],
            ['image', 'image'],
            ['productCSV', 'file', 'extensions' => ['csv'], 'maxSize' => 1024*1024 ],
            [[ 'extra_cond'], 'safe']
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
        $response=$request->process(DatabaseHelper::JAVA_API_PRODUCT_URL,JAPI::HTTP_METHOD_POST,[],$this->_request,'application/json');

        return Json::decode($response);


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
        echo DatabaseHelper::JAVA_API_PRODUCT_URL.$url;
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
                $products[]=ArrayHelper::merge(array_combine(self::$APIMask,$product),['cId' => Auction::company()]);
            }else{
                throw new HttpException(400, 'You Have An Error in Your Excel');
            }

        }

        dump($products);

        if(count($products) > 0){
            $this->_request=Json::encode($products);

            $client = new JAPI();
            return $client->process(DatabaseHelper::JAVA_API_PRODUCT_URL,JAPI::HTTP_METHOD_POST,[],$this->_request,'application/json');

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
        $_request['img']=$this->image;
        $_request['bi']=$this->brand_id;
        $_request['ci']=$this->cat_id;
        $_request['pri']=$this->prize;
        $_request['c']=$this->condition;
        $_request['ec']=$this->extra_cond;
        $_request['cId'] = Auction::company();

        $_data[] = $_request;

        $this->_request=Json::encode($_data);

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
        $this->brand_id=$data['Brand'];
        $this->condition=$data['Condition'];
        $this->extra_cond=$data['Extra Condition'];
        $this->cat_id=$data['Category'];
        $this->prize=$data['Prize'];

        return parent::validate();
    }

}
