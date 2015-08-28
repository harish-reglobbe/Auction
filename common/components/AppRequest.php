<?php
namespace common\components;
use yii\web\Request;

class AppRequest extends Request{

	public $noCsrfValidationRoutes=array();
    public $source;
    public $dataVersion = 0;
    public $tagId;
    public $tagProduct;
    public $tagCategory;
    public $widgetApiKey;
    public $dataVersionEnabled;
    //------------------------------------------------------------------------------------------------------------------
    protected function normalizeRequest(){
        //attach event handlers for CSRFin the parent
        parent::normalizeRequest();
        //remove the event handler CSRF if this is a route we want skipped
        if($this->enableCsrfValidation){
            $url=Yii::app()->getUrlManager()->parseUrl($this);
            foreach($this->noCsrfValidationRoutes as $route){
                if(strpos($url,$route)===0)
                    Yii::app()->detachEventHandler('onBeginRequest',array($this,'validateCsrfToken'));
            }
        }
    }
    //------------------------------------------------------------------------------------------------------------------
    public function getIsSecureConnection(){
        //FOR NODE BALANCER
        $_protocol = (isset($_SERVER['HTTP_X_FORWARDED_PROTO']))?$_SERVER['HTTP_X_FORWARDED_PROTO']:false;
        if($_protocol && $_protocol == "https"){
            return true;
        }
        return parent::getIsSecureConnection();
    }
}